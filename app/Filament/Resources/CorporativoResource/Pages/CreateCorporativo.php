<?php

namespace App\Filament\Resources\CorporativoResource\Pages;

use App\Filament\Resources\CorporativoResource;
use App\Models\User;
use App\Notifications\CredencialesCorporativo;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

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
