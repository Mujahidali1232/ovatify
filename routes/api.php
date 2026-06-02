<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Marketplace\PurchaseController;
use App\Http\Controllers\Consumer\ConsumerController;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Creator\CreatorController;
use App\Http\Controllers\Creator\AiToolController;
use App\Http\Controllers\Creator\CreatorSessionController;
use App\Http\Controllers\Creator\RightsController;
use App\Http\Controllers\Creator\CollabRequestController;
use App\Http\Controllers\SellerBankAccountController;
use App\Http\Controllers\Stripe\WebhookController;
use App\Http\Controllers\Marketplace\InvestmentController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\DistributionController;
use App\Http\Controllers\Api\WalletController;

Route::prefix('auth')->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('send-verification-code', [VerificationController::class, 'send']);
    Route::post('verify-code', [VerificationController::class, 'verify']);

    Route::post('forgot-password', [PasswordController::class, 'forgot']);
    Route::post('verify-reset-code', [VerificationController::class, 'verify']);
    Route::post('create-password', [PasswordController::class, 'createPassword']);

    // Social Login Routes
    Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider']);
    Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
    Route::post('social-login', [SocialAuthController::class, 'socialLogin']);
});

// creator routes

Route::middleware(['auth:sanctum', 'creator'])->group(function () {

    Route::prefix('creator')->group(function () {
        Route::get('dashboard', [CreatorController::class, 'dashboard']);
        Route::post('generate/song/usingai', [CreatorController::class, 'generateSongUsingAI']);
        Route::post('get/song/generation/status/{id}', [CreatorController::class, 'getGenerationStatus']);
        Route::post('upload/song', [CreatorController::class, 'uploadSong']);
        Route::post('upload/song/forsale', [CreatorController::class, 'uploadMediaForSale']);
        Route::post('upload/song/forinvestment', [CreatorController::class, 'uploadMediaForInvestment']);
        Route::post('upload/song/forlicense', [CreatorController::class, 'uploadMediaForLicense']);

        Route::post('upload/video', [CreatorController::class, 'uploadVideo']);
        Route::post('upload/video/forsale', [CreatorController::class, 'uploadMediaForSale']);
        Route::post('upload/video/forinvestment', [CreatorController::class, 'uploadMediaForInvestment']);
        Route::post('upload/video/forlicense', [CreatorController::class, 'uploadMediaForLicense']);

        Route::post('upload/illustration', [CreatorController::class, 'uploadIllustration']);
        Route::post('upload/illustration/forsale', [CreatorController::class, 'uploadMediaForSale']);
        Route::post('upload/illustration/forinvestment', [CreatorController::class, 'uploadMediaForInvestment']);
        Route::post('upload/illustration/forlicense', [CreatorController::class, 'uploadMediaForLicense']);

        Route::match(['get', 'post'], 'my/tracks', [CreatorController::class, 'myTracks']);
        Route::match(['get', 'post'], 'my/creation/with/ai', [CreatorController::class, 'songsCreatedWithAI']);
        Route::match(['get', 'post'], 'my/track/details/{id}', [CreatorController::class, 'myTrackDetails']);
        Route::match(['get', 'post'], 'get/song/generation/status/{id}', [CreatorController::class, 'getGenerationStatus']);
        Route::get('download/track/{id}', [CreatorController::class, 'downloadTrack']);
        Route::post('track/{songId}/list', [CreatorController::class, 'listExistingTrack']); // List existing track to marketplace

        // AI Tools Routes
        Route::prefix('tools')->group(function () {
            // Legacy tools (kept for backwards compat)
            Route::post('generate-lyrics', [AiToolController::class, 'generateLyrics']);
            Route::post('generate-album-cover', [AiToolController::class, 'generateAlbumCover']);
            Route::post('start-mastering', [AiToolController::class, 'startMastering']);
            Route::post('analyze-audio', [AiToolController::class, 'analyzeAudio']);

            // Creative Workspace AI tools (Figma — 8 cards)
            Route::post('vocal-enhancer', [AiToolController::class, 'vocalEnhancer']);
            Route::post('melody-generator', [AiToolController::class, 'melodyGenerator']);
            Route::post('hook-generator', [AiToolController::class, 'hookGenerator']);
            Route::post('genre-matcher', [AiToolController::class, 'genreMatcher']);
            Route::post('mood-analyzer', [AiToolController::class, 'moodAnalyzer']);
            Route::post('mixing-assistant', [AiToolController::class, 'mixingAssistant']);
            Route::post('mastering-tool', [AiToolController::class, 'masteringTool']);
            Route::post('lyric-generator', [AiToolController::class, 'lyricGenerator']);

            // Generic task polling + listing
            Route::get('tasks', [AiToolController::class, 'tasksIndex']);
            Route::get('tasks/{taskId}', [AiToolController::class, 'taskStatus']);
        });

        // Creator Sessions (drafts → publish pipeline)
        Route::prefix('sessions')->group(function () {
            Route::get('/', [CreatorSessionController::class, 'index']);
            Route::post('/', [CreatorSessionController::class, 'store']);
            Route::get('{id}', [CreatorSessionController::class, 'show']);
            Route::match(['patch', 'post'], '{id}/update', [CreatorSessionController::class, 'update']);
            Route::delete('{id}', [CreatorSessionController::class, 'destroy']);

            // Ideas
            Route::get('{id}/ideas', [CreatorSessionController::class, 'listIdeas']);
            Route::post('{id}/ideas', [CreatorSessionController::class, 'addIdea']);
            Route::delete('{id}/ideas/{ideaId}', [CreatorSessionController::class, 'removeIdea']);

            // Pipeline stages
            Route::post('{id}/customize', [CreatorSessionController::class, 'customize']);
            Route::post('{id}/mix', [CreatorSessionController::class, 'mix']);
            Route::post('{id}/arrange', [CreatorSessionController::class, 'arrange']);
            Route::post('{id}/finalize', [CreatorSessionController::class, 'finalize']);
            Route::post('{id}/publish', [CreatorSessionController::class, 'publish']);
        });

        // Rights Management
        Route::prefix('rights')->group(function () {
            Route::get('projects', [RightsController::class, 'projects']);
            Route::get('projects/{songId}', [RightsController::class, 'project']);
            Route::post('projects/{songId}/collaborators', [RightsController::class, 'addCollaborator']);
            Route::match(['patch', 'post'], 'projects/{songId}/collaborators/{id}', [RightsController::class, 'updateCollaborator']);
            Route::delete('projects/{songId}/collaborators/{id}', [RightsController::class, 'removeCollaborator']);
            Route::post('projects/{songId}/agreement', [RightsController::class, 'updateAgreement']);
            Route::post('agreement-templates', [RightsController::class, 'uploadAgreementTemplate']);
        });

        // Collab Requests
        Route::prefix('collab-requests')->group(function () {
            Route::post('/', [CollabRequestController::class, 'store']);
            Route::get('incoming', [CollabRequestController::class, 'incoming']);
            Route::get('outgoing', [CollabRequestController::class, 'outgoing']);
            Route::post('{id}/accept', [CollabRequestController::class, 'accept']);
            Route::post('{id}/decline', [CollabRequestController::class, 'decline']);
            Route::post('{id}/withdraw', [CollabRequestController::class, 'withdraw']);
        });

    });

});


