@extends('layouts.web')

@section('title', 'Merchandise Store')

@section('content')

<section class="ls section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin grey">Shop</p>
                    <h2>Merchandise Store</h2>
                    <p>Posters, T-shirts, Mugs - Wear and share your favorite music</p>
                </div>
            </div>
        </div>
        
        <!-- Categories -->
        <div class="row bottommargin_30">
            <div class="col-sm-12 text-center category-filter">
                <a href="#" data-category="all" class="active">All</a>
                <a href="#" data-category="posters">Posters</a>
                <a href="#" data-category="t-shirts">T-shirts</a>
                <a href="#" data-category="mugs">Mugs</a>
                <a href="#" data-category="hoodies">Hoodies</a>
                <a href="#" data-category="caps">Caps</a>
            </div>
        </div>
        
        <!-- Merchandise Grid -->
        <div class="row" id="merchandise-grid">
            
            <!-- Product 1 - Poster -->
            <div class="col-md-3 col-sm-6 category-item posters">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/01.jpg') }}" alt="Limited Edition Poster" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="product-badge">
                            <span class="badge-sale">Sale!</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Limited Edition Poster</h4>
                        <p class="small grey">Poster • 18x24 inches</p>
                        <div class="price-tag">
                            <span class="old-price">$39.99</span>
                            <span>$29.99</span>
                        </div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star grey"></i>
                            <span class="small grey">(24 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 2 - T-shirt -->
            <div class="col-md-3 col-sm-6 category-item t-shirts">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/02.jpg') }}" alt="Artist Collection Tee" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Artist Collection Tee</h4>
                        <p class="small grey">T-shirt • 100% Cotton</p>
                        <div class="color-options topmargin_5">
                            <span class="color-dot black" title="Black"></span>
                            <span class="color-dot white" title="White"></span>
                            <span class="color-dot navy" title="Navy"></span>
                        </div>
                        <div class="price-tag">$34.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star-half highlight"></i>
                            <span class="small grey">(156 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 3 - Mug -->
            <div class="col-md-3 col-sm-6 category-item mugs">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/03.jpg') }}" alt="Ceramic Coffee Mug" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Ceramic Coffee Mug</h4>
                        <p class="small grey">Mug • 11oz</p>
                        <div class="price-tag">$14.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <span class="small grey">(89 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 4 - Poster -->
            <div class="col-md-3 col-sm-6 category-item posters">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/04.jpg') }}" alt="Vinyl Record Poster" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Vinyl Record Poster</h4>
                        <p class="small grey">Poster • 12x36 inches</p>
                        <div class="price-tag">$19.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star grey"></i>
                            <span class="small grey">(42 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 5 - Hoodie -->
            <div class="col-md-3 col-sm-6 category-item hoodies">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/01.jpg') }}" alt="Premium Hoodie" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="product-badge">
                            <span class="badge-new">New!</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Premium Hoodie</h4>
                        <p class="small grey">Hoodie • Fleece Lined</p>
                        <div class="color-options topmargin_5">
                            <span class="color-dot black" title="Black"></span>
                            <span class="color-dot gray" title="Gray"></span>
                            <span class="color-dot burgundy" title="Burgundy"></span>
                        </div>
                        <div class="price-tag">$59.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <span class="small grey">(67 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 6 - Cap -->
            <div class="col-md-3 col-sm-6 category-item caps">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/02.jpg') }}" alt="Snapback Cap" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Snapback Cap</h4>
                        <p class="small grey">Cap • Adjustable</p>
                        <div class="color-options topmargin_5">
                            <span class="color-dot black" title="Black"></span>
                            <span class="color-dot red" title="Red"></span>
                            <span class="color-dot blue" title="Blue"></span>
                        </div>
                        <div class="price-tag">$24.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star-half highlight"></i>
                            <span class="small grey">(103 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 7 - Mug -->
            <div class="col-md-3 col-sm-6 category-item mugs">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/03.jpg') }}" alt="Travel Mug" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                        <div class="product-badge">
                            <span class="badge-sale">Sale!</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Stainless Steel Travel Mug</h4>
                        <p class="small grey">Mug • 16oz • Double Wall</p>
                        <div class="price-tag">
                            <span class="old-price">$29.99</span>
                            <span>$22.99</span>
                        </div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star grey"></i>
                            <span class="small grey">(78 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 8 - T-shirt -->
            <div class="col-md-3 col-sm-6 category-item t-shirts">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/04.jpg') }}" alt="Vintage Tee" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Vintage Wash Tee</h4>
                        <p class="small grey">T-shirt • Soft Blend</p>
                        <div class="color-options topmargin_5">
                            <span class="color-dot vintage" title="Vintage Blue"></span>
                            <span class="color-dot cream" title="Cream"></span>
                        </div>
                        <div class="price-tag">$39.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <span class="small grey">(201 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 9 - Poster -->
            <div class="col-md-3 col-sm-6 category-item posters">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/01.jpg') }}" alt="Concert Poster" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Concert Tour Poster</h4>
                        <p class="small grey">Poster • 24x36 inches</p>
                        <div class="price-tag">$44.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star-half highlight"></i>
                            <span class="small grey">(56 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
                    </div>
                </div>
            </div>

            <!-- Product 10 - Hoodie -->
            <div class="col-md-3 col-sm-6 category-item hoodies">
                <div class="vertical-item text-center">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/shop/02.jpg') }}" alt="Zip-up Hoodie" style="width:100%; height:250px; object-fit:cover;">
                        <div class="media-links">
                            <div class="links-wrap">
                                <a class="p-link" href="#"></a>
                            </div>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Full Zip Hoodie</h4>
                        <p class="small grey">Hoodie • Cotton Blend</p>
                        <div class="color-options topmargin_5">
                            <span class="color-dot black" title="Black"></span>
                            <span class="color-dot navy" title="Navy"></span>
                            <span class="color-dot olive" title="Olive"></span>
                        </div>
                        <div class="price-tag">$69.99</div>
                        <div class="rating topmargin_10">
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star highlight"></i>
                            <i class="fa fa-star grey"></i>
                            <span class="small grey">(45 reviews)</span>
                        </div>
                        <a href="#" class="theme_button topmargin_10">Add to Cart</a>
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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .vertical-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
    }
    
    .badge-sale {
        background: #ff4757;
        color: white;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
    }
    
    .badge-new {
        background: #28a745;
        color: white;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
    }
    
    .price-tag {
        font-size: 18px;
        font-weight: bold;
        color: #7c3aed;
        margin-top: 5px;
    }
    
    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-right: 8px;
        font-weight: normal;
    }
    
    .rating {
        font-size: 12px;
    }
    
    .rating i {
        margin-right: 2px;
    }
    
    .color-options {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 10px 0;
    }
    
    .color-dot {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        cursor: pointer;
        border: 1px solid #ddd;
        transition: transform 0.2s;
    }
    
    .color-dot:hover {
        transform: scale(1.1);
    }
    
    .color-dot.black { background: #333; }
    .color-dot.white { background: #fff; border: 1px solid #ddd; }
    .color-dot.navy { background: #1a2a4f; }
    .color-dot.gray { background: #888; }
    .color-dot.burgundy { background: #800020; }
    .color-dot.red { background: #dc3545; }
    .color-dot.blue { background: #007bff; }
    .color-dot.vintage { background: #6c7a89; }
    .color-dot.cream { background: #f5e6d3; }
    .color-dot.olive { background: #556b2f; }
    
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
        
        .price-tag {
            font-size: 16px;
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
                
                // Get all merchandise items
                const merchandiseItems = document.querySelectorAll('#merchandise-grid .category-item');
                
                // Filter items
                merchandiseItems.forEach(item => {
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