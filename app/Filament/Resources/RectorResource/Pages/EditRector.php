<?php

namespace App\Filament\Resources\RectorResource\Pages;

use App\Filament\Resources\RectorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRector extends EditRecord
{
    protected static string $resource = RectorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
