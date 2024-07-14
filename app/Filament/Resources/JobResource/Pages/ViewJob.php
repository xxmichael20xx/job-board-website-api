<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Enums\JobStatusEnum;
use App\Filament\Resources\JobResource;
use App\Models\Job;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewJob extends ViewRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('updateStatus')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('status')
                        ->required()
                        ->options(function (Job $job): array
                        {
                            return JobStatusEnum::from($job->status)->getStatuses();
                        }
                    )
                ])
                ->requiresConfirmation()
                ->action(function (array $data, Job $job): void {
                    // new status
                    $status = (int) data_get($data, 'status');

                    // Update the status
                    $job->update([
                        'status' => $status,
                    ]);

                    // Refresh the Job
                    $job->refresh();
                    $this->refreshFormData([
                        'status'
                    ]);

                    // Send notification
                    Notification::make('success')
                        ->title(__('Job status has been updated!'))
                        ->success()
                        ->send();
                })
                ->hidden(fn (Job $job): bool => in_array($job->status, [
                    JobStatusEnum::REJECTED->value,
                    JobStatusEnum::COMPLETED->value,
                ]))
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var Job $job */
        $job = Job::query()->find(data_get($data, 'id'));

        // Set the selected skills
        $skills = $job->skills()
            ->pluck('picklist_item_id')
            ->toArray();
        data_set($data, 'skills', $skills);

        return $data;
    }
}
