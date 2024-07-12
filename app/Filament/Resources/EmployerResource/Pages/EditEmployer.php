<?php

namespace App\Filament\Resources\EmployerResource\Pages;

use App\Filament\Resources\EmployerResource;
use App\Models\Employer;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditEmployer extends EditRecord
{
    protected static string $resource = EmployerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Mutate data before fill
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return EmployerResource::mutateDataBeforeFill($data);
    }

    /**
     * Handle the update process
     *
     * @param Model $record
     * @param array $data
     * @return Model
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        /** @var Employer $employer */
        $employer = $record;

        // Prepare the relationship data
        $userData = Arr::pull($data, 'user');
        $employerAddressData = Arr::pull($data, 'address');

        // Update user model
        $employer->user()->update($userData);

        // Update address model
        $employer->address()->update($employerAddressData);

        // Update employer model
        $employer->update($data);

        return $employer->refresh();
    }

    /**
     * Customize the update success notification title
     *
     * @return string|null
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return __('Employer data has been updated!');
    }
}
