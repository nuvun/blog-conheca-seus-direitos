<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
        <title>{{ config('app.name') }}</title>
        <description>Fique sempre bem informado sobre tudo o que acontece no Piaui, no Brasil e no Mundo. Acesse já!</description>
        <language>pt-br</language>
        <copyright>© Copyright {{ date('Y') }}, {{ config('app.name') }} - Todos os direitos reservados</copyright>
        <lastPubDate>{{ now()->toIso8601String() }}</lastPubDate>
        <link>{{ config('app.url') }}</link>
        <image>
            <title>{{ config('app.name') }}</title>
            <url>{{ asset('images/site/logo.svg') }}</url>
            <alt>{{ config('app.name') }}</alt>
            <link><![CDATA[{{ config('app.url') }}]]></link>
        </image>
        <generator>{{ config('app.name') }}</generator>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <description><![CDATA[{{ $post->subtitle }}]]></description>
                <link><![CDATA[{{ url($post->url) }}]]></link>
                <pubDate><![CDATA[{{ $post->created_at->toIso8601String() }}]]></pubDate>
                <guid><![CDATA[{{ url($post->url) }}]]></guid>
                <image>{{ $post->featuredImageUrl }}</image>
                <source url="{{ route('site.posts.feeds') }}">{{ config('app.name') }}</source>
            </item>
        @endforeach
    </channel>
</rss>
