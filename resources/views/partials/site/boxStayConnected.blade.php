<div class="munici__social__blk mb-3">
    <div class="munici__common__title">
        <h5>SIGA-NOS NAS REDES SOCIAIS</h5>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="munici__btn">
                <a href="{{ $settings['site.link_facebook'] ?? '' }}" title="Facebook - {{ config('app.name') }}" target="_blank">
                    <img src="/assets/img/social-btn-1.png" alt="Facebook - {{ config('app.name') }}" loading="lazy" />
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="munici__btn">
                <a href="{{ $settings['site.link_youtube'] ?? '' }}" title="YouTube - {{ config('app.name') }}" target="_blank">
                    <img src="/assets/img/social-btn-2.png" alt="YouTube - {{ config('app.name') }}" loading="lazy" />
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="munici__btn">
                <a href="{{ $settings['site.link_instagram'] ?? '' }}" title="Instagram - {{ config('app.name') }}" target="_blank">
                    <img src="/assets/img/social-btn-3.png" alt="Instagram - {{ config('app.name') }}" loading="lazy" />
                </a>
            </div>
        </div>
        <div class="col-xl-6 col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="munici__btn">
                <a href="{{ $settings['site.link_tiktok'] ?? '' }}" title="TikTok - {{ config('app.name') }}" target="_blank">
                    <img src="/assets/img/social-btn-4.png" alt="TikTok - {{ config('app.name') }}" loading="lazy" />
                </a>
            </div>
        </div>
    </div>
</div>
