<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <title>@yield('title', 'Ovatify - Music, Images & Merchandise Marketplace')</title>
    <meta charset="utf-8">
    <meta name="description" content="@yield('description', 'License, Buy or Invest in Music, Images and Merchandise on Ovatify')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" id="color-switcher-link">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    
    <style>
        .asset-badges {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
        .asset-badge {
            display: inline-block;
            padding: 4px 10px;
            margin-left: 5px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            color: white;
        }
        .badge-buy { background: #28a745; }
        .badge-license { background: #17a2b8; }
        .badge-invest { background: #ffc107; color: #333; }
        .badge-merch { background: #6f42c1; }
        .price-tag { font-size: 18px; font-weight: bold; color: #7c3aed; }
        .quick-access-bar { background: rgba(0,0,0,0.7); display: inline-block; padding: 10px 25px; border-radius: 50px; margin-bottom: 20px; }
        .quick-access-bar a { color: white; margin: 0 15px; font-weight: bold; }
        .quick-access-bar a:hover { color: #ffc107; }
        .category-filter a { display: inline-block; padding: 8px 20px; margin: 5px; background: #f0f0f0; border-radius: 30px; transition: all 0.3s; }
        .category-filter a.active, .category-filter a:hover { background: #7c3aed; color: white; }
        .search-form .form-group { position: relative; }
        .search-form button { position: absolute; right: 0; top: 0; height: 100%; border-radius: 0 4px 4px 0; }
    </style>

    <script src="{{ asset('js/vendor/modernizr-2.6.2.min.js') }}"></script>
</head>
<body>

<div class="preloader"><div class="preloader_image"></div></div>

<!-- Search Modal -->
<div class="modal" tabindex="-1" role="dialog" id="search_modal">
    <div class="widget widget_search">
        <form method="get" class="searchform form-inline" action="/marketplace/search">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search keyword">
            </div>
            <button type="submit" class="theme_button">Search</button>
        </form>
    </div>
</div>

<div id="canvas">
    <div id="box_wrapper">
        
        @include('partials.header')
        
        @yield('content')
        
        @include('partials.footer')
        
    </div>
</div>

<script src="{{ asset('theme/js/compressed.js') }}"></script>
<script src="{{ asset('theme/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>