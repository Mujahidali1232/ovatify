<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ConsumerController;
use App\Http\Controllers\Web\UploadController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public image details (dynamic, DB-backed)
Route::get('/images/{asset}', [HomeController::class, 'imageShow'])
    ->whereNumber('asset')
    ->name('images.show');

// Public marketplace shells (theme pages)
Route::get('/music', fn () => view('marketplace.music.index'))->name('music.index');

// auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/verification', function () {
    return view('auth.verification');
})->name('verification');
Route::get('/forgot/password', function () {
    return view('auth.forgot-password');
})->name('forgot.password');
Route::get('/forgot/verification', function () {
    return view('auth.forgot-verification');
})->name('forgot.verification');
Route::get('/reset/password', function () {
    return view('auth.create-password');
})->name('reset.password');

// social auth routes
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback'])->name('social.callback');
Route::post('/auth/firebase-login', [AuthController::class, 'firebaseLogin'])->name('social.firebase-login');


// ******************************************

// consumer routes
Route::middleware('auth')->prefix('consumer')
    ->name('consumer.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [ConsumerController::class, 'index'])
            ->name('dashboard.index');

        Route::get('/creator/dashboard', fn() => view('consumer.creator-home'))
            ->name('creator.dashboard');

        Route::get('/track/details/{id}', [ConsumerController::class, 'trackDetails'])
            ->name('dashboard.track.details');

        Route::get('/artist/agreement/{id}', [ConsumerController::class, 'trackAgreement'])
            ->name('dashboard.artist.agreement');


        // Invest Track
        Route::get('/invest/track/{id}', [ConsumerController::class, 'investTrack'])
            ->name('dashboard.invest.track');
        Route::get('/track/checkout/{id}', [ConsumerController::class, 'trackCheckout'])
            ->name('dashboard.track.checkout');


        // My Tracks
        Route::prefix('my')->name('my.')->group(function () {

            Route::get('/tracks', [ConsumerController::class, 'myTracks'])
                ->name('tracks');

            Route::get('/track/details/{id}', [ConsumerController::class, 'libraryTrackDetails'])
                ->name('tracks.details');

            Route::get('/track/agreements/{id}', [ConsumerController::class, 'libraryTrackAgreement'])
                ->name('tracks.agreements');
        });


        // Investments
        Route::prefix('investments')->name('investments.')->group(function () {

            Route::get('/', [ConsumerController::class, 'investments'])
                ->name('index');

            Route::get('/track/details/{id}', [ConsumerController::class, 'investmentTrackDetails'])
                ->name('track.details');

            Route::get('/artist/agreements/{id}', [ConsumerController::class, 'investmentTrackAgreement'])
                ->name('artist.agreements');
        });

        // Marketplace
        Route::prefix('marketplace')->name('marketplace.')->group(function () {

            Route::get('/', [ConsumerController::class, 'marketplace'])
                ->name('index');
            Route::get('/images', fn() => view('consumer.marketplace.images'))
                ->name('images');
            Route::get('/image/details', fn() => view('consumer.marketplace.image-details'))
                ->name('image.details');
            Route::get('/track/details', fn() => view('consumer.marketplace.track-details'))
                ->name('track.details');
            Route::get('/image/checkout', fn() => view('consumer.marketplace.image-checkout'))
                ->name('image.checkout');
            Route::get('/image/invest', fn() => view('consumer.marketplace.image-invest'))
                ->name('image.invest');
            Route::get('/image/investment-summary', fn() => view('consumer.marketplace.image-investment-summary'))
                ->name('image.investment-summary');
            Route::get('/all-trending', fn() => view('consumer.marketplace.all-trending'))
                ->name('all-trending');
            Route::get('/all-recommendations', fn() => view('consumer.marketplace.all-recommendations'))
                ->name('all-recommendations');
        });

        // Rights Management
        Route::prefix('rights')->name('rights.')->group(function () {
            Route::get('/', fn() => view('consumer.rights.index'))
                ->name('index');
            Route::get('/view-agreement', fn() => view('consumer.rights.view-agreement'))
                ->name('view-agreement');
            Route::get('/edit-agreement', fn() => view('consumer.rights.edit-agreement'))
                ->name('edit-agreement');
        });

        // AI Tools
        Route::prefix('ai-tools')->name('ai-tools.')->group(function () {
            Route::get('/mixing-assistant', fn() => view('consumer.ai-tools.mixing-assistant'))
                ->name('mixing-assistant');
            Route::get('/melody-generator', fn() => view('consumer.ai-tools.melody-generator'))
                ->name('melody-generator');
            Route::get('/melody-generator-results', fn() => view('consumer.ai-tools.melody-generator-results'))
                ->name('melody-generator-results');
            Route::get('/hook-generator', fn() => view('consumer.ai-tools.hook-generator'))
                ->name('hook-generator');
            Route::get('/hook-generator-results', fn() => view('consumer.ai-tools.hook-generator-results'))
                ->name('hook-generator-results');
            Route::get('/mood-analyzer', fn() => view('consumer.ai-tools.mood-analyzer'))
                ->name('mood-analyzer');
            Route::get('/genre-matcher', fn() => view('consumer.ai-tools.genre-matcher'))
                ->name('genre-matcher');
            Route::get('/genre-matcher-results', fn() => view('consumer.ai-tools.genre-matcher-results'))
                ->name('genre-matcher-results');
            Route::get('/mastering-tool', fn() => view('consumer.ai-tools.mastering-tool'))
                ->name('mastering-tool');
            Route::get('/track-mixing', fn() => view('consumer.ai-tools.track-mixing'))
                ->name('track-mixing');
            Route::get('/track-distribution', fn() => view('consumer.ai-tools.track-distribution'))
                ->name('track-distribution');
            Route::get('/vocal-enhancer', fn() => view('consumer.ai-tools.vocal-enhancer'))
                ->name('vocal-enhancer');
            Route::get('/lyric-generator', fn() => view('consumer.ai-tools.lyric-generator'))
                ->name('lyric-generator');
            Route::get('/lyric-generator-results', fn() => view('consumer.ai-tools.lyric-generator-results'))
                ->name('lyric-generator-results');
            Route::get('/lyric-generator-summary', fn() => view('consumer.ai-tools.lyric-generator-summary'))
                ->name('lyric-generator-summary');
            Route::get('/vocal-enhancer-results', fn() => view('consumer.ai-tools.vocal-enhancer-results'))
                ->name('vocal-enhancer-results');
        });

        // Studio
        Route::prefix('studio')->name('studio.')->group(function () {
            Route::get('/record', fn() => view('consumer.studio.record-audio'))
                ->name('record');
            Route::get('/upload', fn() => view('consumer.studio.upload-screen'))
                ->name('upload');
            Route::get('/upload-partial', fn() => view('consumer.studio.upload-partial'))
                ->name('upload-partial');
            Route::get('/create-session', fn() => view('consumer.studio.create-session'))
                ->name('create-session');
            Route::get('/video-review', fn() => view('consumer.studio.video-review'))
                ->name('video-review');
            Route::get('/audio-review', fn() => view('consumer.studio.audio-review'))
                ->name('audio-review');
            Route::get('/image-review', fn() => view('consumer.studio.image-review'))
                ->name('image-review');
            Route::get('/upload-success', fn() => view('consumer.studio.upload-success'))
                ->name('upload-success');
            Route::get('/text-idea-success', fn() => view('consumer.studio.text-idea-success'))
                ->name('text-idea-success');
            Route::get('/customize-track', fn() => view('consumer.studio.customize-track'))
                ->name('customize-track');
            Route::get('/select-tempo', fn() => view('consumer.studio.select-tempo'))
                ->name('select-tempo');
            Route::get('/track-results', fn() => view('consumer.studio.track-results'))
                ->name('track-results');
            Route::get('/completed-summary', fn() => view('consumer.studio.completed-summary'))
                ->name('completed-summary');
            Route::get('/studio-completion', fn() => view('consumer.studio.studio-completion'))
                ->name('studio-completion');
            Route::get('/studio-completion-v2', fn() => view('consumer.studio.studio-completion-v2'))
                ->name('studio-completion-v2');
            Route::get('/studio-completion-v3', fn() => view('consumer.studio.studio-completion-v3'))
                ->name('studio-completion-v3');
            Route::get('/studio-completion-v4', fn() => view('consumer.studio.studio-completion-v4'))
                ->name('studio-completion-v4');
            Route::get('/track-arrangement', fn() => view('consumer.studio.track-arrangement'))
                ->name('track-arrangement');
        });

        // Forms
        Route::prefix('forms')->name('forms.')->group(function () {
            Route::get('/set-for-sale', fn() => view('consumer.forms.set-for-sale'))
                ->name('set-for-sale');
            Route::get('/investment-settings', fn() => view('consumer.forms.investment-settings'))
                ->name('investment-settings');
            Route::get('/licensing-settings', fn() => view('consumer.forms.licensing-settings'))
                ->name('licensing-settings');
            Route::get('/review-license', fn() => view('consumer.forms.review-license'))
                ->name('review-license');
            Route::get('/list-on-marketplace', fn() => view('consumer.forms.list-on-marketplace'))
                ->name('list-on-marketplace');
        });

        // Profile
        Route::get('/profile', [ConsumerController::class, 'profile'])
            ->name('profile.index');
        Route::post('/profile/avatar', [ConsumerController::class, 'updateAvatar'])
            ->name('profile.avatar.update');

        // Wallet
        Route::get('/wallet/connect', fn() => view('consumer.wallet-connect'))
            ->name('wallet.connect');

        // License
        Route::get('/license/selection', fn() => view('consumer.license-selection'))
            ->name('license.selection');

        // File Operations
        Route::post('/upload-file', [UploadController::class, 'upload'])->name('file.upload');
    });


Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


