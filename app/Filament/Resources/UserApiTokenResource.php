<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserApiTokenResource\Pages;
use App\Filament\Resources\UserApiTokenResource\RelationManagers;
use App\Models\User;
use App\Models\UserApiToken;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserApiTokenResource extends Resource
{
    protected static ?string $model = UserApiToken::class;

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('User selection'))
                    ->columnSpan(2)
                    ->required()
                    ->multiple()
                    ->searchable()
                    ->options(function (): array {
                        $userWithApiTokens = UserApiToken::query()
                            ->pluck('tokenable_id')
                            ->toArray();

                        return User::query()
                            ->whereNotIn('id', $userWithApiTokens)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete user API Token?')
                    ->successNotificationTitle(__('User api token has been deleted!'))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete selected API Tokens?')
                        ->successNotificationTitle(__('Selected user API token has been deleted!')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserApiTokens::route('/'),
            'edit' => Pages\EditUserApiToken::route('/{record}/edit'),
        ];
    }
}
