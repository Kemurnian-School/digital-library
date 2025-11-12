<?php

namespace App\View\Components\Client;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Navbar extends Component
{
    public array $links;
    public string $nis;
    public string $logoSize;

    public function __construct()
    {
        $this->links = [
            ['label' => 'Home', 'href' => '/'],
            ['label' => 'Saved', 'href' => '/saved'],
        ];
        $this->nis = '1234';
        $this->logoSize = '2';
    }

    public function render(): View|Closure|string
    {
        return view('components.client.navbar');
    }
}
