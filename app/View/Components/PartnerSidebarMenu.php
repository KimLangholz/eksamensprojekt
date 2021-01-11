<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PartnerSidebarMenu extends Component
{

    public $activePage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($activePage)
    {
        $this->activePage = $activePage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partner-sidebar-menu');
    }
}