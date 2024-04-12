<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class errors extends Component
{
    public $myClass;
    /**
     * Create a new component instance.
     */
    public function __construct($myClass = 'danger')
    {
        $this->myClass = $myClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.errors');
    }
}
