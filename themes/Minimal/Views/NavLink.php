<?php

namespace Themes\Minimal\Views;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component
{
    public string $text;
    public string $href;
    public bool $active = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $text, string $href)
    {
        $this->text = $text;
        $this->href = $href;

        $this->active = request()->is($href . '/*') ||
            request()->fullUrlIs($href);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        return view('theme::components.nav-link');
    }
}
