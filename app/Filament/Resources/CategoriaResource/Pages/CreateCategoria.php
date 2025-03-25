<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use App\Filament\Resources\CategoriaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;


class CreateCategoria extends CreateRecord
{
    protected static string $resource = CategoriaResource::class;

    /**
     * Modify the form data before the record is created.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Asigna el ID del usuario autenticado
        return $data;
    }
}
