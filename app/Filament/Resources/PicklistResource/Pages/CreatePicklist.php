<?php

namespace App\Filament\Resources\PicklistResource\Pages;

use App\Filament\Resources\PicklistResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePicklist extends CreateRecord
{
    protected static string $resource = PicklistResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('Successfully created a new Picklist!');
    }
}
