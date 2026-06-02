<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MarketplaceAssetsResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'overview' => $this->overview,
            'cover_image' => $this->resolveMediaUrl($this->cover_image),
            'description' => $this->description,
            'instrumental_type' => $this->instrumental_type,
            'genre' => $this->genre,
            'mood' => $this->mood,
            'tempo' => $this->tempo,
            'agreement' => $this->agreements,
            'file' => $this->resolveMediaUrl($this->file),
            'status' => $this->status,
            'enabled_for_sale' => $this->marketplaceAssets->where('sale_type', 'sale')->isNotEmpty(),
            'enabled_for_investment' => $this->marketplaceAssets->where('sale_type', 'investment')->isNotEmpty(),
            'enabled_for_license' => $this->marketplaceAssets->where('sale_type', 'license')->isNotEmpty(),
            'upload_date' => $this->created_at ? $this->created_at->toDateTimeString() : null,

            'creator' => $this->whenLoaded(
                'user',
                fn() => $this->user ? [
                    'id' => $this->user->id,
                    'username' => $this->user->username,
                    'email' => $this->user->email,
                    'role' => $this->user->role,
                    'bio' => $this->user->bio,
                    'is_verified' => (bool) $this->user->is_verified,
                    'profile_image' => $this->user->profile_image
                        ? (str_starts_with($this->user->profile_image, 'http')
                            ? $this->user->profile_image
                            : url(Storage::url($this->user->profile_image)))
                        : null,
                ] : null
            ),


            'marketplace_assets' => $this->whenLoaded(
                'marketplaceAssets',
                fn() => $this->marketplaceAssets->isNotEmpty()
                ? MarketplaceAssetsResource::collection($this->marketplaceAssets)
                : null
            ),


        ];
    }

    /**
     * Turn a stored value (full http URL, OR a storage relative path) into a usable URL.
     */
    protected function resolveMediaUrl(?string $val): ?string
    {
        if (empty($val)) return null;
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) return $val;
        return url(Storage::url($val));
    }
}
