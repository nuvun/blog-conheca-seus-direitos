<?php

namespace App\Http\Controllers\Site;

use Illuminate\View\View;

class PagesController
{

    public function about(): View
    {
        $title = 'Quem somos';

        return view('site.pages.about', compact('title'));
    }

    public function privacyPolicy(): View
    {
        $title = 'Política de privacidade';

        return view('site.pages.privacy-policy', compact('title'));
    }

}
