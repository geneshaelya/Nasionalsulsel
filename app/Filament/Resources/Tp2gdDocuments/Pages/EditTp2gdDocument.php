<?php

namespace App\Filament\Resources\Tp2gdDocuments\Pages;

use App\Filament\Resources\Tp2gdDocuments\Tp2gdDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTp2gdDocument extends EditRecord
{
    protected static string $resource = Tp2gdDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
