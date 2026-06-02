<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SongGeneration;
use App\Models\MarketplaceAsset;
use App\Models\MarketplaceTransaction;
use App\Models\MarketplacePurchase;
use App\Models\MarketplaceLicense;
use App\Models\MarketplaceInvestment;
use App\Models\CreatorSession;
use App\Models\CollabRequest;
use App\Models\AiTask;
use App\Models\DistributionRequest;
use App\Models\Genre;
use App\Models\LicenseTier;
use App\Models\AgreementTemplate;
use App\Models\DspPlatform;

class AdminController extends Controller
{
    // ============================================================
    //  AUTH (dedicated /admin/login flow)
    // ============================================================

    public function loginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function loginSubmit(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withInput($request->only('email'))
                ->with('error', 'Invalid credentials.');
        }
        if ($user->role !== 'admin') {
            return back()->withInput($request->only('email'))
                ->with('error', 'This account does not have administrator access.');
        }
        if (! $user->is_active) {
            return back()->with('error', 'This admin account is disabled.');
        }

        Auth::login($user, $request->boolean('remember', true));
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    // ============================================================
    //  DASHBOARD
    // ============================================================

    public function dashboard()
    {
        $now = now();
        $sevenDaysAgo = $now->copy()->subDays(7);
        $thirtyDaysAgo = $now->copy()->subDays(30);

        $stats = [
            'total_users' => User::count(),
            'total_creators' => User::where('role', 'creator')->count(),
            'total_consumers' => User::where('role', 'consumer')->count(),
            'total_tracks' => SongGeneration::count(),
            'total_active_assets' => MarketplaceAsset::where('is_active', true)->count(),
            'total_revenue' => (float) MarketplaceTransaction::where('status', 'completed')->sum('amount'),
            'platform_fee' => (float) MarketplaceTransaction::where('status', 'completed')->sum('platform_fee'),
            'pending_distributions' => DistributionRequest::where('status', 'pending')->count(),
            'pending_collabs' => CollabRequest::where('status', 'pending')->count(),
            'new_users_30d' => User::where('created_at', '>=', $thirtyDaysAgo)->count(),
            'new_tracks_30d' => SongGeneration::where('created_at', '>=', $thirtyDaysAgo)->count(),
        ];

        // Revenue series for the past 30 days (sparkline / chart)
        $revenueSeries = MarketplaceTransaction::query()
            ->where('status', 'completed')
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->selectRaw('DATE(created_at) as day, SUM(amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $revenues = [];
        for ($d = 29; $d >= 0; $d--) {
            $day = $now->copy()->subDays($d)->toDateString();
            $labels[] = $now->copy()->subDays($d)->format('M j');
            $revenues[] = (float) ($revenueSeries[$day]->total ?? 0);
        }

        // Transaction-type breakdown
        $txTypes = MarketplaceTransaction::query()
            ->where('status', 'completed')
            ->selectRaw('transaction_type, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('transaction_type')
            ->get();

        $recentUsers = User::latest()->take(5)->get();
        $recentTransactions = MarketplaceTransaction::with('buyer:id,username', 'asset:id,title')
            ->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'stats', 'labels', 'revenues', 'txTypes', 'recentUsers', 'recentTransactions'
        ));
    }

    // ============================================================
    //  USERS
    // ============================================================

