@if(request()->routeIs('site.posts.show') && isset($post))
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "NewsArticle",
          "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ url()->current() }}"
            },
          "headline": "{{ $post->title }}",
          "datePublished": "{{ $post->published_at->toIso8601String() }}",
          "dateModified": "{{ !empty($post->updated_at) ? $post->updated_at->toIso8601String() : $post->published_at->toIso8601String() }}",
          "publisher": {
            "@type": "Organization",
            "name": "{{ config('site.site_name') }}",
            "logo": {
              "@type": "ImageObject",
              "url": "{{ url('images/site/logo.svg') }}"
            }
          }
        }
    </script>
@else
    <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Organization",
          "name" : "{{ config('site.site_name') }}",
          "url" : "{{ config('app.url') }}",
          "logo": "{{ url('images/site/logo.svg') }}",
          "sameAs" : [
            "https://www.facebook.com/PensarPiaui/",
            "https://www.instagram.com/pensarpiauioficial/",
            "https://twitter.com/pensarpiaui/",
            "https://www.youtube.com/channel/UCsUhBLPHeQ1oYysyn04zkeg"
          ]
        }
    </script>
@endif

