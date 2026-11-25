<?php

namespace App\Filament\Resources\ArchiveContributions\Pages;

use App\Filament\Resources\ArchiveContributions\ArchiveContributionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArchiveContributions extends ListRecords
{
    protected static string $resource = ArchiveContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
