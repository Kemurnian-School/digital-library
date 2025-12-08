<?php

namespace App\View\Components\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Sidebar extends Component
{
    public array $links;

    public function __construct()
    {
        $this->links = [
            ['label' => 'Dashboard', 'href' => '/admin'],
            ['label' => 'Books', 'href' => '/admin/books'],
            ['label' => 'Classrooms', 'href' => '/admin/classrooms'],
            ['label' => 'Students', 'href' => '/admin/students'],
            ['label' => 'Genres', 'href' => '/admin/genres'],
            ['label' => 'Borrow Request', 'href' => '/admin/borrow-request'],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.sidebar');
    }
}
