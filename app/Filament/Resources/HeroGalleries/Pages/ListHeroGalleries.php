<?php

namespace App\Filament\Resources\HeroGalleries\Pages;

use App\Filament\Resources\HeroGalleries\HeroGalleryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeroGalleries extends ListRecords
{
    protected static string $resource = HeroGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
