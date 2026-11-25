<?php

namespace App\Filament\Resources\HistoricalSites\Pages;

use App\Filament\Resources\HistoricalSites\HistoricalSiteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHistoricalSite extends EditRecord
{
    protected static string $resource = HistoricalSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
