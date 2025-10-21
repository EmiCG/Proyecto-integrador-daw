<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PanelInfo extends Component
{
    public $classTitle;
    public $classDescription;
    /**
     * Create a new component instance.
     */
    public function __construct($type = 'gris/negro')
    {
        switch ($type) {
            case 'gris/negro':
               
                $classTitle = 'text-gray-900';
                $classDescription = 'text-gray-500';
                break;
    
            case 'rojo/azul':
        
                $classTitle = 'text-red-900';
                $classDescription = 'text-blue-500';
                break;
            
            case 'verde/naranja':
                   
                $classTitle = 'text-green-900';
                $classDescription = 'text-orange-500';
                    break;

            default:
                $classTitle = 'text-gray-900';
                $classDescription = 'text-gray-500';
                break;
        }

        $this->classTitle = $classTitle;
        $this->classDescription = $classDescription;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.panel-info');
    }
}
