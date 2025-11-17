<?php

namespace App\View\Components\Client;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Navbar extends Component
{
    public array $links;
    public ?string $nis;
    public bool $isGuest;
    public bool $needsPasswordSetup;
    public bool $isLoggedIn;

    public function __construct()
    {
        $this->links = [
            ['label' => 'Home', 'href' => '/'],
            ['label' => 'Saved', 'href' => '/saved'],
        ];

        // Check if user is logged in (has student_id in session)
        $this->isLoggedIn = session()->has('student_id');
        $this->isGuest = session('is_guest', false);
        $this->nis = session('student_nis');
        $this->needsPasswordSetup = session('needs_password_setup', false);
    }

    public function render(): View|Closure|string
    {
        return view('components.client.navbar');
    }
}
