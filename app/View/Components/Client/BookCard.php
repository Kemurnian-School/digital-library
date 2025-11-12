<?php
namespace App\View\Components\Client;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class BookCard extends Component
{
    public string $title;
    public string $link;
    public string $author;
    public string $year;
    public string $genre;
    public string $coverSrc;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        string $link,
        string $author,
        string $year,
        string $genre,
        string $coverSrc
    ) {
        $this->title = $title;
        $this->link = $link;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
        $this->coverSrc = $coverSrc;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.book-card');
    }
}
