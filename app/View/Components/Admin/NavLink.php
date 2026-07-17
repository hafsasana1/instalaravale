<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component
{
    public string $text;
    public string $href;
    public string $icon;
    public bool $active;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $text,
        string $href,
        string $icon
    )
    {
        $this->text = $text;
        $this->href = $href;
        $this->icon = $icon;

        $this->active = request()->is($href . '/*') ||
            request()->fullUrlIs($href);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.nav-link');
    }
}
