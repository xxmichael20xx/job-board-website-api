<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    const ADMIN = 'Admin';
    const EMPLOYER = 'Employer';
    const JOB_SEEKER = 'Job Seeker';
}
