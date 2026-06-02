@extends('layouts.web')

@section('title', ($asset->title ?: 'Image').' - Ovatify')

@section('content')
@php
    $thumb = $asset->thumbnail
        ? (\Illuminate\Support\Str::startsWith($asset->thumbnail, ['http://','https://'])
            ? $asset->thumbnail
            : (\Illuminate\Support\Str::startsWith($asset->thumbnail, ['theme/','images/'])
                ? url('/'.$asset->thumbnail)
                : url(\Illuminate\Support\Facades\Storage::url($asset->thumbnail))))
        : asset('theme/images/models_square/01.jpg');
@endphp

<section class="ls section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="item-media">
                    <img src="{{ $thumb }}" alt="{{ $asset->title ?: 'Image' }}" style="width:100%; height:auto; border-radius:6px;">
                </div>
            </div>
            <div class="col-sm-5">
                <h2 class="topmargin_0">{{ $asset->title ?: 'Untitled' }}</h2>
                @if($asset->description)
                    <p class="grey">{{ $asset->description }}</p>
                @endif

                <ul class="list1 no-bullets topmargin_30">
                    <li><strong>Type:</strong> {{ ucfirst($asset->asset_type) }}</li>
                    <li><strong>Sale:</strong> {{ ucfirst($asset->sale_type) }}</li>
                    @if($asset->songGeneration?->genre)
                        <li><strong>Category:</strong> {{ $asset->songGeneration->genre }}</li>
                    @endif
                    @if($asset->user?->username)
                        <li><strong>Creator:</strong> {{ $asset->user->username }}</li>
                    @endif
                </ul>

                <div class="topmargin_30">
                    @if($asset->canBePurchased())
                        <div class="bottommargin_10"><strong>Price:</strong> ${{ number_format((float) $asset->price, 2) }}</div>
                    @elseif($asset->canBeLicensed())
                        <div class="bottommargin_10"><strong>License price:</strong> ${{ number_format((float) $asset->price_per_license, 2) }}</div>
                    @elseif($asset->canBeInvested())
                        <div class="bottommargin_10"><strong>Invest:</strong> ${{ number_format((float) $asset->price_per_block, 2) }} / block</div>
                    @endif

                    <a href="{{ url('/') }}" class="theme_button color2">Back to Home</a>
                </div>
            </div>
        </div>

        @if($moreImages->count())
            <div class="row topmargin_60">
                <div class="col-sm-12 text-center">
                    <h3 class="section_header">More images</h3>
                </div>
            </div>
            <div class="row">
                @foreach($moreImages as $img)
                    @php
                        $imgThumb = $img->thumbnail
                            ? (\Illuminate\Support\Str::startsWith($img->thumbnail, ['http://','https://'])
                                ? $img->thumbnail
                                : (\Illuminate\Support\Str::startsWith($img->thumbnail, ['theme/','images/'])
                                    ? url('/'.$img->thumbnail)
                                    : url(\Illuminate\Support\Facades\Storage::url($img->thumbnail))))
                            : asset('theme/images/models_square/01.jpg');
                    @endphp
                    <div class="col-md-3 col-sm-6">
                        <div class="vertical-item text-center gallery-item content-absolute">
                            <div class="item-media">
                                <img src="{{ $imgThumb }}" alt="{{ $img->title ?: 'Image' }}" style="width:100%; height:220px; object-fit:cover;">
                                <div class="media-links">
                                    <div class="links-wrap">
                                        <a class="p-link" href="{{ route('images.show', $img->id) }}"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="item-content theme_background">
                                <h4 class="item-meta">
                                    <a href="{{ route('images.show', $img->id) }}">{{ $img->title ?: 'Untitled' }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection

