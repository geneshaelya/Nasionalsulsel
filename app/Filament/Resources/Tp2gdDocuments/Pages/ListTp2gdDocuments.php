<?php

namespace App\Filament\Resources\Tp2gdDocuments\Pages;

use App\Filament\Resources\Tp2gdDocuments\Tp2gdDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTp2gdDocuments extends ListRecords
{
    protected static string $resource = Tp2gdDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
