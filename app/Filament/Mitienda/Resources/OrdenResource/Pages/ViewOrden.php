<?php

namespace App\Filament\Mitienda\Resources\OrdenResource\Pages;

use App\Filament\Mitienda\Resources\OrdenResource;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use App\Models\Orden;

class ViewOrden extends Page
{
    protected static string $resource = OrdenResource::class;

    protected static string $view = 'filament.mitienda.resources.orden-resource.pages.view-orden';

    public $record;

    public function mount(Orden $record): void
    {
        $this->record = $record;
    }
}
