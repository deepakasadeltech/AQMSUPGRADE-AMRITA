@extends('layouts.mainapp')

@section('menu')
    <li class="bold{!! Request::is('dashboard*') ? ' active' : '' !!}"><a href="{{ route('dashboard') }}" class="waves-effect waves-cyan truncate">
        <i class="mdi-hardware-laptop"></i> {{ trans('messages.mainapp.menu.dashboard') }}</a>
    </li>

	@can('access', \App\Models\Call::class)

        <li>
        <ul class="collapsible collapsible-accordion">
        <li class="bold">
        <a class="collapsible-header waves-effect waves-cyan truncate{!! Request::is('calls*') ? ' active' : '' !!}"><i class="mdi-communication-chat"></i> {{ trans('messages.mainapp.menu.token_issue') }}</a>
        <div class="collapsible-body">
        <ul>
        <li{!! Request::is('calls*') ? ' class="active"' : '' !!}><a href="{{ route('calls') }}" class="waves-effect waves-cyan truncate">
        <i class="mdi-image-filter-none"></i> {{ trans('messages.mainapp.menu.token_issue') }}</a>
        </li>
        <li{!! Request::is('calls/tokenmodify*') ? ' class="active"' : '' !!}><a href="{{ route('token_modify') }}" class="waves-effect waves-cyan truncate">
        <i class="mdi-maps-local-print-shop"></i> {{ trans('messages.mainapp.menu.token_modify') }}</a>
        </li>
        </ul>
        </div>
        </li>
        </ul>
        </li>

	@endcan
	
    @can('access', \App\Models\ParentDepartment::class)
	<li class="bold{!! Request::is('parent_departments*') ? ' active' : '' !!}"><a href="{{ route('parent_departments.index') }}" class="waves-effect waves-cyan truncate">
		<i class="mdi-communication-business"></i> {{ trans('messages.mainapp.menu.parent_department') }}</a>
	</li>
    @endcan
	
	
	@can('access', \App\Models\Department::class)
        <li class="bold{!! Request::is('departments*') ? ' active' : '' !!}"><a href="{{ route('departments.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-communication-business"></i> {{ trans('messages.mainapp.menu.department') }}</a>
        </li>
    @endcan
	
	
    @can('access', \App\Models\Counter::class)
        <li class="bold{!! Request::is('counters*') ? ' active' : '' !!}"><a href="{{ route('counters.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-action-view-quilt"></i> {{ trans('messages.mainapp.menu.counter') }}</a>
        </li>
    @endcan

    @can('access', \App\Models\Ad::class)
        <li class="bold{!! Request::is('ads*') ? ' active' : '' !!}"><a href="{{ route('ads.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-action-picture-in-picture"></i> {{ trans('messages.mainapp.menu.ads') }}</a>
        </li>
    @endcan

    @can('access', \App\Models\User::class)
        <li>
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-cyan truncate{!! Request::is('reports*') ? ' active' : '' !!}"><i class="mdi-editor-insert-chart"></i> {{ trans('messages.mainapp.menu.reports.reports') }}</a>
                    <div class="collapsible-body">
                        <ul>
                            <li{!! Request::is('reports/user*') ? ' class="active"' : '' !!}><a href="{{ route('reports::user') }}" class="truncate"> {{ trans('messages.mainapp.menu.reports.user_report') }}</a></li>

                            <li{!! Request::is('reports/queuelist*') ? ' class="active"' : '' !!}><a href="{{ route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')]) }}" class="truncate"> {{ trans('messages.mainapp.menu.reports.queue_list') }}</a></li>
                            <li{!! Request::is('reports/monthly*') ? ' class="active"' : '' !!}><a href="{{ route('reports::monthly') }}" class="truncate"> {{ trans('messages.mainapp.menu.reports.monthly') }}</a></li>
                            <li{!! Request::is('reports/statistical*') ? ' class="active"' : '' !!}><a href="{{ route('reports::statistical') }}" class="truncate"> {{ trans('messages.mainapp.menu.reports.statistical') }}</a></li>
                            <li{!! Request::is('reports/missed-overtime*') ? ' class="active"' : '' !!}><a href="{{ route('reports::missed') }}" class="truncate"> {{ trans('messages.mainapp.menu.reports.missed') }} / {{ trans('messages.mainapp.menu.reports.overtime') }}</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    @endcan

    @can('access', \App\Models\User::class)
        <li class="bold{!! Request::is('users*') ? ' active' : '' !!}"><a href="{{ route('users.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-social-group"></i> {{ trans('messages.mainapp.menu.users') }}</a>
        </li>
    @endcan


    @can('access', \App\Models\DisplaySetting::class)
        <li class="bold{!! Request::is('displaysettings*') ? ' active' : '' !!}"><a href="{{ route('displaysettings.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-image-crop-landscape"></i> {{ trans('messages.mainapp.menu.displaysetting') }}</a>
        </li>
    @endcan

    @can('access', \App\Models\QueueSetting::class)
        <li class="bold{!! Request::is('queuesettings*') ? ' active' : '' !!}"><a href="{{ route('queuesettings.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-editor-format-list-numbered"></i> {{ trans('messages.mainapp.menu.queuesetting') }}</a>
        </li>
    @endcan

    @can('access', \App\Models\Limit::class)
        <li class="bold{!! Request::is('limits*') ? ' active' : '' !!}"><a href="{{ route('limits.index') }}" class="waves-effect waves-cyan truncate">
            <i class="mdi-image-crop-landscape"></i> {{ trans('messages.mainapp.menu.updatelimit') }}</a>
        </li>
    @endcan


    <li class="bold{!! Request::is('settings*') ? ' active' : '' !!}"><a href="{{ route('settings') }}" class="waves-effect waves-cyan truncate">
        <i class="mdi-action-settings"></i> {{ trans('messages.settings') }}</a>
    </li>

    
     
    

    <br><br>

    


@endsection
