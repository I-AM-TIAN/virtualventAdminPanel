<?php

namespace App\Filament\Mitienda\Resources;

use App\Filament\Mitienda\Resources\OrdenResource\Pages;
use App\Filament\Mitienda\Resources\OrdenResource\RelationManagers;
use App\Models\Orden;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdenResource extends Resource
{
    protected static ?string $model = Orden::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->required()
                            ->numeric()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('num_items')
                            ->label('Productos')
                            ->required()
                            ->numeric()
                            ->maxLength(255),

                        Forms\Components\Toggle::make('pagado')
                            ->label('Estado del pago')
                            ->required(),

                        Forms\Components\DatePicker::make('fecha_pago')
                            ->label('Fecha del pago')
                            ->required(),
                    ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('uuid')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('pagado')
                    ->badge()
                    ->label('Estado del pago')
                    ->getStateUsing(function ($record) {
                        return $record->pagado ? 'Pagado' : 'Sin pagar';
                    })
                    ->colors([
                        'success' => 'Pagado',
                        'danger' => 'Sin pagar',
                    ]),

                Tables\Columns\TextColumn::make('fecha_pago')
                    ->label('Fecha del pago')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Ver detalle')
                    ->url(fn($record) => static::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListOrdens::route('/'),
            'view' => Pages\ViewOrden::route('/{record}'),
        ];
    }
}
