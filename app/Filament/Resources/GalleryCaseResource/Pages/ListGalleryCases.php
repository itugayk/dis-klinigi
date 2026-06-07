<?php

namespace App\Filament\Resources\GalleryCaseResource\Pages;

use App\Filament\Resources\GalleryCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalleryCases extends ListRecords
{
    protected static string $resource = GalleryCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
