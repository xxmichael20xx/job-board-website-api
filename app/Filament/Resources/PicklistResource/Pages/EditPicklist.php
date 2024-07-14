<?php

namespace App\Filament\Resources\PicklistResource\Pages;

use App\Filament\Resources\PicklistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPicklist extends EditRecord
{
    protected static string $resource = PicklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
