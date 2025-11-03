<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Sidebar extends Component
{
    public array $links;

    public function __construct()
    {
        $this->links = [
            ['label' => 'Dashboard', 'href' => '/'],
            ['label' => 'Books', 'href' => '/books'],
            ['label' => 'Students', 'href' => '/students'],
            ['label' => 'Genres', 'href' => '/genres'],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
