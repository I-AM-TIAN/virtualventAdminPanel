<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CorporativoResource\Pages;
use App\Filament\Resources\CorporativoResource\RelationManagers;
use App\Models\Corporativo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CorporativoResource extends Resource
{
    protected static ?string $model = Corporativo::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $label = 'Corporativo';
    protected static ?string $pluralLabel = 'Corporativos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nit')
                    ->label('NIT')
                    ->required()
                    ->unique()
                    ->numeric()
                    ->minLength(9)
                    ->maxLength(9),
                Forms\Components\TextInput::make('razon_social')
                    ->label('Razón Social')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('logo_temp')
                    ->label('Logo')
                    ->image()
                    ->required()
                    ->maxSize(2048)
                    ->preserveFilenames(true)
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->directory('temp-logos')
                    ->visibility('private'), // no se usa directamente
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->minLength(10)
                    ->maxLength(10)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Fieldset::make('Dirección')
                    ->relationship('direccion') // Relación hasOne
                    ->schema([
                        // 🌎 País
                        Forms\Components\Select::make('pais_id')
                            ->label('País')
                            ->relationship('pais', 'nombre')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('departamento_id', null)),

                        // 🏛️ Departamento
                        Forms\Components\Select::make('departamento_id')
                            ->label('Departamento')
                            ->options(function (callable $get) {
                                $paisId = $get('pais_id');
                                return $paisId
                                    ? \App\Models\Departamento::where('pais_id', $paisId)->pluck('nombre', 'id')
                                    : [];
                            })
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('ciudad_id', null)),

                        // 🏙️ Ciudad
                        Forms\Components\Select::make('ciudad_id')
                            ->label('Ciudad')
                            ->options(function (callable $get) {
                                $departamentoId = $get('departamento_id');
                                return $departamentoId
                                    ? \App\Models\Ciudad::where('departamento_id', $departamentoId)->pluck('nombre', 'id')
                                    : [];
                            })
                            ->required(),

                        // 🛣️ Detalle de la dirección
                        Forms\Components\TextInput::make('detalle')
                            ->label('Detalle')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nit')
                    ->label('NIT')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('razon_social')
                    ->label('Razón Social')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha de actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withTrashed();
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
            'index' => Pages\ListCorporativos::route('/'),
            'create' => Pages\CreateCorporativo::route('/create'),
            'edit' => Pages\EditCorporativo::route('/{record}/edit'),
        ];
    }
}
