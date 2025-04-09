<?php

namespace App\Filament\Mitienda\Resources\HojaCostosResource\Pages;

use App\Filament\Mitienda\Resources\HojaCostosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHojaCostos extends EditRecord
{
    protected static string $resource = HojaCostosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
