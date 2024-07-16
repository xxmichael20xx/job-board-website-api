<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use App\Models\Job;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        /** @var Job $job */
        $job = static::getModel()::create($data);

        // Attach skills
        $job->skills()->sync(data_get($data, 'skills', []));

        return $job->refresh();
    }

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
