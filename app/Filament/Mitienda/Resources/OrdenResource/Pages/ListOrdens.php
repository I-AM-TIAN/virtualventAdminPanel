<?php

namespace App\Filament\Mitienda\Resources\OrdenResource\Pages;

use App\Filament\Mitienda\Resources\OrdenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdens extends ListRecords
{
    protected static string $resource = OrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
