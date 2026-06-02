@extends('layouts.web')

@section('title', 'Images Marketplace - License, Buy & Invest')

@section('content')

<section class="ls section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin grey">Visual Content</p>
                    <h2>Images & Art Marketplace</h2>
                    <p>Photos, Illustrations, Art & Craft for every project</p>
                </div>
            </div>
        </div>
        
        <!-- Categories -->
        <div class="row bottommargin_30">
            <div class="col-sm-12 text-center category-filter">
                <a href="#" data-category="all" class="active">All</a>
                <a href="#" data-category="photos">Photos</a>
                <a href="#" data-category="illustrations">Illustrations</a>
                <a href="#" data-category="art">Art</a>
                <a href="#" data-category="craft">Craft</a>
                <a href="#" data-category="places">Places</a>
            </div>
        </div>
        
        <!-- Images Grid -->
        <div class="row" id="images-grid">
            
            <!-- Image 1 - Photos -->
            <div class="col-md-3 col-sm-6 category-item photos">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/01.jpg') }}" alt="Mountain Landscape" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Mountain Landscape</h4>
                        <p class="small grey">Photography • Nature</p>
                        <div class="price-tag">$19.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">License</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 2 - Illustrations -->
            <div class="col-md-3 col-sm-6 category-item illustrations">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/02.jpg') }}" alt="Vector Illustration" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Digital Dreams</h4>
                        <p class="small grey">Illustration • Vector Art</p>
                        <div class="price-tag">$24.99</div>
                        <p class="small highlight">ROI: 10.0%</p>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Invest</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 3 - Art -->
            <div class="col-md-3 col-sm-6 category-item art">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/03.jpg') }}" alt="Abstract Painting" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Abstract Emotions</h4>
                        <p class="small grey">Art • Abstract</p>
                        <div class="price-tag">$39.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 4 - Craft -->
            <div class="col-md-3 col-sm-6 category-item craft">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/04.jpg') }}" alt="Handmade Craft" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Handmade Ceramic</h4>
                        <p class="small grey">Craft • Pottery</p>
                        <div class="price-tag">$49.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 5 - Places -->
            <div class="col-md-3 col-sm-6 category-item places">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/05.jpg') }}" alt="City Skyline" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">City Skyline</h4>
                        <p class="small grey">Places • Urban</p>
                        <div class="price-tag">$14.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">License</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 6 - Photos -->
            <div class="col-md-3 col-sm-6 category-item photos">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/14.jpg') }}" alt="Wildlife Photo" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Wildlife Safari</h4>
                        <p class="small grey">Photography • Animals</p>
                        <div class="price-tag">$22.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 7 - Illustrations -->
            <div class="col-md-3 col-sm-6 category-item illustrations">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/21.jpg') }}" alt="Digital Art" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Fantasy World</h4>
                        <p class="small grey">Illustration • Fantasy</p>
                        <div class="price-tag">$89.99</div>
                        <p class="small highlight">ROI: 10.0%</p>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Invest</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 8 - Art -->
            <div class="col-md-3 col-sm-6 category-item art">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/22.jpg') }}" alt="Modern Art" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Modern Expressions</h4>
                        <p class="small grey">Art • Contemporary</p>
                        <div class="price-tag">$59.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 9 - Craft -->
            <div class="col-md-3 col-sm-6 category-item craft">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/23.jpg') }}" alt="Wooden Craft" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="asset-badges">
                            <span class="asset-badge badge-buy">Buy</span>
                        </div>
                    </div>
                    <div class="item-content theme_background">
                        <h4 class="item-meta">Wooden Sculpture</h4>
                        <p class="small grey">Craft • Woodworking</p>
                        <div class="price-tag">$79.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 10 - Places -->
            <div class="col-md-3 col-sm-6 category-item places">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/24.jpg') }}" alt="Beach Sunset" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Tropical Beach</h4>
                        <p class="small grey">Places • Beach</p>
                        <div class="price-tag">$17.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">License</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 11 - Photos -->
            <div class="col-md-3 col-sm-6 category-item photos">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/15.jpg') }}" alt="Portrait Photography" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Portrait Study</h4>
                        <p class="small grey">Photography • Portrait</p>
                        <div class="price-tag">$27.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image 12 - Illustrations -->
            <div class="col-md-3 col-sm-6 category-item illustrations">
                <div class="vertical-item text-center gallery-item content-absolute">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/16.jpg') }}" alt="Character Design" style="width:100%; height:250px; object-fit:cover;">
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
                        <h4 class="item-meta">Character Design</h4>
                        <p class="small grey">Illustration • Characters</p>
                        <div class="price-tag">$34.99</div>
                        <div class="image-actions topmargin_10">
                            <a href="#" class="theme_button small_button">Preview</a>
                            <a href="#" class="theme_button small_button color2">License</a>
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
    
    .vertical-item {
        margin-bottom: 30px;
        transition: transform 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .vertical-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .small_button {
        padding: 5px 12px;
        font-size: 12px;
        margin: 0 2px;
    }
    
    .image-actions {
        display: flex;
        justify-content: center;
        gap: 5px;
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
        
        .small_button {
            padding: 3px 8px;
            font-size: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
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
                
                // Get all image items
                const imageItems = document.querySelectorAll('#images-grid .category-item');
                
                // Filter items
                imageItems.forEach(item => {
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