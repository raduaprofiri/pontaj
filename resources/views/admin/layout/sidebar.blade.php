<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            @if(!auth()->user()->hasRole('Employee'))
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/dashboard-a') }}"><i class="nav-icon icon-energy"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/projects') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.project.title') }}</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/dashboard-e') }}"><i class="nav-icon icon-energy"></i> Dashboard</a></li>
            @endif
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/timekeepings') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.timekeeping.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            @if(!auth()->user()->hasRole('Employee'))
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> Users</a></li>
            @endif
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
