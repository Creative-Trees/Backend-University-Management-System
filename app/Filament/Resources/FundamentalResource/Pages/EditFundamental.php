<?php

namespace App\Filament\Resources\FundamentalResource\Pages;

use App\Filament\Resources\FundamentalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFundamental extends EditRecord
{
    protected static string $resource = FundamentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
