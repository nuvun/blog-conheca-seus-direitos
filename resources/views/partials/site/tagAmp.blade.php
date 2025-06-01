@if(request()->routeIs('site.posts.show') && isset($post))
    <link rel="amphtml" href='{{ $post->urlAmp }}'>
@endif
