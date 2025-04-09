<?php

namespace App\Filament\Mitienda\Resources;

use App\Filament\Mitienda\Resources\HojaCostosResource\Pages;
use App\Filament\Mitienda\Resources\HojaCostosResource\RelationManagers;
use App\Models\HojaCostos;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HojaCostosResource extends Resource
{
    protected static ?string $model = HojaCostos::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
    protected static ?string $label = 'Hoja de costos';

    protected static ?string $pluralLabel = 'Hojas de costos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->sortable(),
                Tables\Columns\TextColumn::make('margen')
                    ->label('Margen')
                    ->sortable(),
                Tables\Columns\TextColumn::make('costo_total')
                    ->label('Costo Total')
                    ->sortable(),
                Tables\Columns\TextColumn::make('costo_unitario')
                    ->label('Costo Unitario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),

                Action::make('export_pdf')
                ->label('Exportar PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function ($record) {
                    $pdf = Pdf::loadView('pdf.hoja-costos', [
                        'hoja' => $record,
                    ]);

                    return response()->streamDownload(
                        fn () => print($pdf->stream()),
                        'hoja-costos-' . $record->id . '.pdf'
                    );
                }),
            ])
            ->bulkActions([
                //Tables\Actions\BulkActionGroup::make([
                  //  Tables\Actions\DeleteBulkAction::make(),
                //]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHojaCostos::route('/'),
          //  'create' => Pages\CreateHojaCostos::route('/create'),
          //  'edit' => Pages\EditHojaCostos::route('/{record}/edit'),
        ];
    }
}
