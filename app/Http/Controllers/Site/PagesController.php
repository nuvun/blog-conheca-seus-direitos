<?php

namespace App\Http\Controllers\Site;

use Illuminate\View\View;

class PagesController
{

    public function termsOfUse(): View
    {
        $title = 'Termos de uso';

        return view('site.pages.terms-of-use', compact('title'));
    }

    public function privacyPolicy(): View
    {
        $title = 'Política de privacidade';

        return view('site.pages.privacy-policy', compact('title'));
    }

}
