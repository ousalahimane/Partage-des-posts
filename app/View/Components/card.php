<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class card extends Component
{
    public $title, $items;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $items = null)
    {
        $this->title = $title;
        $this->items = $items;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
