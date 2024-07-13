<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

    /**
     * Customize the success creation notification title
     *
     * @return string|null
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return __('New Job has been created!');
    }
}
