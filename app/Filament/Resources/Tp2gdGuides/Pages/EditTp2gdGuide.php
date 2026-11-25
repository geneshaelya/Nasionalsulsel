<?php

namespace App\Filament\Resources\Tp2gdGuides\Pages;

use App\Filament\Resources\Tp2gdGuides\Tp2gdGuideResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTp2gdGuide extends EditRecord
{
    protected static string $resource = Tp2gdGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
