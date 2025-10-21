@props(['type' => 'gris/negro'])

@php
    
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

@endphp

<div>
    <div class="px-4 sm:px-0 mb-5">
      <h3 class="text-base/7 font-semibold {{$classTitle}}">{{$title ?? 'error en el titulo'}}</h3>
      <p class="mt-1 max-w-2xl text-sm/6 {{$classDescription}}">{{$description ?? 'error en la descripcion'}}</p>
    </div>
</div>