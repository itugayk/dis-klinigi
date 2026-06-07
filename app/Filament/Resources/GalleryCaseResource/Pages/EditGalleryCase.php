<?php

namespace App\Filament\Resources\GalleryCaseResource\Pages;

use App\Filament\Resources\GalleryCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalleryCase extends EditRecord
{
    protected static string $resource = GalleryCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
