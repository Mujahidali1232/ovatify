@extends('layouts.web')

@section('title', 'Business & Investment Opportunities')

@section('content')

<section class="ls section_padding_110">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="heading">
                    <p class="text-uppercase josefin grey">Invest</p>
                    <h2>Invest in Music & Art</h2>
                    <p>Earn royalties from the next generation of creative assets</p>
                </div>
            </div>
        </div>
        
        <!-- How It Works -->
        <div class="row topmargin_50">
            <div class="col-md-4 text-center">
                <i class="flaticon-music-player fontsize_60 highlight"></i>
                <h3 class="topmargin_20">1. Discover</h3>
                <p>Browse music and image assets looking for investment</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="flaticon-chart fontsize_60 highlight"></i>
                <h3 class="topmargin_20">2. Invest</h3>
                <p>Purchase ownership blocks in assets you believe in</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="flaticon-money fontsize_60 highlight"></i>
                <h3 class="topmargin_20">3. Earn</h3>
                <p>Receive dividends from licensing and sales</p>
            </div>
        </div>
        
        <!-- Statistics Section -->
        <div class="row topmargin_60 bottommargin_30">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="stat-box">
                            <h3 class="highlight">$250K+</h3>
                            <p>Total Invested</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-box">
                            <h3 class="highlight">15%+</h3>
                            <p>Average ROI</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-box">
                            <h3 class="highlight">50+</h3>
                            <p>Active Investments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Investment Opportunities -->
        <div class="row topmargin_60">
            <div class="col-sm-12">
                <h3 class="text-center">Current Investment Opportunities</h3>
                <p class="text-center grey">Invest in these trending assets and earn royalties</p>
            </div>
        </div>
        
        <div class="row topmargin_30">
            <!-- Investment Opportunity 1 -->
            <div class="col-md-6 bottommargin_30">
                <div class="vertical-item media-teaser investment-card">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/03.jpg') }}" alt="Desert Storm Beat" style="width:100%; height:250px; object-fit:cover;">
                        <div class="investment-badge">
                            <span class="badge-roi">ROI: 15.5%</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Desert Storm Beat</h4>
                        <p class="small grey">by Nomad Beats • Electronic / World</p>
                        <p>High-energy electronic beat with Middle Eastern influences. Perfect for sync licensing, commercials, and film placements.</p>
                        <ul class="investment-details">
                            <li><i class="fa fa-tag"></i> Valuation: <strong>$10,000</strong></li>
                            <li><i class="fa fa-cubes"></i> Price per block: <strong>$100</strong></li>
                            <li><i class="fa fa-line-chart"></i> Expected ROI: <strong class="highlight">15.5%</strong></li>
                            <li><i class="fa fa-pie-chart"></i> Remaining blocks: <strong>65/80</strong></li>
                            <li><i class="fa fa-calendar"></i> Term: <strong>36 months</strong></li>
                        </ul>
                        <div class="progress topmargin_20">
                            <div class="progress-bar" role="progressbar" style="width: 19%;" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100">19% Funded</div>
                        </div>
                        <a href="#" class="theme_button topmargin_20">Invest Now →</a>
                    </div>
                </div>
            </div>

            <!-- Investment Opportunity 2 -->
            <div class="col-md-6 bottommargin_30">
                <div class="vertical-item media-teaser investment-card">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/04.jpg') }}" alt="Neon Skyline" style="width:100%; height:250px; object-fit:cover;">
                        <div class="investment-badge">
                            <span class="badge-roi">ROI: 12.0%</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Neon Skyline</h4>
                        <p class="small grey">by Cinematic Orchestra • Orchestral / Cinematic</p>
                        <p>Cinematic orchestral piece for film scoring with grand orchestral swells and electronic undertones.</p>
                        <ul class="investment-details">
                            <li><i class="fa fa-tag"></i> Valuation: <strong>$8,500</strong></li>
                            <li><i class="fa fa-cubes"></i> Price per block: <strong>$85</strong></li>
                            <li><i class="fa fa-line-chart"></i> Expected ROI: <strong class="highlight">12.0%</strong></li>
                            <li><i class="fa fa-pie-chart"></i> Remaining blocks: <strong>50/100</strong></li>
                            <li><i class="fa fa-calendar"></i> Term: <strong>48 months</strong></li>
                        </ul>
                        <div class="progress topmargin_20">
                            <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50% Funded</div>
                        </div>
                        <a href="#" class="theme_button topmargin_20">Invest Now →</a>
                    </div>
                </div>
            </div>

            <!-- Investment Opportunity 3 -->
            <div class="col-md-6 bottommargin_30">
                <div class="vertical-item media-teaser investment-card">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/21.jpg') }}" alt="Digital Dreams" style="width:100%; height:250px; object-fit:cover;">
                        <div class="investment-badge">
                            <span class="badge-roi">ROI: 10.0%</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Digital Dreams</h4>
                        <p class="small grey">by Artify Studio • Digital Illustration</p>
                        <p>Stunning digital art collection perfect for NFT drops, merchandise licensing, and gallery exhibitions.</p>
                        <ul class="investment-details">
                            <li><i class="fa fa-tag"></i> Valuation: <strong>$15,000</strong></li>
                            <li><i class="fa fa-cubes"></i> Price per block: <strong>$150</strong></li>
                            <li><i class="fa fa-line-chart"></i> Expected ROI: <strong class="highlight">10.0%</strong></li>
                            <li><i class="fa fa-pie-chart"></i> Remaining blocks: <strong>40/100</strong></li>
                            <li><i class="fa fa-calendar"></i> Term: <strong>24 months</strong></li>
                        </ul>
                        <div class="progress topmargin_20">
                            <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60% Funded</div>
                        </div>
                        <a href="#" class="theme_button topmargin_20">Invest Now →</a>
                    </div>
                </div>
            </div>

            <!-- Investment Opportunity 4 -->
            <div class="col-md-6 bottommargin_30">
                <div class="vertical-item media-teaser investment-card">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/05.jpg') }}" alt="Summer Love" style="width:100%; height:250px; object-fit:cover;">
                        <div class="investment-badge">
                            <span class="badge-roi">ROI: 18.0%</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Summer Love</h4>
                        <p class="small grey">by Pop Star • Pop / Mainstream</p>
                        <p>Upbeat pop track with viral potential. Already featured on 5+ Spotify playlists.</p>
                        <ul class="investment-details">
                            <li><i class="fa fa-tag"></i> Valuation: <strong>$20,000</strong></li>
                            <li><i class="fa fa-cubes"></i> Price per block: <strong>$200</strong></li>
                            <li><i class="fa fa-line-chart"></i> Expected ROI: <strong class="highlight">18.0%</strong></li>
                            <li><i class="fa fa-pie-chart"></i> Remaining blocks: <strong>30/100</strong></li>
                            <li><i class="fa fa-calendar"></i> Term: <strong>36 months</strong></li>
                        </ul>
                        <div class="progress topmargin_20">
                            <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70% Funded</div>
                        </div>
                        <a href="#" class="theme_button topmargin_20">Invest Now →</a>
                    </div>
                </div>
            </div>

            <!-- Investment Opportunity 5 -->
            <div class="col-md-6 bottommargin_30">
                <div class="vertical-item media-teaser investment-card">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/14.jpg') }}" alt="Mountain Landscape" style="width:100%; height:250px; object-fit:cover;">
                        <div class="investment-badge">
                            <span class="badge-roi">ROI: 8.5%</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Mountain Landscape Photography</h4>
                        <p class="small grey">by Nature Lens • Photography</p>
                        <p>Premium nature photography collection ready for stock licensing and print sales.</p>
                        <ul class="investment-details">
                            <li><i class="fa fa-tag"></i> Valuation: <strong>$5,000</strong></li>
                            <li><i class="fa fa-cubes"></i> Price per block: <strong>$50</strong></li>
                            <li><i class="fa fa-line-chart"></i> Expected ROI: <strong class="highlight">8.5%</strong></li>
                            <li><i class="fa fa-pie-chart"></i> Remaining blocks: <strong>80/100</strong></li>
                            <li><i class="fa fa-calendar"></i> Term: <strong>24 months</strong></li>
                        </ul>
                        <div class="progress topmargin_20">
                            <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20% Funded</div>
                        </div>
                        <a href="#" class="theme_button topmargin_20">Invest Now →</a>
                    </div>
                </div>
            </div>

            <!-- Investment Opportunity 6 -->
            <div class="col-md-6 bottommargin_30">
                <div class="vertical-item media-teaser investment-card">
                    <div class="item-media">
                        <img src="{{ asset('theme/images/models_square/22.jpg') }}" alt="Modern Expressions" style="width:100%; height:250px; object-fit:cover;">
                        <div class="investment-badge">
                            <span class="badge-roi">ROI: 14.0%</span>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4>Modern Expressions</h4>
                        <p class="small grey">by Contemporary Art • Fine Art</p>
                        <p>Contemporary art collection featured in 3 galleries. Includes exclusive licensing rights.</p>
                        <ul class="investment-details">
                            <li><i class="fa fa-tag"></i> Valuation: <strong>$12,000</strong></li>
                            <li><i class="fa fa-cubes"></i> Price per block: <strong>$120</strong></li>
                            <li><i class="fa fa-line-chart"></i> Expected ROI: <strong class="highlight">14.0%</strong></li>
                            <li><i class="fa fa-pie-chart"></i> Remaining blocks: <strong>55/100</strong></li>
                            <li><i class="fa fa-calendar"></i> Term: <strong>36 months</strong></li>
                        </ul>
                        <div class="progress topmargin_20">
                            <div class="progress-bar" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45% Funded</div>
                        </div>
                        <a href="#" class="theme_button topmargin_20">Invest Now →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row topmargin_60">
            <div class="col-sm-12">
                <h3 class="text-center">Frequently Asked Questions</h3>
                <p class="text-center grey">Learn more about investing on Ovatify</p>
            </div>
        </div>
        
        <div class="row topmargin_30">
            <div class="col-md-6">
                <div class="faq-item bottommargin_30">
                    <h4><i class="fa fa-question-circle highlight"></i> How does investing work?</h4>
                    <p>You purchase ownership blocks in an asset. When that asset generates revenue from sales or licensing, you receive dividends based on your ownership percentage.</p>
                </div>
                <div class="faq-item bottommargin_30">
                    <h4><i class="fa fa-question-circle highlight"></i> What is the minimum investment?</h4>
                    <p>Minimum investment starts at $50 per block. You can purchase multiple blocks to increase your ownership stake in an asset.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="faq-item bottommargin_30">
                    <h4><i class="fa fa-question-circle highlight"></i> How do I receive returns?</h4>
                    <p>Dividends are distributed monthly to your Ovatify wallet. You can withdraw funds or reinvest in new opportunities.</p>
                </div>
                <div class="faq-item bottommargin_30">
                    <h4><i class="fa fa-question-circle highlight"></i> Can I sell my blocks?</h4>
                    <p>Yes! Our secondary marketplace allows you to sell your ownership blocks to other investors at any time.</p>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="row topmargin_60">
            <div class="col-sm-12 text-center">
                <div class="cta-box">
                    <h3>Ready to start investing?</h3>
                    <p>Join thousands of investors earning royalties from creative assets</p>
                    <a href="{{ route('register') }}" class="theme_button margin_0">Create Free Account →</a>
                </div>
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
        background: rgba(124, 58, 237, 0.05);
        border-radius: 10px;
        margin: 10px 0;
        transition: all 0.3s;
    }
    
    .stat-box:hover {
        background: rgba(124, 58, 237, 0.1);
        transform: translateY(-3px);
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
    
    .investment-card {
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .investment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .investment-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }
    
    .badge-roi {
        background: #ffc107;
        color: #333;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: bold;
    }
    
    .investment-details {
        list-style: none;
        padding-left: 0;
        margin: 15px 0;
    }
    
    .investment-details li {
        padding: 5px 0;
        font-size: 14px;
    }
    
    .investment-details li i {
        width: 25px;
        color: #7c3aed;
    }
    
    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: #e9ecef;
    }
    
    .progress-bar {
        background-color: #7c3aed;
        border-radius: 4px;
        font-size: 10px;
        line-height: 8px;
        color: white;
        padding-left: 5px;
    }
    
    .faq-item h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .faq-item h4 i {
        margin-right: 10px;
    }
    
    .cta-box {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        padding: 50px 30px;
        border-radius: 15px;
        color: white;
    }
    
    .cta-box h3 {
        font-size: 32px;
        margin-bottom: 15px;
    }
    
    .cta-box p {
        font-size: 18px;
        margin-bottom: 25px;
        opacity: 0.9;
    }
    
    .cta-box .theme_button {
        background: white;
        color: #7c3aed;
    }
    
    .cta-box .theme_button:hover {
        background: #f0f0f0;
        color: #5b21b6;
    }
    
    @media (max-width: 768px) {
        .stat-box h3 {
            font-size: 20px;
        }
        
        .investment-details li {
            font-size: 12px;
        }
        
        .cta-box {
            padding: 30px 20px;
        }
        
        .cta-box h3 {
            font-size: 24px;
        }
        
        .cta-box p {
            font-size: 16px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
@endpush