<?php

namespace App\Filament\Resources\UserApiTokenResource\Pages;

use App\Filament\Resources\UserApiTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserApiToken extends CreateRecord
{
    protected static string $resource = UserApiTokenResource::class;
}
