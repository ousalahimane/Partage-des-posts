<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class updated extends Component
{
    public $date, $name, $userId;
    /**
     * Create a new component instance.
     */
    public function __construct($date, $name = null, $userId = null)
    {
        $this->date = $date;
        $this->name = $name;
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.updated');
    }
}
