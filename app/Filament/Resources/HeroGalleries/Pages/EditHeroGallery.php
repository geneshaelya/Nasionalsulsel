<?php

namespace App\Filament\Resources\HeroGalleries\Pages;

use App\Filament\Resources\HeroGalleries\HeroGalleryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeroGallery extends EditRecord
{
    protected static string $resource = HeroGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
