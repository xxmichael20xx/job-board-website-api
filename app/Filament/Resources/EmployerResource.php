<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployerResource\Pages;
use App\Models\Employer;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class EmployerResource extends Resource
{
    protected static ?string $model = Employer::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Account Details'))
                    ->description(__('Enter the details of the user account.'))
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->required(),
                        Forms\Components\TextInput::make('user.email')
                            ->required()
                            ->email()
                            ->unique('users', 'email', modifyRuleUsing: function (?Employer $employer, Unique $rule) {
                                if ($employer?->user) {
                                    $rule->ignore($employer->user->id);
                                }

                                return $rule;
                            }),
                        Forms\Components\TextInput::make('user.password')
                            ->required(fn (?Employer $employer): bool => !$employer?->id)
                            ->hidden(fn (?Employer $employer): bool => (bool)$employer?->id)
                            ->password()
                            ->revealable()
                            ->confirmed(),
                        Forms\Components\TextInput::make('user.password_confirmation')
                            ->required(fn (?Employer $employer): bool => !$employer?->id)
                            ->hidden(fn (?Employer $employer): bool => (bool)$employer?->id)
                            ->revealable()
                            ->password()
                    ]),
                Forms\Components\Section::make(__('Employer Details'))
                    ->description(__('Enter the details of the employer.'))
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('company')
                            ->label(__('Company Name'))
                            ->required()
                            ->unique('employers', 'company', ignoreRecord: true),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Employer / Company Email'))
                            ->required()
                            ->unique('employers', 'email', ignoreRecord: true),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpan(2)
                            ->rows(5),
                        Forms\Components\FileUpload::make('logo')
                            ->label(__('Company Logo'))
                            ->directory('employer/logo')
                            ->avatar()
                    ]),
                Forms\Components\Section::make(__('Employer Address'))
                    ->description(__('Enter the address of the employer.'))
                    ->columns()
                    ->schema([
                        Forms\Components\TextInput::make('address.street_1')
                            ->required(),
                        Forms\Components\TextInput::make('address.street_2'),
                        Forms\Components\TextInput::make('address.city')
                            ->required(),
                        Forms\Components\TextInput::make('address.state')
                            ->required(),
                        Forms\Components\TextInput::make('address.zip')
                            ->label(__('Zip Code / Postal Code'))
                            ->required(),
                        Forms\Components\TextInput::make('address.country')
                            ->required(),
                    ])
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle(__('Employer has been moved to archived!')),
                Tables\Actions\RestoreAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle(__('Employer has been restored!')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle(__('Selected Employers has been moved to archived!')),
                    Tables\Actions\RestoreBulkAction::make()
                        ->successNotificationTitle(__('Selected Employers has been restored!')),
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
            'index' => Pages\ListEmployers::route('/'),
            'create' => Pages\CreateEmployer::route('/create'),
            'view' => Pages\ViewEmployer::route('/{record}'),
            'edit' => Pages\EditEmployer::route('/{record}/edit'),
        ];
    }

    /**
     * Mutate data before fill
     *
     * @param array $data
     * @return array
     */
    public static function mutateDataBeforeFill(array $data): array
    {
        /** @var Employer $employer */
        $employer = Employer::query()
            ->findOrFail(data_get($data, 'id'));

        data_set($data, 'user', $employer->user);
        data_set($data, 'address', $employer->address);

        return $data;
    }
}
