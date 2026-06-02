@props(['title' => 'Asset Title', 'image' => '', 'type' => 'music', 'hasBuy' => false, 'hasLicense' => false, 'hasInvest' => false, 'hasMerch' => false, 'price' => 0, 'roi' => null])

<div class="vertical-item text-center gallery-item content-absolute">
    <div class="item-media">
        <img src="{{ $image ?: asset('theme/images/placeholder.jpg') }}" alt="{{ $title }}" style="width:100%; height:250px; object-fit:cover;">
        <div class="media-links">
            <div class="links-wrap">
                <a class="p-link" href="#"></a>
            </div>
        </div>
        <div class="asset-badges">
            @if($hasBuy)
                <span class="asset-badge badge-buy">Buy</span>
            @endif
            @if($hasLicense)
                <span class="asset-badge badge-license">License</span>
            @endif
            @if($hasInvest)
                <span class="asset-badge badge-invest">Invest</span>
            @endif
            @if($hasMerch)
                <span class="asset-badge badge-merch">Merch</span>
            @endif
        </div>
    </div>
    <div class="item-content theme_background">
        <h4 class="item-meta">{{ $title }}</h4>
        <div class="price-tag">${{ number_format($price, 2) }}</div>
        @if($roi)
            <p class="small highlight">ROI: {{ $roi }}%</p>
        @endif
    </div>
</div>