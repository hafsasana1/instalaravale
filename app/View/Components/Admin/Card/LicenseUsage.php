<?php

namespace App\View\Components\Admin\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LicenseUsage extends Component
{
    use InteractsWithLicense;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getLicense();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        return view('components.admin.card.license-usage');
    }
}