// consumer routes

Route::middleware(['auth:sanctum', 'consumer'])->group(function () {
    Route::prefix('consumer')->group(function () {
        Route::get('dashboard', [ConsumerController::class, 'dashboard']);
        Route::get('view/track/details/{id}', [ConsumerController::class, 'trackDetails']);
        Route::get('view/track/agreement/{id}', [ConsumerController::class, 'trackAgreement']);
        Route::match(['get', 'post'], 'search/track',[ConsumerController::class, 'searchTracks']);

        Route::get('my/purchases', [ConsumerController::class, 'myPurchases']);
        Route::get('my/purchase/details/{id}', [ConsumerController::class, 'myPurchaseDetails']);
        Route::post('download/purchased/asset/{id}', [ConsumerController::class, 'downloadPurchasedAsset']);

        // My Tracks (unified library: purchases + licenses + investments)
        Route::get('my/library', [ConsumerController::class, 'myLibrary']);
        Route::post('download/licensed/asset/{id}', [ConsumerController::class, 'downloadLicensedAsset']);

        Route::post('become/creator', [ConsumerController::class, 'becomeCreator']);
    });
});


// common routes for authenticated users

Route::middleware('auth:sanctum')->group(function () {


    Route::prefix('marketplace')->group(function () {

        Route::get('list/tracks', [PurchaseController::class, 'listTracks']);
        Route::get('list/media', [PurchaseController::class, 'listMedia']);
        Route::get('list/media/all', [PurchaseController::class, 'listMediaAll']);

        // Marketplace feed sections (Figma: Featured / Trending / Recommended / Recently added)
        // Accept ?type=audio|video|illustration|media + ?limit + ?page
        Route::get('featured', [PurchaseController::class, 'featured']);
        Route::get('trending', [PurchaseController::class, 'trending']);
        Route::get('recommended', [PurchaseController::class, 'recommended']);
        Route::get('recently-added', [PurchaseController::class, 'recentlyAdded']);

        Route::get('track/details/{id}', [PurchaseController::class, 'trackDetails']);
        Route::get('asset/details/{id}', [PurchaseController::class, 'assetDetails']);
        // Purchase endpoints
        Route::post('/purchases/asset', [PurchaseController::class, 'purchaseAsset'])->name('purchase.asset');

        Route::post('/purchases/license', [PurchaseController::class, 'licenseAsset'])->name('purchase.license');

        Route::post('/purchases/investment', [PurchaseController::class, 'investAsset'])->name('purchase.investment');

        Route::post('/licenses/{license_id}/renew', [PurchaseController::class, 'renewLicense'])->name('license.renew');

        // Retrieval endpoints
        Route::get('/purchases', [PurchaseController::class, 'getPurchases'])->name('purchases.list');

        Route::get('/purchases/{purchase_id}', [PurchaseController::class, 'getPurchaseDetails'])->name('purchase.details');

        Route::get('/licenses', [PurchaseController::class, 'getLicenses'])->name('licenses.list');

        Route::get('/investments', [PurchaseController::class, 'getInvestments'])->name('investments.list');

        // Verification endpoint
        Route::post('/purchases/verify-access', [PurchaseController::class, 'verifyAccessToken'])->name('purchase.verify-access');
    });

    Route::get('/user', function (Request $request) {
        return response()->json(['success' => true, 'user' => new UserResource($request->user())]);
    });


    Route::get('view/agreement/{id}', [ConsumerController::class, 'trackAgreement']);

    // Lookup endpoints (genres, license tiers, agreement templates, DSP platforms)
    Route::prefix('lookups')->group(function () {
        Route::get('genres', [LookupController::class, 'genres']);
        Route::get('license-tiers', [LookupController::class, 'licenseTiers']);
        Route::get('agreement-templates', [LookupController::class, 'agreementTemplates']);
        Route::get('agreement-templates/{id}', [LookupController::class, 'agreementTemplate']);
        Route::get('dsp-platforms', [LookupController::class, 'dspPlatforms']);
    });

    // Short aliases for the same lookups (more discoverable)
    Route::get('genres', [LookupController::class, 'genres']);
    Route::get('license-tiers', [LookupController::class, 'licenseTiers']);
    Route::get('agreement-templates', [LookupController::class, 'agreementTemplates']);
    Route::get('agreement-templates/{id}', [LookupController::class, 'agreementTemplate']);
    Route::get('dsp-platforms', [LookupController::class, 'dspPlatforms']);

    // Track Distribution (creator + consumer share this — eligibility checked server-side)
    Route::prefix('distribute')->group(function () {
        Route::get('/', [DistributionController::class, 'index']);
        Route::post('/', [DistributionController::class, 'submit']);
        Route::get('{id}', [DistributionController::class, 'show']);
    });

    // Wallet binding
    Route::prefix('wallet')->group(function () {
        Route::get('/', [WalletController::class, 'me']);
        Route::post('connect', [WalletController::class, 'connect']);
        Route::post('disconnect', [WalletController::class, 'disconnect']);
    });

    Route::post('/stripe/onboarding', [SellerBankAccountController::class, 'startOnboarding']);
    Route::get('/stripe/onboard/status', [SellerBankAccountController::class, 'getStatus']);
    Route::get('/stripe/onboarding/refresh', [SellerBankAccountController::class, 'refreshOnboarding']);
    
    // Profile Routes
    Route::post('/user/profile-image', [ProfileController::class, 'updateProfileImage']);
    Route::get('/user/profile', [ProfileController::class, 'getProfile']);

    Route::post('auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Investment routes
    Route::prefix('investments')->group(function () {
        // Get all investments
        Route::get('/', [InvestmentController::class, 'getAllInvestments']);

        // Get investment summary/dashboard
        Route::get('/summary', [InvestmentController::class, 'getInvestmentSummary']);

        // Get specific investment details
        Route::get('/{investmentId}', [InvestmentController::class, 'getInvestmentDetails']);

        // Get earning history for investment
        Route::get('/{investmentId}/earnings', [InvestmentController::class, 'getEarningHistory']);

        // Request withdrawal
        Route::post('/{investmentId}/withdraw', [InvestmentController::class, 'requestWithdrawal']);

        // Get withdrawal history
        Route::get('/{investmentId}/withdrawals', [InvestmentController::class, 'getWithdrawalHistory']);
    });
});

Route::post('webhook/stripe', [WebhookController::class, 'handleStripeWebhook']);
Route::get('/stripe/onboarding/complete', [SellerBankAccountController::class, 'completeOnboarding']);

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Payment Intents
    Route::post('payment_intents', [App\Http\Controllers\Api\Stripe\PaymentIntentController::class, 'create']);
    Route::get('payment_intents/{id}', [App\Http\Controllers\Api\Stripe\PaymentIntentController::class, 'retrieve']);
    Route::post('payment_intents/{id}/confirm', [App\Http\Controllers\Api\Stripe\PaymentIntentController::class, 'confirm']);
    Route::post('payment_intents/{id}/capture', [App\Http\Controllers\Api\Stripe\PaymentIntentController::class, 'capture']);
    Route::post('payment_intents/{id}/cancel', [App\Http\Controllers\Api\Stripe\PaymentIntentController::class, 'cancel']);

    // Checkout Sessions
    Route::post('checkout/sessions', [App\Http\Controllers\Api\Stripe\CheckoutController::class, 'createSession']);
    Route::get('checkout/sessions/{id}', [App\Http\Controllers\Api\Stripe\CheckoutController::class, 'retrieveSession']);
    Route::get('checkout/sessions', [App\Http\Controllers\Api\Stripe\CheckoutController::class, 'listSessions']);

    // Charges
    Route::post('charges', [App\Http\Controllers\Api\Stripe\ChargeController::class, 'create']);
    Route::get('charges/{id}', [App\Http\Controllers\Api\Stripe\ChargeController::class, 'retrieve']);
    Route::get('charges', [App\Http\Controllers\Api\Stripe\ChargeController::class, 'list']);

    // Customers
    Route::post('customers', [App\Http\Controllers\Api\Stripe\CustomerController::class, 'create']);
    Route::get('customers/{id}', [App\Http\Controllers\Api\Stripe\CustomerController::class, 'retrieve']);
    Route::post('customers/{id}', [App\Http\Controllers\Api\Stripe\CustomerController::class, 'update']);
    Route::delete('customers/{id}', [App\Http\Controllers\Api\Stripe\CustomerController::class, 'delete']);
    Route::get('customers', [App\Http\Controllers\Api\Stripe\CustomerController::class, 'list']);

    // Payment Methods
    Route::post('payment_methods', [App\Http\Controllers\Api\Stripe\PaymentMethodController::class, 'create']);
    Route::get('payment_methods/{id}', [App\Http\Controllers\Api\Stripe\PaymentMethodController::class, 'retrieve']);
    Route::get('payment_methods', [App\Http\Controllers\Api\Stripe\PaymentMethodController::class, 'list']);
    Route::post('payment_methods/{id}/attach', [App\Http\Controllers\Api\Stripe\PaymentMethodController::class, 'attach']);
    Route::post('payment_methods/{id}/detach', [App\Http\Controllers\Api\Stripe\PaymentMethodController::class, 'detach']);

    // Setup Intents
    Route::post('setup_intents', [App\Http\Controllers\Api\Stripe\SetupIntentController::class, 'create']);
    Route::get('setup_intents/{id}', [App\Http\Controllers\Api\Stripe\SetupIntentController::class, 'retrieve']);
    Route::post('setup_intents/{id}/confirm', [App\Http\Controllers\Api\Stripe\SetupIntentController::class, 'confirm']);
    Route::post('setup_intents/{id}/cancel', [App\Http\Controllers\Api\Stripe\SetupIntentController::class, 'cancel']);

    // Products
    Route::post('products', [App\Http\Controllers\Api\Stripe\ProductController::class, 'create']);
    Route::get('products/{id}', [App\Http\Controllers\Api\Stripe\ProductController::class, 'retrieve']);
    Route::get('products', [App\Http\Controllers\Api\Stripe\ProductController::class, 'list']);
    Route::post('products/{id}', [App\Http\Controllers\Api\Stripe\ProductController::class, 'update']);
    Route::delete('products/{id}', [App\Http\Controllers\Api\Stripe\ProductController::class, 'delete']);

    // Prices
    Route::post('prices', [App\Http\Controllers\Api\Stripe\PriceController::class, 'create']);
    Route::get('prices/{id}', [App\Http\Controllers\Api\Stripe\PriceController::class, 'retrieve']);
    Route::get('prices', [App\Http\Controllers\Api\Stripe\PriceController::class, 'list']);

    // Subscriptions
    Route::post('subscriptions', [App\Http\Controllers\Api\Stripe\SubscriptionController::class, 'create']);
    Route::get('subscriptions/{id}', [App\Http\Controllers\Api\Stripe\SubscriptionController::class, 'retrieve']);
    Route::get('subscriptions', [App\Http\Controllers\Api\Stripe\SubscriptionController::class, 'list']);
    Route::post('subscriptions/{id}', [App\Http\Controllers\Api\Stripe\SubscriptionController::class, 'update']);
    Route::delete('subscriptions/{id}', [App\Http\Controllers\Api\Stripe\SubscriptionController::class, 'cancel']);

    // Invoices
    Route::post('invoices', [App\Http\Controllers\Api\Stripe\InvoiceController::class, 'create']);
    Route::get('invoices/{id}', [App\Http\Controllers\Api\Stripe\InvoiceController::class, 'retrieve']);
    Route::get('invoices', [App\Http\Controllers\Api\Stripe\InvoiceController::class, 'list']);
    Route::post('invoices/{id}/pay', [App\Http\Controllers\Api\Stripe\InvoiceController::class, 'pay']);
    Route::post('invoices/{id}/send', [App\Http\Controllers\Api\Stripe\InvoiceController::class, 'send']);

    // Refunds
    Route::post('refunds', [App\Http\Controllers\Api\Stripe\RefundController::class, 'create']);
    Route::get('refunds/{id}', [App\Http\Controllers\Api\Stripe\RefundController::class, 'retrieve']);
    Route::get('refunds', [App\Http\Controllers\Api\Stripe\RefundController::class, 'list']);

    // Disputes
    Route::get('disputes', [App\Http\Controllers\Api\Stripe\DisputeController::class, 'list']);
    Route::get('disputes/{id}', [App\Http\Controllers\Api\Stripe\DisputeController::class, 'retrieve']);
    Route::post('disputes/{id}/close', [App\Http\Controllers\Api\Stripe\DisputeController::class, 'close']);

    // Balance
    Route::get('balance', [App\Http\Controllers\Api\Stripe\BalanceController::class, 'retrieve']);

    // Payouts
    Route::post('payouts', [App\Http\Controllers\Api\Stripe\PayoutController::class, 'create']);
    Route::get('payouts/{id}', [App\Http\Controllers\Api\Stripe\PayoutController::class, 'retrieve']);
    Route::get('payouts', [App\Http\Controllers\Api\Stripe\PayoutController::class, 'list']);

    // Transfers
    Route::post('transfers', [App\Http\Controllers\Api\Stripe\TransferController::class, 'create']);
    Route::get('transfers/{id}', [App\Http\Controllers\Api\Stripe\TransferController::class, 'retrieve']);
    Route::get('transfers', [App\Http\Controllers\Api\Stripe\TransferController::class, 'list']);

    // Accounts
    Route::post('accounts', [App\Http\Controllers\Api\Stripe\AccountController::class, 'create']);
    Route::get('accounts/{id}', [App\Http\Controllers\Api\Stripe\AccountController::class, 'retrieve']);
    Route::post('accounts/{id}', [App\Http\Controllers\Api\Stripe\AccountController::class, 'update']);
    Route::delete('accounts/{id}', [App\Http\Controllers\Api\Stripe\AccountController::class, 'delete']);

    // Account Links
    Route::post('account_links', [App\Http\Controllers\Api\Stripe\AccountController::class, 'createLink']);

    // External Accounts
    Route::post('accounts/{id}/external_accounts', [App\Http\Controllers\Api\Stripe\AccountController::class, 'createExternalAccount']);
    Route::get('accounts/{id}/external_accounts', [App\Http\Controllers\Api\Stripe\AccountController::class, 'listExternalAccounts']);
    Route::delete('accounts/{acc_id}/external_accounts/{ext_id}', [App\Http\Controllers\Api\Stripe\AccountController::class, 'deleteExternalAccount']);

    // Webhook Endpoints
    Route::post('webhook_endpoints', [App\Http\Controllers\Api\Stripe\WebhookEndpointController::class, 'create']);
    Route::get('webhook_endpoints', [App\Http\Controllers\Api\Stripe\WebhookEndpointController::class, 'list']);
    Route::get('webhook_endpoints/{id}', [App\Http\Controllers\Api\Stripe\WebhookEndpointController::class, 'retrieve']);
    Route::delete('webhook_endpoints/{id}', [App\Http\Controllers\Api\Stripe\WebhookEndpointController::class, 'delete']);

    // Files
    Route::post('files', [App\Http\Controllers\Api\Stripe\FileController::class, 'create']);
    Route::get('files', [App\Http\Controllers\Api\Stripe\FileController::class, 'list']);
    Route::get('files/{id}', [App\Http\Controllers\Api\Stripe\FileController::class, 'retrieve']);

    // Reporting
    Route::get('reporting/report_runs', [App\Http\Controllers\Api\Stripe\ReportingController::class, 'listReportRuns']);
    Route::post('reporting/report_runs', [App\Http\Controllers\Api\Stripe\ReportingController::class, 'createReportRun']);

    // Identity
    Route::post('identity/verification_sessions', [App\Http\Controllers\Api\Stripe\IdentityController::class, 'createSession']);
    Route::get('identity/verification_sessions/{id}', [App\Http\Controllers\Api\Stripe\IdentityController::class, 'retrieveSession']);

    // Issuing
    Route::post('issuing/cards', [App\Http\Controllers\Api\Stripe\IssuingController::class, 'createCard']);
    Route::get('issuing/cards/{id}', [App\Http\Controllers\Api\Stripe\IssuingController::class, 'retrieveCard']);
    Route::get('issuing/cards', [App\Http\Controllers\Api\Stripe\IssuingController::class, 'listCards']);
});
