<div class="munici__social__blk">
    <div class="munici__common__title">
        <h5>VÍDEOS</h5>
    </div>
    <div class="munici__right__cards__blk">
        @foreach($lastVideos->slice(0, 1) as $video)
            <div class="r__munici__card__step">
                <a class="d-block" href="{{ $video->url }}" title="{{ $video->title }}">
                    <div class="munici__right__c__thumb w-100 h-auto transtion_zoom">
                        <img src="{{ $video?->featuredImage?->url }}"
                             alt="{{ $video->title }}"
                             class="object-fit-contain"
                             loading="lazy"
                        />
                    </div>
                    <div class="munici__right__c__content">
                        <p>{{ $video->title }}</p>
                    </div>
                </a>
            </div>
        @endforeach

        @foreach($lastVideos->slice(1, 4) as $video)
            <div class="r__munici__card__step">
                <a href="{{ $video->url }}" title="{{ $video->title }}">
                    <div class="munici__right__c__thumb transtion_zoom" style="width: 150px;">
                        <img src="{{ $video?->featuredImage?->url }}"
                             alt="{{ $video->title }}"
                             class="object-fit-contain"
                             loading="lazy"
                        />
                    </div>
                    <div class="munici__right__c__content">
                        <p>{{ $video->title }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
