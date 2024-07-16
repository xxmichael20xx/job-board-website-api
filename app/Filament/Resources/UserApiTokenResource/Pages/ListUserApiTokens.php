<?php

namespace App\Filament\Resources\UserApiTokenResource\Pages;

use App\Filament\Resources\UserApiTokenResource;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUserApiTokens extends ListRecords
{
    protected static string $resource = UserApiTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('md')
                ->action(function (array $data): void {
                    $ids = data_get($data, 'user_id', []);

                    foreach ($ids as $id) {
                        /** @var User $user */
                        $user = User::query()->find($id);

                        // Create the token
                        $user->createToken('account-creation', expiresAt: Carbon::now()->addHour());
                    }

                    // Send success notification
                    Notification::make()
                        ->title(__('Successfully create user API tokens!'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
