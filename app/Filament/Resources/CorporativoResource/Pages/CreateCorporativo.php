<?php

namespace App\Filament\Resources\CorporativoResource\Pages;

use App\Filament\Resources\CorporativoResource;
use App\Models\User;
use App\Notifications\CredencialesCorporativo;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CreateCorporativo extends CreateRecord
{
    protected static string $resource = CorporativoResource::class;

    protected ?User $userTemp = null;
    protected ?string $passwordTemp = null;
    protected ?string $logoTempPath = null;

    /**
     * Se ejecuta antes de guardar el Corporativo
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['logo_temp'])) {
            $path = is_array($data['logo_temp']) ? $data['logo_temp'][0] : $data['logo_temp'];
            $fullPath = storage_path("app/public/{$path}");

            if (!file_exists($fullPath)) {
                throw new \Exception("El archivo no existe: {$fullPath}");
            }

            $imageKit = new \App\Services\ImageKitService();
            $url = $imageKit->upload("public/{$path}");

            if (!$url) {
                throw new \Exception("No se pudo subir el logo a ImageKit.");
            }

            $data['logo'] = $url;
            $this->logoTempPath = $path;
        }

        unset($data['logo_temp']);

        if (empty($data['logo'])) {
            throw new \Exception("El campo logo es obligatorio.");
        }

        // Usuario relacionado
        $password = Str::password(12);
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['razon_social'],
                'password' => Hash::make($password),
                'tipousuario_id' => 2,
            ]
        );

        $data['user_id'] = $user->id;

        if ($user->wasRecentlyCreated) {
            $this->userTemp = $user;
            $this->passwordTemp = $password;
        }

        return $data;
    }


    protected function afterCreate(): void
    {
        if ($this->logoTempPath && Storage::disk('public')->exists($this->logoTempPath)) {
            Storage::disk('public')->delete($this->logoTempPath);
        }

        if ($this->userTemp && $this->passwordTemp) {
            $this->userTemp->notify(new CredencialesCorporativo(
                $this->userTemp->email,
                $this->passwordTemp
            ));
        }
    }
}
