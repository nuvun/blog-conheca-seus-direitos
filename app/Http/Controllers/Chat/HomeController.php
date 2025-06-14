<?php

namespace App\Http\Controllers\Chat;

use Illuminate\View\View;

class HomeController
{

    public function index(): View
    {
        return view('chat.home.index');
    }

}
