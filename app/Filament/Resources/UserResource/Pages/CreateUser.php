<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Customize the user creation process
     *
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        /** @var User $user */
        $user = static::getModel()::create($data);

        // check if create a token after creation
        if (data_get($data, 'createToken')) {
            $user->createToken('account-creation');
        }

        return $user;
    }

    /**
     * Customize the create notification title
     *
     * @return string|null
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return __('New user has been created!');
    }
}
