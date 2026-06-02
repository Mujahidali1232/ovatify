<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketplaceTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_reference' => $this->transaction_reference,
            'transaction_type' => $this->transaction_type,
            'status' => $this->status,
            'amount' => (float) $this->amount,
            'seller_amount' => (float) $this->seller_amount,
            'platform_fee' => (float) $this->platform_fee,
            'payment_method' => $this->payment_method,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
            'asset' => $this->whenLoaded(
                'asset',
                fn() => $this->asset
                ? new MarketplaceAssetsResource($this->asset)
                : null
            ),
            'seller' => [
                'id' => $this->seller->id,
                'username' => $this->seller->username,
                'email' => $this->seller->email,
                'profile_image' => $this->seller->profile_image,
            ],

        ];
    }
}