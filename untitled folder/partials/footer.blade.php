<footer class="page_footer theme_footer ds section_padding_top_50 section_padding_bottom_110">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_text topmargin_60">
                    <img src="{{ asset('theme/images/logo_dark.png') }}" alt="Ovatify" class="bottommargin_30">
                    <p>License, buy, or invest in music, images, and merchandise from creators worldwide.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_links topmargin_60">
                    <h4 class="widget-title2">Marketplace</h4>
                    <ul>
                        <li><a href="{{ url('/marketplace/music') }}">Music</a></li>
                        <li><a href="{{ url('/marketplace/images') }}">Images</a></li>
                        <li><a href="{{ url('/marketplace/merchandise') }}">Merchandise</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_links topmargin_60">
                    <h4 class="widget-title2">Support</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="widget widget_mailchimp topmargin_60">
                    <h4 class="widget-title2">Newsletter</h4>
                    <p>Get updates on new releases and investment opportunities.</p>
                    <form class="signup form-inline">
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" placeholder="Your email">
                        </div>
                        <button type="submit" class="theme_button">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</footer>

<section class="page_copyright ds ms doted_items table_section section_padding_25">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-left">
                <p>&copy; {{ date('Y') }} Ovatify. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <div class="greylinks">
                    <a href="#">Privacy</a> | <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </div>
</section>