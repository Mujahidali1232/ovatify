<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Lightweight wallet binding for crypto investments.
 *
 * Today: stores the wallet address the user connected client-side via
 * MetaMask / WalletConnect SDK, so subsequent investments can pre-fill it
 * and the backend can record tx_hash against the wallet.
 *
 * TODO: server-side signature verification using a `signature` + `message`
 * pair and the user-supplied address (web3/ethers-php), so we can prove
 * the user actually controls the wallet.
 */
class WalletController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'connected' => !empty($user->wallet_address),
                'wallet_address' => $user->wallet_address,
                'wallet_provider' => $user->wallet_provider,
                'wallet_connected_at' => $user->wallet_connected_at?->toDateTimeString(),
            ],
        ]);
    }

    public function connect(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'wallet_address' => ['required', 'string', 'regex:/^0x[a-fA-F0-9]{40}$/'],
            'wallet_provider' => ['required', 'string', 'in:metamask,walletconnect,coinbase,other'],
            // Optional — held for future signature verification step.
            'signature' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $user = $request->user();
        $user->wallet_address = strtolower($request->input('wallet_address'));
        $user->wallet_provider = $request->input('wallet_provider');
        $user->wallet_connected_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Wallet connected.',
            'data' => [
                'wallet_address' => $user->wallet_address,
                'wallet_provider' => $user->wallet_provider,
                'wallet_connected_at' => $user->wallet_connected_at?->toDateTimeString(),
            ],
        ]);
    }

    public function disconnect(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->wallet_address = null;
        $user->wallet_provider = null;
        $user->wallet_connected_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Wallet disconnected.',
        ]);
    }
}
