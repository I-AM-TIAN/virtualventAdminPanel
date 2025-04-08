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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('num_items')
                    ->label('Productos')
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListOrdens::route('/'),
            'create' => Pages\CreateOrden::route('/create'),
            'edit' => Pages\EditOrden::route('/{record}/edit'),
        ];
    }
}
