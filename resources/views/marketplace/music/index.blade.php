@extends('layouts.web')

@section('title', 'Music Marketplace - License, Buy & Invest')

@section('content')

<section class="ls section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin grey">Discover</p>
                    <h2>Music Marketplace</h2>
                    <p>License for projects, buy for personal use, or invest in future hits</p>
                </div>
            </div>
        </div>
        
        <!-- Categories Filter -->
        <div class="row bottommargin_30">
            <div class="col-sm-12 text-center category-filter">
                <a href="#" data-category="all" class="active">All</a>
                <a href="#" data-category="hip-hop">Hip Hop</a>
                <a href="#" data-category="r-b">R&B</a>
                <a href="#" data-category="rap">Rap</a>
                <a href="#" data-category="indie">Indie</a>
                <a href="#" data-category="pop">Pop</a>
                <a href="#" data-category="electronic">Electronic</a>
            </div>
        </div>
        
        <!-- Music Grid -->
        <div class="isotope_container row masonry-layout" id="music-grid">
            
            <!-- Track 1 - Hip Hop -->
            <div class="isotope-item col-md-4 col-sm-6 hip-hop">
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
                        <p class="small grey">by DJ Shadow • Hip Hop</p>
                        <div class="price-tag">$29.99</div>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                                Your browser does not support the audio tag.
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 2 - R&B -->
            <div class="isotope-item col-md-4 col-sm-6 r-b">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/02.jpg') }}" alt="Smooth R&B Track" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Smooth Sailing</h4>
                        <p class="small grey">by Soulful Jane • R&B</p>
                        <div class="price-tag">$49.99</div>
                        <p class="small highlight">ROI: 15.5%</p>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 3 - Rap -->
            <div class="isotope-item col-md-4 col-sm-6 rap">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/03.jpg') }}" alt="Rap Beat 2024" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Street Symphony</h4>
                        <p class="small grey">by MC Flow • Rap</p>
                        <div class="price-tag">$39.99</div>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 4 - Indie -->
            <div class="isotope-item col-md-4 col-sm-6 indie">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/04.jpg') }}" alt="Indie Folk Song" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Wildflower</h4>
                        <p class="small grey">by The Wanderers • Indie</p>
                        <div class="price-tag">$59.99</div>
                        <p class="small highlight">ROI: 12.0%</p>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 5 - Pop -->
            <div class="isotope-item col-md-4 col-sm-6 pop">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/05.jpg') }}" alt="Pop Hit Single" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Summer Love</h4>
                        <p class="small grey">by Pop Star • Pop</p>
                        <div class="price-tag">$99.99</div>
                        <p class="small highlight">ROI: 18.0%</p>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 6 - Electronic -->
            <div class="isotope-item col-md-4 col-sm-6 electronic">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/14.jpg') }}" alt="Electronic Beat" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Neon Nights</h4>
                        <p class="small grey">by DJ Electric • Electronic</p>
                        <div class="price-tag">$34.99</div>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 7 - Hip Hop -->
            <div class="isotope-item col-md-4 col-sm-6 hip-hop">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/21.jpg') }}" alt="Old School Hip Hop" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Golden Era</h4>
                        <p class="small grey">by Old School Crew • Hip Hop</p>
                        <div class="price-tag">$24.99</div>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 8 - R&B -->
            <div class="isotope-item col-md-4 col-sm-6 r-b">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/22.jpg') }}" alt="R&B Slow Jam" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Midnight Vibes</h4>
                        <p class="small grey">by R&B Soul • R&B</p>
                        <div class="price-tag">$44.99</div>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track 9 - Rap -->
            <div class="isotope-item col-md-4 col-sm-6 rap">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/23.jpg') }}" alt="Rap Cypher" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Cypher Session</h4>
                        <p class="small grey">by Lyricist • Rap</p>
                        <div class="price-tag">$79.99</div>
                        <p class="small highlight">ROI: 14.0%</p>
                        <div class="track-preview topmargin_10">
                            <audio controls style="width:100%; height:30px;">
                                <source src="#" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="row topmargin_50">
            <div class="col-sm-12 text-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
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
    
    .price-tag {
        font-size: 18px;
        font-weight: bold;
        color: #7c3aed;
        margin-top: 5px;
    }
    
    .category-filter a {
        display: inline-block;
        padding: 8px 20px;
        margin: 5px;
        background: #f0f0f0;
        border-radius: 30px;
        transition: all 0.3s;
        text-decoration: none;
        color: #333;
    }
    
    .category-filter a.active,
    .category-filter a:hover {
        background: #7c3aed;
        color: white;
    }
    
    .track-preview audio {
        width: 100%;
        border-radius: 30px;
    }
    
    .vertical-item {
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }
    
    .vertical-item:hover {
        transform: translateY(-5px);
    }
    
    .pagination {
        display: inline-block;
        padding-left: 0;
        border-radius: 4px;
    }
    
    .pagination > li {
        display: inline;
    }
    
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #7c3aed;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    
    .pagination > .active > a,
    .pagination > .active > a:focus,
    .pagination > .active > a:hover {
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #7c3aed;
        border-color: #7c3aed;
    }
    
    @media (max-width: 768px) {
        .category-filter a {
            padding: 5px 12px;
            font-size: 12px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Category filtering
    document.addEventListener('DOMContentLoaded', function() {
        const filterLinks = document.querySelectorAll('.category-filter a');
        
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all filter links
                filterLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Get selected category
                let category = this.dataset.category;
                
                // Get all music items
                const musicItems = document.querySelectorAll('#music-grid .isotope-item');
                
                // Filter items
                musicItems.forEach(item => {
                    if (category === 'all') {
                        item.style.display = 'block';
                    } else {
                        if (item.classList.contains(category)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });
    });
</script>
@endpush