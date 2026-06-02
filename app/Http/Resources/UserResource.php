<?php

namespace App\Http\Resources;

use App\Models\MarketplaceTransaction;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $totalInvestment = MarketplaceTransaction::where('user_id', $this->id)
            ->where('transaction_type', 'investment')
            ->sum('amount');

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'bio' => $this->bio,
            'is_verified' => (bool) $this->is_verified,
            'email_verified' => !is_null($this->email_verified_at),
            'phone_verified' => !is_null($this->phone_verified_at),
            'total_investments' => (float) $totalInvestment,
            'profile_image' => $this->profile_image
                        ? (str_starts_with($this->profile_image, 'http') ? $this->profile_image : url(Storage::url($this->profile_image)))
                        : null,
        ];
    }
}

