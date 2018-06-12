<?php

namespace App\Http\ViewComposers;

use App\Grow;
use Illuminate\View\View;

class NavbarComposer
{
    protected $grow;

    public function __construct(Grow $grow)
    {
        $this->grow = $grow;
    }

    public function compose(View $view)
    {
        $view->with('grows', $this->grow->ongoing()->get());
    }
}
