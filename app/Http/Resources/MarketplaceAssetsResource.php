<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MarketplaceAssetsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'asset_type' => $this->asset_type,
            'sale_type' => $this->sale_type,
            'title' => $this->title,
            'description' => $this->description,
            'tags' => $this->tags,
            'price' => (float) $this->price,
            'is_active' => (bool) $this->is_active,
            'thumbnail' => $this->resolveMediaUrl($this->thumbnail),
            'preview_duration' => $this->preview_duration,

            'license_type' => $this->license_type,
            'price_per_license' => (float) $this->price_per_license,
            'license_duration' => $this->license_duration,

            // Image / video metadata (Figma: Image Detail screen)
            'width_px' => $this->width_px ? (int) $this->width_px : null,
            'height_px' => $this->height_px ? (int) $this->height_px : null,
            'orientation' => $this->orientation,        // square | portrait | landscape
            'file_format' => $this->file_format,        // PNG | JPG | MP4 | WAV | ...
            'file_size_bytes' => $this->file_size_bytes ? (int) $this->file_size_bytes : null,
            'file_size_human' => $this->file_size_bytes ? $this->humanFileSize($this->file_size_bytes) : null,
            'resolution_display' => ($this->width_px && $this->height_px) ? ($this->width_px . 'x' . $this->height_px) : null,

            'total_valuation' => (int) $this->total_valuation,
            'ownership_blocks' => (int) $this->ownership_blocks,
            'price_per_block' => (int) $this->price_per_block,
            'max_available_blocks' => (int) $this->max_available_blocks,
            'remaining_blocks' => (int) $this->remaining_blocks,
            'total_investments' => (float) $this->total_investments,

            // 🔹 Song Generation
            'song_generation' => $this->whenLoaded(
                'songGeneration',
                fn() => $this->songGeneration ? [
                    'id' => $this->songGeneration->id,
                    'title' => $this->songGeneration->title,
                    'overview' => $this->songGeneration->overview,
                    'description' => $this->songGeneration->description,
                    'agreement' => $this->songGeneration->agreements,
                    'genre' => $this->songGeneration->genre,
                    'tempo' => $this->songGeneration->tempo,
                    'instrumental_type' => $this->songGeneration->instrumental_type,
                    'status' => $this->songGeneration->status,
                    'cover_image' => $this->resolveMediaUrl($this->songGeneration->cover_image),
                    'file' => $this->resolveMediaUrl($this->songGeneration->file),
                    'upload_date' => $this->songGeneration->created_at ? $this->songGeneration->created_at->toDateTimeString() : null,

                ] : null
            ),

            // 🔹 User (Creator)
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

    /**
     * Render byte count as a short human string ("10 MB", "245 KB", "1.4 GB").
     */
    protected function humanFileSize(int $bytes): string
    {
        if ($bytes < 1024) return $bytes . ' B';
        $units = ['KB', 'MB', 'GB', 'TB'];
        $i = -1;
        do { $bytes /= 1024; $i++; } while ($bytes >= 1024 && $i < count($units) - 1);
        return number_format($bytes, $bytes < 10 ? 1 : 0) . ' ' . $units[$i];
    }
}
