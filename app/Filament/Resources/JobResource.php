<?php

namespace App\Filament\Resources;

use App\Enums\JobStatusEnum;
use App\Filament\Resources\JobResource\Pages;
use App\Models\Employer;
use App\Models\Job;
use Carbon\Carbon;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Job Details'))
                    ->description(__('Enter the complete job details below.'))
                    ->columns()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('employer_id')
                                    ->required()
                                    ->options(fn (): array => Employer::withoutTrashed()->pluck('company', 'id')->toArray())
                                    ->searchable()
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->unique('jobs', 'title', ignoreRecord: true),
                        Forms\Components\Select::make('expected_salary')
                            ->required()
                            ->options(fn (): array => collect(Job::salaryRange())->mapWithKeys(function ($item) {
                                return [$item => $item];
                            })->flatten()->toArray()),
                        Forms\Components\TextInput::make('vacancy')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Forms\Components\DatePicker::make('expire_at')
                            ->required()
                            ->minDate(Carbon::now()->addDays(7)),
                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Toggle::make('requires_resume')
                            ->default(false),
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
                Tables\Columns\TextColumn::make('employer.company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (Job $job): string => JobStatusEnum::from((int) $job->status)->color())
                    ->formatStateUsing(fn (Job $job): string => JobStatusEnum::from((int) $job->status)->label())
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle(__('Job has been moved to archived!')),
                Tables\Actions\RestoreAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle(__('Job has been restored!')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle(__('Selected Job has been moved to archived!')),
                    Tables\Actions\RestoreBulkAction::make()
                        ->successNotificationTitle(__('Selected Job has been restored!')),
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'view' => Pages\ViewJob::route('/{record}'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
