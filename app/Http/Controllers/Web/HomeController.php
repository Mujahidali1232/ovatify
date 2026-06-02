<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceAsset;
use App\Models\SongGeneration;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Homepage "gallery" — show active illustration assets (images/art).
        $featuredImages = MarketplaceAsset::query()
            ->active()
            ->byAssetType('illustration')
            ->latest('id')
            ->with(['user:id,username', 'songGeneration:id,genre'])
            ->take(12)
            ->get();

        // Song-related covers for homepage (audio tracks).
        $featuredSongs = SongGeneration::query()
            ->where('file_type', 'audio')
            ->latest('id')
            ->with(['user:id,username'])
            ->take(12)
            ->get(['id', 'user_id', 'title', 'cover_image', 'genre']);

        $featuredCreators = User::query()
            ->whereIn('role', ['creator', 'artist'])
            ->where('is_active', true)
            ->latest('id')
            ->take(12)
            ->get(['id', 'username', 'profile_image', 'bio']);

        return view('home', compact('featuredImages', 'featuredSongs', 'featuredCreators'));
    }

    public function imageShow(MarketplaceAsset $asset)
    {
        abort_unless($asset->is_active && $asset->asset_type === 'illustration', 404);

        $asset->loadMissing(['user:id,username', 'songGeneration:id,genre,agreements,agreement_type']);

        $moreImages = MarketplaceAsset::query()
            ->active()
            ->byAssetType('illustration')
            ->whereKeyNot($asset->getKey())
            ->latest('id')
            ->take(8)
            ->get();

        return view('marketplace.images.show', compact('asset', 'moreImages'));
    }
}

