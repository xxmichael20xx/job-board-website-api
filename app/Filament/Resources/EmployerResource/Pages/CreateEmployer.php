<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use App\Filament\Resources\EmployerResource;
use App\Models\Employer;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateEmployer extends CreateRecord
{
    protected static string $resource = EmployerResource::class;

    /**
     * Handle the creation of employer with relationships
     *
     * @param array $data
     * @return Employer
     */
    protected function handleRecordCreation(array $data): Employer
    {
        // Prepare the relationship data
        $userData = Arr::pull($data, 'user');
        $employerAddressData = Arr::pull($data, 'address');

        // Create user
        /** @var User $user */
        $user = User::query()->create($userData);

        // Create employer
        /** @var Employer $employer */
        $employer = $user->employer()->create($data);

        // Create employer address
        $employer->address()->create($employerAddressData);

        return $employer->refresh();
    }

    /**
     * Customize the success creation notification title
     *
     * @return string|null
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return __('New Employer has been created!');
    }
}
