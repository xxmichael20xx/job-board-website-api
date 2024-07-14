<?php

namespace App\Enums;

enum JobStatusEnum: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case EXPIRED = 3;
    case COMPLETED = 4;

    public static function options(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::APPROVED->value => 'Approved',
            self::REJECTED->value => 'Rejected',
            self::COMPLETED->value => 'Completed',
            self::REJECTED->value => 'Expired'
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::COMPLETED => 'Completed',
            default => 'Expired'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED, self::COMPLETED => 'success',
            self::REJECTED => 'danger',
            default => 'secondary'
        };
    }

    public function getStatuses(): array
    {
        return match ($this) {
            self::PENDING => [
                self::APPROVED->value => 'Approve',
                self::REJECTED->value => 'Reject'
            ],
            default => [
                self::COMPLETED->value => 'Complete'
            ]
        };
    }
}
