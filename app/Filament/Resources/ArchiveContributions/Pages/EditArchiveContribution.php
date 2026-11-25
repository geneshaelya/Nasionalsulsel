<?php

namespace App\Filament\Resources\ArchiveContributions\Pages;

use App\Filament\Resources\ArchiveContributions\ArchiveContributionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArchiveContribution extends EditRecord
{
    protected static string $resource = ArchiveContributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
