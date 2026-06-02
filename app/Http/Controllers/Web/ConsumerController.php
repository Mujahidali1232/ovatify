<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SongGeneration;
use App\Models\MarketplaceInvestment;
use App\Models\MarketplacePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConsumerController extends Controller
{
    public function index()
    {
        $featuredDrops = SongGeneration::query()
            ->with('user')
            ->where('status', 'uploaded')
            ->where('file_type', 'audio')
            ->latest()
            ->limit(4)
            ->get();

        $investmentAssets = SongGeneration::query()
            ->with(['user', 'marketplaceAssets' => function ($query) {
                $query->where('sale_type', 'investment');
            }])
            ->where('status', 'uploaded')
            ->whereHas('marketplaceAssets', function ($query) {
                $query->where('sale_type', 'investment');
            })
            ->latest()
            ->limit(4)
            ->get();

        return view('consumer.home', compact('featuredDrops', 'investmentAssets'));
    }

    public function myTracks()
    {
        $user = Auth::user();
        $publishedTracks = SongGeneration::query()
            ->where('user_id', $user->id)
            ->where('status', 'uploaded')
            ->latest()
            ->get();

        $aiCreations = SongGeneration::query()
            ->where('user_id', $user->id)
            ->whereNotNull('taskId')
            ->latest()
            ->get();

        return view('consumer.my-tracks.index', compact('publishedTracks', 'aiCreations'));
    }

    public function investments()
    {
        $user = Auth::user();
        $investments = MarketplaceInvestment::query()
            ->where('user_id', $user->id)
            ->with(['asset.songGeneration.user'])
            ->latest()
            ->get();

        $totalInvested = $investments->sum('investment_amount');
        $totalEarned = $investments->sum('total_earned');

        return view('consumer.investments.index', compact('investments', 'totalInvested', 'totalEarned'));
    }

    public function marketplace(Request $request)
    {
        $query = SongGeneration::query()
            ->with(['user', 'marketplaceAssets'])
            ->where('status', 'uploaded')
            ->where('file_type', 'audio');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function ($q2) use ($searchTerm) {
                      $q2->where('username', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        $tracks = $query->latest()->get();

        if ($request->filled('search')) {
            // When searching, show all matched tracks as Featured and none as Trending
            $featuredDrops = $tracks;
            $trendingNow = collect();
        } else {
            // Regular layout
            $featuredDrops = $tracks->take(4);
            $trendingNow = $tracks->shuffle()->take(4);
        }

        return view('consumer.marketplace.index', compact('featuredDrops', 'trendingNow', 'tracks'));
    }

    public function profile()
    {
        $user = Auth::user();
        $totalInvested = MarketplaceInvestment::where('user_id', $user->id)->sum('investment_amount');
        
        return view('consumer.profile', compact('user', 'totalInvested'));
    }

    public function updateAvatar(Request $request)
    {
        $data = $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $user = $request->user();

        // Delete old file if it was a stored upload (not http/theme path)
        $old = (string) ($user->profile_image ?? '');
        if (!empty($old) && !str_starts_with($old, 'http') && !str_starts_with($old, 'theme/') && !str_starts_with($old, 'images/')) {
            Storage::disk('public')->delete($old);
        }

        $path = $data['avatar']->store('avatars', 'public');
        $user->profile_image = $path;
        $user->save();

        return back()->with('success', 'Profile image updated.');
    }

    public function trackDetails($id)
    {
        $track = SongGeneration::query()
            ->with(['user', 'marketplaceAssets'])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.track-details', compact('track'));
    }

    public function investTrack($id)
    {
        $track = SongGeneration::query()
            ->with(['user', 'marketplaceAssets' => function ($query) {
                $query->where('sale_type', 'investment');
            }])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.invest-track', compact('track'));
    }

    public function trackAgreement($id)
    {
        $track = SongGeneration::query()
            ->with(['user'])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.artist-agreements', compact('track'));
    }

    public function trackCheckout($id)
    {
        $track = SongGeneration::query()
            ->with(['user', 'marketplaceAssets' => function ($query) {
                $query->where('sale_type', 'investment');
            }])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.track-checkout', compact('track'));
    }

    public function libraryTrackDetails($id)
    {
        $track = SongGeneration::query()
            ->with(['user', 'marketplaceAssets' => function ($query) {
                $query->where('sale_type', 'investment');
            }])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.my-tracks.track-details', compact('track'));
    }

    public function libraryTrackAgreement($id)
    {
        $track = SongGeneration::query()
            ->with(['user'])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.my-tracks.artist-agreements', compact('track'));
    }

    public function investmentTrackDetails($id)
    {
        $investment = MarketplaceInvestment::query()
            ->with(['asset.songGeneration.user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('consumer.investments.track-details', compact('investment'));
    }

    public function investmentTrackAgreement($id)
    {
        $track = SongGeneration::query()
            ->with(['user'])
            ->where('status', 'uploaded')
            ->findOrFail($id);

        return view('consumer.investments.artist-agreements', compact('track'));
    }
}
