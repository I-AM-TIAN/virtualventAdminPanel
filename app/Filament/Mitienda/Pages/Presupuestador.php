<?php

namespace App\Filament\Mitienda\Pages;

use App\Models\HojaCostos;
use Dom\Text;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Illuminate\Support\HtmlString;

class Presupuestador extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static string $view = 'filament.mitienda.pages.presupuestador';

    public ?array $formData = [];

    public function mount(): void
    {
        if (empty($this->formData)) {
            $this->formData = [
                'materiales' => [['descripcion' => '', 'costo' => 0]],
                'labores'     => [['descripcion' => '', 'costo' => 0]],
                'indirectos'  => [['descripcion' => '', 'costo' => 0]],
                'cantidad'  => 1,
                'margen'    => 0,
            ];
        }
        $this->form->fill($this->formData);
    }

    protected function getFormStatePath(): string
    {
        return 'formData';
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                //Datos generales del producto
                Step::make('Datos generales')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del producto')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('cantidad')
                            ->label('Cantidad producida')
                            ->numeric()
                            ->required(),

                        TextInput::make('margen')
                            ->label('Margen de ganancia esperado (%)')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(2),

                //Gastos de materiales
                Step::make('Gastos de materiales')
                    ->schema([
                        Repeater::make('materiales')
                            ->label('Listado de materiales adquiridos para el producto')
                            ->addActionLabel('Agregar material')
                            ->grid(false)
                            ->columns(12)
                            ->schema([
                                TextInput::make('descripcion')
                                    ->label('Descripción')
                                    ->columnSpan(8),
                                TextInput::make('costo')
                                    ->label('Costo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->columnSpan(4),
                            ])
                            ->default([
                                ['descripcion' => '', 'costo' => 0],
                            ])
                            ->itemLabel(fn($state) => $state['descripcion'] ?? 'Material'),
                    ]),

                //Gastos de mano de obra
                Step::make('Mano de obra')
                    ->schema([
                        Repeater::make('labores')
                            ->label('Gastos de mano de obra directa')
                            ->addActionLabel('Agregar mano de obra')
                            ->grid(false)
                            ->columns(12)
                            ->schema([
                                TextInput::make('descripcion')
                                    ->label('Descripción')
                                    ->columnSpan(8),
                                TextInput::make('costo')
                                    ->label('Costo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->columnSpan(4),
                            ])
                            ->default([
                                ['descripcion' => '', 'costo' => 0],
                            ])
                            ->itemLabel(fn($state) => $state['descripcion'] ?? 'Mano de obra'),
                    ]),

                //Gastos indirectos
                Step::make('Costos indirectos')
                    ->schema([
                        Repeater::make('indirectos')
                            ->label('Gastos indirectos')
                            ->addActionLabel('Agregar gasto indirecto')
                            ->grid(false)
                            ->columns(12)
                            ->schema([
                                TextInput::make('descripcion')
                                    ->label('Descripción')
                                    ->columnSpan(8),
                                TextInput::make('costo')
                                    ->label('Costo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->columnSpan(4),
                            ])
                            ->default([
                                ['descripcion' => '', 'costo' => 0],
                            ])
                            ->itemLabel(fn($state) => $state['descripcion'] ?? 'Gasto indirecto'),
                    ]),

                //Resumen
                Step::make('Resumen de gastos')
                    ->schema([
                        View::make('filament.mitienda.pages.resumen')
                            ->viewData([
                                'nombre' => $this->formData['nombre'] ?? '',
                                'cantidad' => $this->formData['cantidad'] ?? 0,
                                'margen' => $this->formData['margen'] ?? 0,
                                'materiales' => $this->formData['materiales'] ?? [],
                                'labores' => $this->formData['labores'] ?? [],
                                'indirectos' => $this->formData['indirectos'] ?? [],
                                'totalMateriales' => $this->getCategoryTotal('materiales'),
                                'totalLabores' => $this->getCategoryTotal('labores'),
                                'totalIndirectos' => $this->getCategoryTotal('indirectos'),
                                'total' => $this->getTotalCost(),
                                'unitPrice' => $this->getUnitPrice(),
                            ]),
                    ]),
            ])->submitAction(
                new HtmlString(Blade::render(<<<'BLADE'
                    <x-filament::button
                        type="button"
                        size="sm"
                        color="success"
                        wire:click="submit"
                    >
                        Guardar presupuesto
                    </x-filament::button>
                BLADE))
            )
        ];
    }

    public function getCategoryTotal(string $key): float
    {
        return collect($this->formData[$key] ?? [])
            ->sum(fn($item) => floatval($item['costo'] ?? 0));
    }

    public function getTotalCost(): float
    {
        return $this->getCategoryTotal('materiales')
            + $this->getCategoryTotal('labores')
            + $this->getCategoryTotal('indirectos');
    }

    public function getUnitPrice(): float
    {
        $quantity = intval($this->formData['cantidad'] ?? 0);
        if ($quantity <= 0) return 0;

        $base = $this->getTotalCost() / $quantity;
        $margin = floatval($this->formData['margen'] ?? 0);

        return $base * (1 + $margin / 100);
    }

    public function submit(): void
    {
        $corporativoId = Auth::user()?->corporativo?->id;

        $this->form->validate();

        $data = $this->form->getState();
        
        HojaCostos::create([
            'nombre' => $data['nombre'],
            'cantidad' => $data['cantidad'],
            'margen' => $data['margen'],
            'materiales' => $data['materiales'],
            'labores' => $data['labores'],
            'indirectos' => $data['indirectos'],
            'costo_total' => $this->getTotalCost(),
            'costo_unitario' => $this->getUnitPrice(),
            'corporativo_id' => $corporativoId,
        ]);

        Notification::make()
            ->title('Hoja de costos guardada correctamente ✅')
            ->success()
            ->send();

        $this->redirect(static::getUrl());
    }
}
