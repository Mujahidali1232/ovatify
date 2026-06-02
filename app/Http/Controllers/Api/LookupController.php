<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\LicenseTier;
use App\Models\AgreementTemplate;
use App\Models\DspPlatform;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Lightweight reference-data endpoints used to populate filter chips,
 * license pickers, agreement template pickers, and DSP platform pickers
 * throughout the Flutter app.
 */
class LookupController extends Controller
{
    public function genres(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Genre::active()->orderBy('sort_order')->get(['id', 'name', 'slug']),
        ]);
    }

    public function licenseTiers(): JsonResponse
    {
        $tiers = LicenseTier::active()
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'default_price', 'description', 'features', 'default_duration_months']);

        return response()->json([
            'success' => true,
            'data' => $tiers->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
                'default_price' => (float) $t->default_price,
                'description' => $t->description,
                'features' => $t->features ?? [],
                'default_duration_months' => $t->default_duration_months,
            ]),
        ]);
    }

    public function agreementTemplates(Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        $templates = AgreementTemplate::active()
            ->where(function ($q) use ($userId) {
                $q->where('is_system', true);
                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            })
            ->orderBy('is_system', 'desc')
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'category', 'type', 'body', 'is_system', 'user_id']);

        return response()->json([
            'success' => true,
            'data' => $templates,
        ]);
    }

    public function agreementTemplate(int $id): JsonResponse
    {
        $template = AgreementTemplate::active()->find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Agreement template not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $template,
        ]);
    }

    public function dspPlatforms(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => DspPlatform::active()
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug', 'icon', 'brand_color']),
        ]);
    }
}
