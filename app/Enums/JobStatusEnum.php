<?php

namespace App\Enums;

enum JobStatusEnum: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case EXPIRED = 3;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            default => 'Expired'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            default => 'secondary'
        };
    }
}
