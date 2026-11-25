<?php

namespace App\Filament\Resources\HistoricalSites\Pages;

use App\Filament\Resources\HistoricalSites\HistoricalSiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHistoricalSites extends ListRecords
{
    protected static string $resource = HistoricalSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
