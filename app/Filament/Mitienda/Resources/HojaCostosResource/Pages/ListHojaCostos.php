<?php

namespace App\Filament\Mitienda\Resources\HojaCostosResource\Pages;

use App\Filament\Mitienda\Resources\HojaCostosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHojaCostos extends ListRecords
{
    protected static string $resource = HojaCostosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
