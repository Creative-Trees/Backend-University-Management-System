<?php

namespace App\Filament\Resources\RectorResource\Pages;

use App\Filament\Resources\RectorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRectors extends ListRecords
{
    protected static string $resource = RectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
