<?php

namespace App\Filament\Resources\Tp2gdGuides\Pages;

use App\Filament\Resources\Tp2gdGuides\Tp2gdGuideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTp2gdGuides extends ListRecords
{
    protected static string $resource = Tp2gdGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