    public function users(Request $request)
    {
        $q = User::query()->withCount(['marketplaceAssets']);

        if ($search = $request->query('q')) {
            $q->where(function ($w) use ($search) {
                $w->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        if ($role = $request->query('role')) {
            $q->where('role', $role);
        }
        if (($status = $request->query('status')) !== null && $status !== '') {
            $q->where('is_active', $status === 'active');
        }
        if ($verified = $request->query('verified')) {
            $q->where('is_verified', $verified === 'yes');
        }

        $users = $q->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function creators(Request $request)
    {
        $q = User::query()->where('role', 'creator')->withCount(['marketplaceAssets']);
        if ($search = $request->query('q')) {
            $q->where(function ($w) use ($search) {
                $w->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $creators = $q->latest()->paginate(15)->withQueryString();
        return view('admin.creators', compact('creators'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Cannot change status of this administrator.');
        }
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'User status updated.');
    }

    public function verifyUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_verified = !$user->is_verified;
        $user->save();
        return back()->with('success', $user->is_verified ? 'User marked as verified.' : 'Verification revoked.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Cannot delete an administrator account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // ============================================================
    //  TRACKS / MEDIA
    // ============================================================

    public function tracks(Request $request)
    {
        $q = SongGeneration::query()->with('user:id,username', 'marketplaceAssets');

        if ($search = $request->query('q')) {
            $q->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                    ->orWhere('overview', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('username', 'like', "%{$search}%"));
            });
        }
        if ($type = $request->query('type')) {
            $q->where('file_type', $type);
        }
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }

        $tracks = $q->latest()->paginate(15)->withQueryString();
        $stats = [
            'total' => SongGeneration::count(),
            'audio' => SongGeneration::where('file_type', 'audio')->count(),
            'video' => SongGeneration::where('file_type', 'video')->count(),
            'illustration' => SongGeneration::where('file_type', 'illustration')->count(),
        ];
        return view('admin.tracks', compact('tracks', 'stats'));
    }

    public function deleteTrack($id)
    {
        $track = SongGeneration::findOrFail($id);
        $track->delete();
        return back()->with('success', 'Track removed.');
    }

    public function toggleAssetActive($id)
    {
        $asset = MarketplaceAsset::findOrFail($id);
        $asset->is_active = !$asset->is_active;
        $asset->save();
        return back()->with('success', 'Marketplace asset ' . ($asset->is_active ? 'enabled' : 'disabled') . '.');
    }

    // ============================================================
    //  CREATOR SESSIONS (drafts)
    // ============================================================

    public function sessions(Request $request)
    {
        $q = CreatorSession::query()->with('user:id,username');
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        $sessions = $q->latest()->paginate(15)->withQueryString();
        $stats = [
            'total' => CreatorSession::count(),
            'drafts' => CreatorSession::where('status', '!=', 'published')->count(),
            'published' => CreatorSession::where('status', 'published')->count(),
        ];
        return view('admin.sessions', compact('sessions', 'stats'));
    }

    // ============================================================
    //  AI TASKS (usage tracking)
    // ============================================================

    public function aiTasks(Request $request)
    {
        $q = AiTask::query()->with('user:id,username');
        if ($tool = $request->query('tool')) {
            $q->where('tool', $tool);
        }
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        $tasks = $q->latest()->paginate(20)->withQueryString();
        $byTool = AiTask::selectRaw('tool, COUNT(*) as count')->groupBy('tool')->orderByDesc('count')->get();
        return view('admin.ai-tasks', compact('tasks', 'byTool'));
    }

    // ============================================================
    //  MARKETPLACE TRANSACTIONS
    // ============================================================

    public function transactions(Request $request)
    {
        $q = MarketplaceTransaction::query()->with('buyer:id,username', 'seller:id,username', 'asset:id,title');
        if ($type = $request->query('type')) {
            $q->where('transaction_type', $type);
        }
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        $transactions = $q->latest()->paginate(20)->withQueryString();
        $totals = [
            'all_time' => (float) MarketplaceTransaction::where('status', 'completed')->sum('amount'),
            'this_month' => (float) MarketplaceTransaction::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'platform_fees' => (float) MarketplaceTransaction::where('status', 'completed')->sum('platform_fee'),
        ];
        return view('admin.transactions', compact('transactions', 'totals'));
    }

    // ============================================================
    //  DISTRIBUTION QUEUE
    // ============================================================

    public function distributions(Request $request)
    {
        $q = DistributionRequest::query()->with('user:id,username', 'songGeneration:id,title,cover_image');
        if ($status = $request->query('status', 'pending')) {
            $q->where('status', $status);
        }
        $distributions = $q->latest()->paginate(15)->withQueryString();
        $stats = [
            'pending' => DistributionRequest::where('status', 'pending')->count(),
            'processing' => DistributionRequest::where('status', 'processing')->count(),
            'distributed' => DistributionRequest::where('status', 'distributed')->count(),
            'failed' => DistributionRequest::where('status', 'failed')->count(),
        ];
        return view('admin.distributions', compact('distributions', 'stats'));
    }

    public function distributionAction(Request $request, $id)
    {
        $req = DistributionRequest::findOrFail($id);
        $action = $request->input('action');
        if ($action === 'mark_distributed') {
            $req->status = 'distributed';
            $req->distributed_at = now();
            $req->error_message = null;
        } elseif ($action === 'mark_processing') {
            $req->status = 'processing';
        } elseif ($action === 'mark_failed') {
            $req->status = 'failed';
            $req->error_message = $request->input('error_message', 'Marked as failed by admin.');
        } else {
            return back()->with('error', 'Unknown action.');
        }
        $req->save();
        return back()->with('success', 'Distribution updated.');
    }

    // ============================================================
    //  COLLAB REQUESTS (read-only overview)
    // ============================================================

    public function collabRequests(Request $request)
    {
        $q = CollabRequest::query()->with('fromUser:id,username', 'toUser:id,username', 'song:id,title');
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        $collabs = $q->latest()->paginate(15)->withQueryString();
        $stats = [
            'pending' => CollabRequest::where('status', 'pending')->count(),
            'accepted' => CollabRequest::where('status', 'accepted')->count(),
            'declined' => CollabRequest::where('status', 'declined')->count(),
        ];
        return view('admin.collab-requests', compact('collabs', 'stats'));
    }

    // ============================================================
    //  FINANCIALS
    // ============================================================

    public function financials()
    {
        $transactions = MarketplaceTransaction::with('buyer:id,username', 'asset:id,title')
            ->latest()->paginate(15);

        $totals = [
            'total_sales' => (float) MarketplaceTransaction::where('status', 'completed')->sum('amount'),
            'total_payouts_due' => (float) MarketplaceTransaction::where('status', 'completed')->sum('seller_amount'),
            'platform_revenue' => (float) MarketplaceTransaction::where('status', 'completed')->sum('platform_fee'),
            'purchases' => (float) MarketplaceTransaction::where('status', 'completed')->where('transaction_type', 'purchase')->sum('amount'),
            'licenses' => (float) MarketplaceTransaction::where('status', 'completed')->where('transaction_type', 'license')->sum('amount'),
            'investments' => (float) MarketplaceTransaction::where('status', 'completed')->where('transaction_type', 'investment')->sum('amount'),
        ];

        // Top earning creators
        $topCreators = User::query()
            ->where('role', 'creator')
            ->select('users.id', 'users.username', 'users.profile_image')
            ->selectSub(
                MarketplaceTransaction::selectRaw('COALESCE(SUM(seller_amount), 0)')
                    ->whereColumn('seller_id', 'users.id')
                    ->where('status', 'completed'),
                'earnings'
            )
            ->orderByDesc('earnings')
            ->limit(5)
            ->get();

        return view('admin.financials', compact('transactions', 'totals', 'topCreators'));
    }

    // ============================================================
    //  LOOKUP DATA MANAGER (genres / license-tiers / agreement templates / DSPs)
    // ============================================================

    public function lookups()
    {
        return view('admin.lookups', [
            'genres' => Genre::orderBy('sort_order')->get(),
            'licenseTiers' => LicenseTier::orderBy('sort_order')->get(),
            'agreementTemplates' => AgreementTemplate::orderBy('is_system', 'desc')->orderBy('sort_order')->get(),
            'dspPlatforms' => DspPlatform::orderBy('sort_order')->get(),
        ]);
    }

    public function genreStore(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:64']);
        Genre::create([
            'name' => $data['name'],
            'slug' => \Illuminate\Support\Str::slug($data['name']),
            'is_active' => true,
            'sort_order' => (Genre::max('sort_order') ?? 0) + 1,
        ]);
        return back()->with('success', 'Genre added.');
    }

    public function genreToggle($id)
    {
        $g = Genre::findOrFail($id);
        $g->is_active = !$g->is_active;
        $g->save();
        return back()->with('success', 'Genre ' . ($g->is_active ? 'enabled' : 'disabled') . '.');
    }

    public function genreDelete($id)
    {
        Genre::findOrFail($id)->delete();
        return back()->with('success', 'Genre removed.');
    }

    public function dspStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:64',
            'brand_color' => 'nullable|string|max:16',
        ]);
        DspPlatform::create([
            'name' => $data['name'],
            'slug' => \Illuminate\Support\Str::slug($data['name']),
            'brand_color' => $data['brand_color'] ?? null,
            'is_active' => true,
            'sort_order' => (DspPlatform::max('sort_order') ?? 0) + 1,
        ]);
        return back()->with('success', 'DSP platform added.');
    }

    public function dspToggle($id)
    {
        $d = DspPlatform::findOrFail($id);
        $d->is_active = !$d->is_active;
        $d->save();
        return back()->with('success', 'DSP ' . ($d->is_active ? 'enabled' : 'disabled') . '.');
    }

    public function dspDelete($id)
    {
        DspPlatform::findOrFail($id)->delete();
        return back()->with('success', 'DSP removed.');
    }

    public function licenseTierUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'default_price' => 'required|numeric|min:0',
            'default_duration_months' => 'nullable|integer|min:1',
        ]);
        $t = LicenseTier::findOrFail($id);
        $t->default_price = $data['default_price'];
        if ($request->filled('default_duration_months')) {
            $t->default_duration_months = $data['default_duration_months'];
        }
        $t->save();
        return back()->with('success', 'License tier updated.');
    }

    public function agreementTemplateDelete($id)
    {
        $t = AgreementTemplate::findOrFail($id);
        if ($t->is_system) {
            return back()->with('error', 'System templates cannot be deleted.');
        }
        $t->delete();
        return back()->with('success', 'Agreement template removed.');
    }

    // ============================================================
    //  SETTINGS
    // ============================================================

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // TODO: persist to a settings table or .env. For now, just confirm.
        return back()->with('success', 'Settings saved.');
    }

    // ============================================================
    //  SITE CONTENT (CMS — edit public website text/images)
    // ============================================================

    public function siteContent()
    {
        $groups = \App\Models\SiteSetting::orderBy('group_name')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group_name');

        return view('admin.site-content', compact('groups'));
    }

    public function updateSiteContent(Request $request)
    {
        $values = $request->input('settings', []);
        $files  = $request->file('image', []);

        foreach ($values as $key => $value) {
            \App\Models\SiteSetting::set($key, $value);
        }

        // Image uploads land in storage/app/public/site/...
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if (!$file) continue;
                $path = $file->store('site', 'public');
                \App\Models\SiteSetting::set($key, $path);
            }
        }

        // Optional: explicit "clear image" flag
        foreach ((array) $request->input('clear', []) as $key => $_) {
            $current = \App\Models\SiteSetting::where('key', $key)->first();
            if ($current && $current->value) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($current->value);
            }
            \App\Models\SiteSetting::set($key, '');
        }

        \App\Models\SiteSetting::flush();
        return back()->with('success', 'Site content updated. Changes are live immediately.');
    }

    // ============================================================
    //  ACCOUNT SECURITY (admin self-service)
    // ============================================================

    /**
     * Change the admin's own username. Requires the current password as a
     * confirmation step (same pattern Google/GitHub use for sensitive edits).
     */
    public function updateAccount(Request $request)
    {
        $admin = $request->user();

        $data = $request->validate([
            'username' => [
                'required', 'string', 'min:3', 'max:50',
                'regex:/^[A-Za-z0-9_.-]+$/',
                'unique:users,username,'.$admin->id,
            ],
            'current_password' => 'required|string',
        ], [
            'username.regex' => 'Username may only contain letters, numbers, dots, underscores and hyphens.',
            'username.unique' => 'That username is already taken.',
        ]);

        if (!Hash::check($data['current_password'], $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        if ($data['username'] === $admin->username) {
            return back()->with('info', 'Username is unchanged.');
        }

        $admin->username = $data['username'];
        $admin->save();

        return back()->with('success', 'Username updated. Use the new username on your next login.');
    }

    /**
     * Change the admin's own password. Requires current password.
     * Reuses the same "cannot reuse current or previously-used password" rule
     * we built for the consumer create-password flow.
     */
    public function updatePassword(Request $request)
    {
        $admin = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'New password confirmation does not match.',
            'new_password.min' => 'Password must be at least 8 characters.',
        ]);

        if (!Hash::check($data['current_password'], $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        if (Hash::check($data['new_password'], $admin->password)) {
            return back()->withErrors(['new_password' => 'New password cannot be the same as your current password.'])->withInput();
        }

        if ($admin->previous_password && Hash::check($data['new_password'], $admin->previous_password)) {
            return back()->withErrors(['new_password' => 'New password cannot be the same as your previously used password.'])->withInput();
        }

        // Save current hash into previous_password before overwriting.
        $admin->previous_password = $admin->password;
        $admin->password = Hash::make($data['new_password']);
        $admin->save();

        // Refresh the password hash in the session so the admin stays logged in.
        Auth::setUser($admin);
        $request->session()->put('password_hash_web', $admin->getAuthPassword());

        return back()->with('success', 'Password updated. Use your new password the next time you log in.');
    }
}
