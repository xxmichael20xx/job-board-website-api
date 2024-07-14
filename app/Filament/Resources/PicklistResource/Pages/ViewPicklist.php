<?php

namespace App\Filament\Resources\PicklistResource\Pages;

use App\Filament\Resources\PicklistResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPicklist extends ViewRecord
{
    protected static string $resource = PicklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
