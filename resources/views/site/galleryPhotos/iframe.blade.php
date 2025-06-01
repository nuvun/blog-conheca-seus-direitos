<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/flexslider-min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js?ver=1.9.1"></script>

<style type="text/css">
    .flexslider { margin-bottom: 10px !important; }

    #slider .flex-viewport {
        height: 550px !important;
    }

    #carousel .flex-viewport {
        height: 60px !important;
    }

    #slider .slides img {
        width: auto;
        height: 100%;
        margin: 0 auto;
        max-width: 100%;
        /*object-fit: contain;*/
    }

    .flex-direction-nav .flex-prev, .flexslider:hover .flex-prev {
        left: -10px !important;
    }

    .flex-direction-nav .flex-next, .flexslider:hover .flex-prev {
        right: -10px !important;
    }

    @media only screen and (max-width: 450px) {
        #slider .flex-viewport {
            height: 300px !important;
        }

        #carousel .flex-viewport li {
            width: auto !important;
        }

        #carousel .flex-viewport li img {
            width: 100px;
        }
    }
</style>

<div id='slider' class='flexslider'>
    <ul class="slides">
        @foreach($galleryPhoto->images as $image)
            <li>
                <img src="{{ $image->getUrl('webp') }}" alt="{{ $image->name }}"
                     loading="lazy"
                />
            </li>
        @endforeach
    </ul>
</div>

<div id='carousel' class='flexslider'>
    <ul class='slides'>
        @foreach($galleryPhoto->images as $image)
            <li style='padding-left:5px;'>
                <img src="{{ $image->preview }}" alt="{{ $image->name }}" loading="lazy"/>
            </li>
        @endforeach
    </ul>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/jquery.flexslider-min.js'></script>
<script type="text/javascript">
    $(window).load(function() {
        $('#carousel').flexslider({
            animation: 'slide',
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 60,
            temMargin: 5,
            asNavFor: '#slider'
        });

        $('#slider').flexslider({
            animation: 'slide',
            controlNav: false,
            animationLoop: false,
            slideshow: true,
            sync: "#carousel"
        });
    });

    $('ol.flex-control-nav').remove();
</script>
