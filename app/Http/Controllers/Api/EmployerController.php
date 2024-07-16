<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\JsonResponse;

class EmployerController extends Controller
{
    /**
     * Get a list of paginated employers
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $employers = Employer::query()
            ->withCount(['jobs'])
            ->with(['address', 'jobs.skills'])
            ->paginate(10);

        return $this->success($employers);
    }

    /**
     * Get an employer
     *
     * @param int $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        if ($employer = Employer::query()->find($id)) {
            $employer->load([
                'jobs',
                'address'
            ]);

            return $this->success($employer);
        }

        return $this->custom(
            [],
            'Employer not found',
            'Not Found',
            404
        );
    }
}
