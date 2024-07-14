<?php

namespace App\Filament\Resources\UserApiTokenResource\Pages;

use App\Filament\Resources\UserApiTokenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserApiToken extends EditRecord
{
    protected static string $resource = UserApiTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
