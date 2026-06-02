<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SellerBankAccount;

class SellerBankAccountController extends Controller
{
    /**
     * Start Stripe onboarding
     */
    public function startOnboarding(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'country' => 'required|string|size:2', // US, GB, PK not supported
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->all(),
                ], 422);
            }

            $stripeService = app('payment.service');

            // Create or reuse Stripe account
            $stripeAccount = $stripeService->createOrGetConnectedAccount(
                Auth::user(),
                $request->country
            );

            if($stripeAccount['status'] === 'active') {
                return response()->json([
                    'success' => true,
                    'message' => 'Stripe account is already enabled.',
                ], 422);
            }

            // Generate onboarding link
            $onboardingLink = $stripeService->createOnboardingLink(
                Auth::user(),
                $stripeAccount['stripe_account_id']
            );

            return response()->json([
                'success' => true,
                'onboarding_url' => $onboardingLink,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to start onboarding',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get seller onboarding status
     */
    public function getStatus(): JsonResponse
    {
        $bankAccount = SellerBankAccount::where('user_id', Auth::id())->first();

        if (!$bankAccount) {
            return response()->json([
                'success' => false,
                'status' => 'not_started',
            ]);
        }

        $stripeService = app('payment.service');
        $account = $stripeService->getConnectedAccount($bankAccount->stripe_account_id);

        $bankAccount->update([
            'status' => $account['account']->charges_enabled && $account['account']->payouts_enabled ? 'active' : 'pending',
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'onboarded' => $account['account']->charges_enabled && $account['account']->payouts_enabled,
                'charges_enabled' => $account['account']->charges_enabled,
                'payouts_enabled' => $account['account']->payouts_enabled,
                'requirements' => $account['account']->requirements->currently_due ?? [],
            ],
        ]);
    }

    public function refreshOnboarding(Request $request): JsonResponse
    {
        try {
            $stripeService = app('payment.service');

            $bankAccount = SellerBankAccount::where('user_id', Auth::id())->first();

            if (!$bankAccount) {
                return response()->json([
                    'success' => false,
                    'message' => 'No Stripe account found for user',
                ], 404);
            }

            // Generate new onboarding link
            $onboardingLink = $stripeService->createOnboardingLink(
                Auth::user(),
                $bankAccount->stripe_account_id
            );

            return response()->json([
                'success' => true,
                'onboarding_url' => $onboardingLink,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh onboarding',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    public function completeOnboarding(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Onboarding complete. You can now close this window.',
        ]);
    }
}
