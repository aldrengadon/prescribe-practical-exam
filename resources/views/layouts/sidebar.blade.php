<div id="page-sidebar">
    <div class="scroll-sidebar">
        <ul id="sidebar-menu">
            <li class="header"><span>Modules</span></li>
            @foreach ($modules as $module)
                {{--{{ $module->label }} / {{ $module->route }}--}}
                @if (Route::has($module->route))
                    <li>
                        <a href="{{ route($module->route) }}" title="{{ $module->label }}">
                            <i class="glyph-icon {{ $module->icon }}"></i>
                            <span>{{ $module->label }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
