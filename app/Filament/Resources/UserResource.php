<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->required(fn (?User $user): bool => ! $user->id)
                    ->readOnly(fn (?User $user): bool => (bool) $user->id)
                    ->password()
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->required(fn (?User $user): bool => ! $user->id)
                    ->readOnly(fn (?User $user): bool => (bool) $user->id)
                    ->password(),
                Forms\Components\Select::make('roles')
                    ->required()
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->relationship('roles', 'name'),
                Forms\Components\Toggle::make('createToken')
                    ->columnSpan(2)
                    ->hidden(fn (User $user): bool => $user->id != null)
            ]);
    }

    public static function table(Table $table): Table
    {
        $adminIds = self::getAdminIds();

        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereNotIn('id', $adminIds))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->limit(25)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    /**
     * Get the id of the non-admin users
     *
     * @return array
     */
    public static function getAdminIds(): array
    {
        return collect(User::all())
            /**
             * @var User $user
             * @return int|void
             */
            ->map(function (User $user) {
                if ($user->hasRole([Role::ADMIN])) {
                    return $user->id;
                }
            })
            ->filter()
            ->toArray();
    }
}
