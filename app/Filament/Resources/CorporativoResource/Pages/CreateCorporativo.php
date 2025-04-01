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

    /**
     * Se ejecuta antes de guardar el Corporativo
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $password = Str::password(12);
        $email = $data['email'];

        // 👤 Crear el usuario
        $user = User::create([
            'name' => $data['razon_social'],
            'email' => $email,
            'password' => Hash::make($password),
            'tipousuario_id' => 2,
        ]);

        // 🧠 Guardar temporalmente para afterCreate()
        $this->userTemp = $user;
        $this->passwordTemp = $password;

        // Asociar user al corporativo
        $data['user_id'] = $user->id;

        // ✅ SUBIR LOGO A IMGBB
    if (isset($data['logo_temp'])) {
        $path = $data['logo_temp'];
        $imageContent = Storage::disk('local')->get($path); // default disk
        $base64Image = base64_encode($imageContent);

        $response = Http::asForm()->post('https://api.imgbb.com/1/upload', [
            'key' => env('IMGBB_API_KEY'),
            'image' => $base64Image,
        ]);

        if ($response->successful()) {
            $data['logo'] = $response->json('data.url'); // URL pública
        } else {
            throw new \Exception('No se pudo subir la imagen a ImgBB');
        }

        // Limpiar archivo temporal
        Storage::delete($path);
    }

    // Quitar campo temporal
    unset($data['logo_temp']);

    return $data;

        return $data;
    }

    protected function afterCreate():void{
        if ($this->userTemp && $this->passwordTemp) {
            $this->userTemp->notify(new CredencialesCorporativo(
                $this->userTemp->email,
                $this->passwordTemp
            ));
        }
    }
}
