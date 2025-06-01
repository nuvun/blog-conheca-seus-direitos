<div class="munici__social__blk news-most-read">
    <div class="munici__common__title">
        <h5>NOTÍCIAS MAIS LIDAS</h5>
    </div>
    <div class="munici__right__cards__blk">
        @foreach($postsMostRead as $post)
            <div class="r__munici__card__step">
                <a href="{{ $post->url }}" title="{{ $post->title }}" class="mb-3">
                    <div class="munici__right__c__thumb transtion_zoom">
                        <img src="/resize-image?src={{ $post->featuredImageUrl }}&w=130&h=121&a=t"
                             alt="{{ $post->title }}"
                             class="rounded"
                             loading="lazy"
                        />
                    </div>
                    <div class="munici__right__c__content">
                        <p>{{ $post->title }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
