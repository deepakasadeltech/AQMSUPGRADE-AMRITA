@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.queuesetting'))

@section('css')
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.queuesetting') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.mainapp.menu.queuesetting') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
        <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content" style="width:100%; float:left;">
                    <!--------------------------------->      
                        <div class="col s12 m6">
                            <form id="dsetting" action="{{ route('update_kiosktext') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="texteng">{{ trans('messages.kiosk.textineng') }}</label>
                                        <input id="texteng" type="text" name="texteng" placeholder="{{ trans('messages.kiosk.textineng') }}" value="{{ $kiosksetting->texteng }}" data-error=".texteng">
                                        <div class="texteng">
                                            @if($errors->has('texteng'))<div class="error">{{ $errors->first('texteng') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="textotherlang">{{ trans('messages.kiosk.textinother') }}</label>
                                        <input id="textotherlang" type="text" name="textotherlang" placeholder="{{ trans('messages.kiosk.textinother') }}" value="{{ $kiosksetting->textotherlang }}" data-error=".textotherlang">
                                        <div class="textotherlang">
                                            @if($errors->has('textotherlang'))<div id="textotherlang-error" class="error">{{ $errors->first('textotherlang') }}</div>@endif
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>Display Department Name In : </label>
                                    <select id="deptflag" name="deptflag">
                                    <option selected value="{{ $kiosksetting->deptflag }}">
                                    @if($kiosksetting->deptflag==1)  English
                                    @elseif($kiosksetting->deptflag==2) Other Language
                                    @elseif($kiosksetting->deptflag==3) Both @else English @endif</option>
                                    
                                    <option value="1">English</option>
                                    <option value="2">Other Language</option>
                                    <option value="3">Both</option>

                                    </select>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>Token Display (Department Wise/Doctor Wise) : </label>
                                    <select id="tokendisplay" name="tokendisplay">
                                    <option selected value="{{ $kiosksetting->tokendisplay }}">
                                    @if($kiosksetting->tokendisplay==1)  Department Wise
                                    @elseif($kiosksetting->tokendisplay==2) Doctor Wise
                                     @else Department Wise @endif</option>
                                    <option value="1">Department Wise</option>
                                    <option value="2">Doctor Wise</option>
                                    </select>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>In Doctor Wise Token Display Style View : </label>
                                    <select id="dr_tokenstyle" name="dr_tokenstyle">
                                    <option selected value="{{ $kiosksetting->dr_tokenstyle }}">
                                    @if($kiosksetting->dr_tokenstyle==1)  Department With Doctor
                                    @elseif($kiosksetting->dr_tokenstyle==2) Only Doctor
                                     @else  @endif</option>
                                    <option value="1">Department With Doctor</option>
                                    <option value="2">Only Doctor</option>
                                    </select>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>Registration Block Required (Yes/NO) : </label>
                                    <select id="reg_required" name="reg_required">
                                    <option selected value="{{ $kiosksetting->reg_required }}">
                                    @if($kiosksetting->reg_required==1)  YES
                                    @elseif($kiosksetting->reg_required==2) NO
                                     @else  @endif</option>
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                    </select>
                                    </div>
                                    </div>
                               
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit">
                                            {{ trans('messages.update') }}<i class="mdi-action-swap-vert left"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                           </div>
        <!---------------------------------------->
        <div class="col s12 m6">
            <form enctype="multipart/form-data" id="displaykiosk" action="{{ route('update_kioskbg') }}" method="post" >
            {{ csrf_field() }}
             <div class="row">
             <div class="input-field col s12">
             <span style="display:block">{{ trans('messages.kiosk.kioskbgimg') }}(size=1920px*1080px)</span>
             <input id="bgimg" type="file" name="bgimg" value="{{ $kiosksetting->bgimg }}">
             <button class="btn waves-effect waves-light right" type="submit">
            {{ trans('messages.update') }}<i class="mdi-action-swap-vert left"></i></button>
             <div style="width:100px; margin: auto"> <img style="max-width:100%" src="{{url('public/kiosksetting')}}/{{ $kiosksetting->bgimg }}" > </div>               
            </div>
            </div>
            
           
            </form>
                </div>
        <!---------------------------------------->                   


                        </div>
                    </div>
                </div>


        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function() {
            $('#department-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
