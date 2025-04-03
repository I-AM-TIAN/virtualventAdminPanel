<?php

namespace App\Filament\Mitienda\Resources;

use App\Filament\Mitienda\Resources\ProductoResource\Pages;
use App\Filament\Mitienda\Resources\ProductoResource\RelationManagers;
use App\Models\Categoria;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripción')
                    ->required(),
                Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('precio')
                    ->label('Precio')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('categoria_id')
                    ->label('Categoría')
                    ->options(
                        Categoria::all()->pluck('nombre', 'id')
                    )
                    ->relationship('categoria', 'nombre')
                    ->required(),
                Forms\Components\FileUpload::make('imagenes_temp')
                    ->label('Fotos del producto')
                    ->multiple()
                    ->image()
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->directory('temp-productos')
                    ->disk('public')
                    ->storeFiles()
                    ->required(fn($livewire) => $livewire instanceof CreateRecord)
                    ->helperText('Podés subir varias imágenes. El orden no afecta.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
