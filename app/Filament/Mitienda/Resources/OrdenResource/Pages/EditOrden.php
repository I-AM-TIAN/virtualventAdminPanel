<?php

namespace App\Filament\Mitienda\Resources\OrdenResource\Pages;

use App\Filament\Mitienda\Resources\OrdenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrden extends EditRecord
{
    protected static string $resource = OrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
