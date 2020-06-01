<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public $icon;
    public $width;
    public $height;
    public $viewBox;
    public $fill;
    public $strokeWidth;
    public $id;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $icon = null,
        $width = 34,
        $height = 34,
        $viewBox = '24 24',
        $class = 'icon'
    )
    {
        $this->icon = $icon;
        $this->width = $width;
        $this->height = $height;
        $this->class = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('desktop.components.icon');
    }
}