// Admin login (public)
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');

// Admin Routes (protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // People
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
    Route::post('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/creators', [AdminController::class, 'creators'])->name('creators');

    // Content
    Route::get('/tracks', [AdminController::class, 'tracks'])->name('tracks');
    Route::post('/tracks/{id}/delete', [AdminController::class, 'deleteTrack'])->name('tracks.delete');
    Route::post('/assets/{id}/toggle-active', [AdminController::class, 'toggleAssetActive'])->name('assets.toggle-active');
    Route::get('/sessions', [AdminController::class, 'sessions'])->name('sessions');
    Route::get('/ai-tasks', [AdminController::class, 'aiTasks'])->name('ai-tasks');

    // Marketplace
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::get('/distributions', [AdminController::class, 'distributions'])->name('distributions');
    Route::post('/distributions/{id}/action', [AdminController::class, 'distributionAction'])->name('distributions.action');
    Route::get('/collab-requests', [AdminController::class, 'collabRequests'])->name('collab-requests');
    Route::get('/financials', [AdminController::class, 'financials'])->name('financials');

    // System
    Route::get('/lookups', [AdminController::class, 'lookups'])->name('lookups');
    Route::post('/lookups/genres', [AdminController::class, 'genreStore'])->name('lookups.genres.store');
    Route::post('/lookups/genres/{id}/toggle', [AdminController::class, 'genreToggle'])->name('lookups.genres.toggle');
    Route::post('/lookups/genres/{id}/delete', [AdminController::class, 'genreDelete'])->name('lookups.genres.delete');
    Route::post('/lookups/dsp-platforms', [AdminController::class, 'dspStore'])->name('lookups.dsp.store');
    Route::post('/lookups/dsp-platforms/{id}/toggle', [AdminController::class, 'dspToggle'])->name('lookups.dsp.toggle');
    Route::post('/lookups/dsp-platforms/{id}/delete', [AdminController::class, 'dspDelete'])->name('lookups.dsp.delete');
    Route::post('/lookups/license-tiers/{id}', [AdminController::class, 'licenseTierUpdate'])->name('lookups.license-tiers.update');
    Route::post('/lookups/agreement-templates/{id}/delete', [AdminController::class, 'agreementTemplateDelete'])->name('lookups.agreement-templates.delete');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Site Content CMS
    Route::get('/site-content', [AdminController::class, 'siteContent'])->name('site-content');
    Route::post('/site-content', [AdminController::class, 'updateSiteContent'])->name('site-content.update');

    // Account security — self-service for the logged-in admin
    Route::post('/account/username', [AdminController::class, 'updateAccount'])->name('account.username');
    Route::post('/account/password', [AdminController::class, 'updatePassword'])->name('account.password');
});

