<?php

namespace App\Filament\Resources\CorporativoResource\Pages;

use App\Filament\Resources\CorporativoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorporativo extends EditRecord
{
    protected static string $resource = CorporativoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
