<?php

namespace App\Filament\Mitienda\Resources;

use App\Filament\Mitienda\Resources\ProductoResource\Pages;
use App\Filament\Mitienda\Resources\ProductoResource\RelationManagers;
use App\Models\Categoria;
use App\Models\Producto;
use Filament\Facades\Filament;
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
                Forms\Components\TextInput::make('unidad')
                    ->label('Unidad')
                    ->required()
                    ->placeholder('Ej: kilogramo, libra, unidad, etc.'),
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
                Tables\Columns\ImageColumn::make('imagenes.0.imagen') // usa la primera imagen
                    ->label('Foto')
                    ->circular()
                    ->height(50)
                    ->width(50)
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Estado')
                    ->getStateUsing(function ($record) {
                        return $record->deleted_at ? 'Inactivo' : 'Activo';
                    })
                    ->colors([
                        'success' => 'Activo',
                        'danger' => 'Inactivo',
                    ]),
                Tables\Columns\TextColumn::make('precio')
                    ->label('Precio')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unidad')
                    ->label('Unidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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

    public static function getEloquentQuery(): Builder
    {
        $user = Filament::auth()->user();
        $corporativoId = $user->corporativo->id ?? null;

        return parent::getEloquentQuery()
            ->withTrashed()
            ->when($corporativoId, function (Builder $query) use ($corporativoId) {
                $query->where('corporativo_id', $corporativoId);
            });
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
