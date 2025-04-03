<?php

namespace App\Filament\Mitienda\Resources\ProductoResource\Pages;

use App\Filament\Mitienda\Resources\ProductoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateProducto extends CreateRecord
{
    protected static string $resource = ProductoResource::class;
    public array $imagenesTemp = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->imagenesTemp = $data['imagenes_temp'] ?? [];
        unset($data['imagenes_temp']);

        // ✅ Obtener el corporativo asociado al usuario logueado
        $user = \Illuminate\Support\Facades\Auth::user();

        if (! $user->corporativo) {
            throw new \Exception('El usuario no está asociado a un corporativo.');
        }

        $data['corporativo_id'] = $user->corporativo->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->imagenesTemp)) {
            $imageKit = new \App\Services\ImageKitService();

            foreach ($this->imagenesTemp as $path) {
                $fullPath = storage_path("app/public/{$path}");

                if (file_exists($fullPath)) {
                    $url = $imageKit->upload("public/{$path}", 'productos');

                    if ($url) {
                        $this->record->imagenes()->create([
                            'imagen' => $url,
                        ]);

                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }
    }
}
