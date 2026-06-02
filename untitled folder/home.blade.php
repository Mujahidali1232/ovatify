@extends('layouts.web')

@section('title', 'Ovatify - Music, Images & Merchandise Marketplace')

@section('content')

@include('partials.banner-search')

<!-- Featured Music Section -->
<section class="ls section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin grey">Listen & Discover</p>
                    <h2>Featured Music</h2>
                    <p class="bottommargin_0">License, buy or invest in trending tracks</p>
                </div>
            </div>
        </div>
        <div class="row topmargin_30">
            <!-- Music Card 1 -->
            <div class="col-md-4 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/01.jpg') }}" alt="Midnight Echoes" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                            <span class="asset-badge badge-license">License</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Midnight Echoes</h4>
                        <p class="small grey">by DJ Shadow</p>
                        <div class="price-tag">$29.99</div>
                    </div>
                </div>
            </div>

            <!-- Music Card 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/03.jpg') }}" alt="Desert Storm" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-license">License</span>
                            <span class="asset-badge badge-invest">Invest</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Desert Storm</h4>
                        <p class="small grey">by Nomad Beats</p>
                        <div class="price-tag">$49.99</div>
                        <p class="small highlight">ROI: 15.5%</p>
                    </div>
                </div>
            </div>

            <!-- Music Card 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/04.jpg') }}" alt="Neon Skyline" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                            <span class="asset-badge badge-license">License</span>
                            <span class="asset-badge badge-invest">Invest</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Neon Skyline</h4>
                        <p class="small grey">by Cinematic Orchestra</p>
                        <div class="price-tag">$99.99</div>
                        <p class="small highlight">ROI: 12.0%</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row topmargin_30">
            <div class="col-sm-12 text-center">
                <a href="{{ url('/marketplace/music') }}" class="theme_button">Browse All Music →</a>
            </div>
        </div>
    </div>
</section>

<!-- Images Section -->
<section class="ds parallax section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin">Visual Art</p>
                    <h2 class="grey">Popular Images</h2>
                    <p class="grey bottommargin_0">Photos, Illustrations, Art & Craft</p>
                </div>
            </div>
        </div>
        <div class="row topmargin_30">
            <!-- Image Card 1 -->
            <div class="col-md-3 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/05.jpg') }}" alt="Mountain Sunset" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                            <span class="asset-badge badge-license">License</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Mountain Sunset</h4>
                        <p class="small grey">Photography</p>
                        <div class="price-tag">$19.99</div>
                    </div>
                </div>
            </div>

            <!-- Image Card 2 -->
            <div class="col-md-3 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/14.jpg') }}" alt="Abstract Art" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                            <span class="asset-badge badge-license">License</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Abstract Dreams</h4>
                        <p class="small grey">Digital Art</p>
                        <div class="price-tag">$24.99</div>
                    </div>
                </div>
            </div>

            <!-- Image Card 3 -->
            <div class="col-md-3 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/21.jpg') }}" alt="Urban Sketch" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                            <span class="asset-badge badge-license">License</span>
                            <span class="asset-badge badge-merch">Merch</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Urban Sketch</h4>
                        <p class="small grey">Illustration</p>
                        <div class="price-tag">$15.99</div>
                    </div>
                </div>
            </div>

            <!-- Image Card 4 -->
            <div class="col-md-3 col-sm-6">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/22.jpg') }}" alt="Nature Photo" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                            <span class="asset-badge badge-license">License</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Wild Nature</h4>
                        <p class="small grey">Photography</p>
                        <div class="price-tag">$12.99</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row topmargin_30">
            <div class="col-sm-12 text-center">
                <a href="{{ url('/marketplace/images') }}" class="theme_button">Browse All Images →</a>
            </div>
        </div>
    </div>
</section>

