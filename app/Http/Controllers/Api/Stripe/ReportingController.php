<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Reporting\ReportRun;
use Illuminate\Http\JsonResponse;
use Exception;

class ReportingController extends StripeBaseController
{
    public function createReportRun(Request $request): JsonResponse
    {
        try {
            $reportRun = ReportRun::create($request->all());
            return $this->successResponse($reportRun);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function listReportRuns(Request $request): JsonResponse
    {
        try {
            $reportRuns = ReportRun::all($request->all());
            return $this->successResponse($reportRuns);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
