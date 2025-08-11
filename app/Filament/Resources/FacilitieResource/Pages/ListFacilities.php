<?php

namespace App\Filament\Resources\FacilitieResource\Pages;

use App\Filament\Resources\FacilitieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacilities extends ListRecords
{
    protected static string $resource = FacilitieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