<!-- Merchandise Section -->
<section class="ls section_padding_110">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin grey">Shop</p>
                    <h2>Merchandise Store</h2>
                    <p class="bottommargin_0">Posters, T-shirts, Mugs & more</p>
                </div>
            </div>
        </div>
        <div class="row topmargin_30">
            <div class="col-sm-12">
                <div class="owl-carousel" data-items="4" data-margin="30" data-responsive-lg="4" data-responsive-md="3" data-responsive-sm="2" data-responsive-xs="1">
                    
                    <!-- Merchandise Item 1 - Poster -->
                    <div class="vertical-item text-center">
                        <div class="item-media">
                            <img src="{{ asset('theme/images/shop/01.jpg') }}" alt="Limited Edition Poster" style="width:100%; height:250px; object-fit:cover;">
                        </div>
                        <div class="item-content">
                            <h4>Limited Edition Poster</h4>
                            <p class="small grey">Poster</p>
                            <div class="price-tag">$29.99</div>
                            <a href="#" class="theme_button topmargin_10">Buy Now</a>
                        </div>
                    </div>

                    <!-- Merchandise Item 2 - T-shirt -->
                    <div class="vertical-item text-center">
                        <div class="item-media">
                            <img src="{{ asset('theme/images/shop/02.jpg') }}" alt="Artist T-shirt" style="width:100%; height:250px; object-fit:cover;">
                        </div>
                        <div class="item-content">
                            <h4>Artist Collection Tee</h4>
                            <p class="small grey">T-shirt</p>
                            <div class="price-tag">$34.99</div>
                            <a href="#" class="theme_button topmargin_10">Buy Now</a>
                        </div>
                    </div>

                    <!-- Merchandise Item 3 - Mug -->
                    <div class="vertical-item text-center">
                        <div class="item-media">
                            <img src="{{ asset('theme/images/shop/03.jpg') }}" alt="Ceramic Mug" style="width:100%; height:250px; object-fit:cover;">
                        </div>
                        <div class="item-content">
                            <h4>Ceramic Coffee Mug</h4>
                            <p class="small grey">Mug</p>
                            <div class="price-tag">$14.99</div>
                            <a href="#" class="theme_button topmargin_10">Buy Now</a>
                        </div>
                    </div>

                    <!-- Merchandise Item 4 - Poster -->
                    <div class="vertical-item text-center">
                        <div class="item-media">
                            <img src="{{ asset('theme/images/shop/04.jpg') }}" alt="Vinyl Poster" style="width:100%; height:250px; object-fit:cover;">
                        </div>
                        <div class="item-content">
                            <h4>Vinyl Record Poster</h4>
                            <p class="small grey">Poster</p>
                            <div class="price-tag">$19.99</div>
                            <a href="#" class="theme_button topmargin_10">Buy Now</a>
                        </div>
                    </div>

                    <!-- Merchandise Item 5 - Hoodie -->
                    <div class="vertical-item text-center">
                        <div class="item-media">
                            <img src="{{ asset('theme/images/shop/01.jpg') }}" alt="Hoodie" style="width:100%; height:250px; object-fit:cover;">
                        </div>
                        <div class="item-content">
                            <h4>Premium Hoodie</h4>
                            <p class="small grey">Hoodie</p>
                            <div class="price-tag">$59.99</div>
                            <a href="#" class="theme_button topmargin_10">Buy Now</a>
                        </div>
                    </div>

                    <!-- Merchandise Item 6 - Cap -->
                    <div class="vertical-item text-center">
                        <div class="item-media">
                            <img src="{{ asset('theme/images/shop/02.jpg') }}" alt="Cap" style="width:100%; height:250px; object-fit:cover;">
                        </div>
                        <div class="item-content">
                            <h4>Snapback Cap</h4>
                            <p class="small grey">Cap</p>
                            <div class="price-tag">$24.99</div>
                            <a href="#" class="theme_button topmargin_10">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Investment CTA -->
<section class="cs parallax section_padding_75">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <i class="flaticon-chart fontsize_60 highlight bottommargin_20"></i>
                <h2 class="grey">Invest in Music & Art</h2>
                <p class="fontsize_20 topmargin_10">Earn royalties from the next big hit</p>
                <div class="row topmargin_30">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <h3 class="highlight">15%+</h3>
                                    <p>Average ROI</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <h3 class="highlight">50+</h3>
                                    <p>Active Investments</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-box">
                                    <h3 class="highlight">$250K+</h3>
                                    <p>Total Invested</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/business') }}" class="theme_button margin_0 topmargin_30">Learn More →</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .stat-box {
        text-align: center;
        padding: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        margin: 10px 0;
    }
    .stat-box h3 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .stat-box p {
        margin-bottom: 0;
        font-size: 14px;
    }
    .badge-buy { background: #28a745; }
    .badge-license { background: #17a2b8; }
    .badge-invest { background: #ffc107; color: #333; }
    .badge-merch { background: #6f42c1; }
    .price-tag { font-size: 18px; font-weight: bold; color: #7c3aed; margin-top: 5px; }
    .asset-badges { position: absolute; top: 10px; right: 10px; z-index: 10; }
    .asset-badge { display: inline-block; padding: 4px 10px; margin-left: 5px; font-size: 10px; font-weight: bold; border-radius: 3px; color: white; }
</style>
@endpush