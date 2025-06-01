<div class="header__top__area d-none d-lg-block">
    <div class="container">
        <div class="header__top__blk">
            <div class="header__letest__news">
                <div class="header__news__content">
                    <a href="{{ route('site.posts.index') }}" class="news-title" title="ÚLTIMAS NOTÍCIAS">
                        ÚLTIMAS NOTÍCIAS
                    </a>

                    <div class="news-container">
                        @foreach($lastPosts ?? [] as $post)
                            <div @class(['news', 'fade', 'active' => $loop->first])>
                                <a href="{{ $post->url }}" title="{{ $post->title }}" class="news-link" style="background: none;">
                                    {{ $post->title }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="header__top__slider">
                    <div class="slider__icon prev" onclick="changeNews(-1)">
                        <span><i class="fas fa-chevron-left"></i></span>
                    </div>
                    <div class="slider__icon next" onclick="changeNews(1)">
                        <span><i class="fas fa-chevron-right"></i></span>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let currentNewsIndex = 0;
                    const newsItems = document.querySelectorAll('.news');
                    const totalNews = newsItems.length;
                    let newsInterval;

                    function showNews(index) {
                        newsItems.forEach((news, i) => {
                            news.classList.remove('active');
                            if (i === index) {
                                news.classList.add('active');
                            }
                        });
                    }

                    function changeNews(direction) {
                        currentNewsIndex = (currentNewsIndex + direction + totalNews) % totalNews;
                        showNews(currentNewsIndex);
                        resetInterval();
                    }

                    function startNewsRotation() {
                        newsInterval = setInterval(() => {
                            changeNews(1);
                        }, 5000);
                    }

                    function resetInterval() {
                        clearInterval(newsInterval);
                        startNewsRotation();
                    }

                    startNewsRotation();
                    showNews(currentNewsIndex);

                    document.querySelector('.prev').addEventListener('click', () => {
                        changeNews(-1);
                    });
                    document.querySelector('.next').addEventListener('click', () => {
                        changeNews(1);
                    });
                });
            </script>

            <div class="header__social__area">
                <div class="date_content">
                    <p>{{ ucfirst(now()->isoFormat('dddd, D [de] MMMM [de] YYYY, HH:mm')) }}</p>
                </div>

                <div class="social__link">
                    <a href="{{ $settings['site.link_facebook'] ?? '' }}" title="Facebook" class="facebook" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $settings['site.link_instagram'] ?? '' }}" title="Instagram" class="instagram" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $settings['site.link_youtube'] ?? '' }}" title="YouTube" class="youtube" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="{{ $settings['site.grupo_whatsapp'] ?? '' }}" title="WhatsApp" class="whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="{{ $settings['site.link_telegram'] ?? '' }}" title="Telegram" class="telegram" target="_blank">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                    <a href="{{ $settings['site.link_tiktok'] ?? '' }}" title="tiktok" class="tiktok" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>

                <form method="GET" action="{{ route('site.posts.search') }}">
                    <div class="header__search">
                        <input type="search" name="term" value="{{ request('term') }}" placeholder="O que você procura?" autocomplete="off" required />
                        <button class="btn p-0" type="submit" style="font-size: 20px; color: #434446;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
