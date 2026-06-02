<footer class="page_footer theme_footer ds section_padding_top_50 section_padding_bottom_110">
    @php
        $logoText  = \App\Models\SiteSetting::get('branding.logo_text', 'Ovatify');
        $logoImage = \App\Models\SiteSetting::image('branding.logo_image');
        $primary   = \App\Models\SiteSetting::get('branding.primary_color', '#FF00FF');
        $tagline   = \App\Models\SiteSetting::get('footer.tagline', 'Built for creators. Owned by you.');
        $copyright = \App\Models\SiteSetting::get('footer.copyright', '© '.date('Y').' Ovatify. All rights reserved.');
        $address   = \App\Models\SiteSetting::get('contact.address');
        $phone     = \App\Models\SiteSetting::get('contact.phone');
        $email     = \App\Models\SiteSetting::get('contact.email');

        $facebook  = \App\Models\SiteSetting::get('social.facebook');
        $twitter   = \App\Models\SiteSetting::get('social.twitter');
        $instagram = \App\Models\SiteSetting::get('social.instagram');
        $youtube   = \App\Models\SiteSetting::get('social.youtube');
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_text topmargin_60">
                    @if($logoImage)
                        <img src="{{ $logoImage }}" alt="{{ $logoText }}" class="bottommargin_30" style="max-height:52px; width:auto;">
                    @else
                        <div class="bottommargin_30" style="line-height:1;">
                            <span style="font-family:'Inter','Helvetica Neue',Arial,sans-serif; font-size:32px; font-weight:700; letter-spacing:-0.5px; color:{{ $primary }};">{{ $logoText }}</span>
                        </div>
                    @endif
                    <p>{{ $tagline }}</p>
                    <div class="topmargin_15">
                        @if($facebook)<a href="{{ $facebook }}" class="social-icon soc-facebook" target="_blank" rel="noopener"></a>@endif
                        @if($twitter)<a href="{{ $twitter }}" class="social-icon soc-twitter" target="_blank" rel="noopener"></a>@endif
                        @if($instagram)<a href="{{ $instagram }}" class="social-icon soc-instagram" target="_blank" rel="noopener"></a>@endif
                        @if($youtube)<a href="{{ $youtube }}" class="social-icon soc-youtube" target="_blank" rel="noopener"></a>@endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_links topmargin_60">
                    <h4 class="widget-title2">Marketplace</h4>
                    <ul>
                        <li><a href="{{ url('/music') }}">Music</a></li>
                        <li><a href="{{ url('/images') }}">Images</a></li>
                        <li><a href="{{ url('/merchandise') }}">Merchandise</a></li>
                        <li><a href="{{ url('/business') }}">Business</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_text topmargin_60">
                    <h4 class="widget-title2">Contact</h4>
                    <ul class="list1 no-bullets">
                        @if($address)<li>{{ $address }}</li>@endif
                        @if($phone)<li><a href="tel:{{ preg_replace('/\\s+/', '', $phone) }}">{{ $phone }}</a></li>@endif
                        @if($email)<li><a href="mailto:{{ $email }}">{{ $email }}</a></li>@endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_mailchimp topmargin_60">
                    <h4 class="widget-title2">Newsletter</h4>
                    <p>Get updates on new releases and investment opportunities.</p>
                    <form class="signup form-inline" action="#" method="post" onsubmit="return false;">
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" placeholder="Your email">
                        </div>
                        <button type="submit" class="theme_button">Subscribe</button>
                    </form>
                    <p class="small topmargin_10" style="opacity:.65;">(Newsletter integration pending)</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<section class="page_copyright ds ms doted_items table_section section_padding_25">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-left">
                <p>{{ $copyright }}</p>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <div class="greylinks">
                    <a href="#">Privacy</a> | <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </div>
</section>