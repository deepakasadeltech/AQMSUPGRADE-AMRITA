@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.displaysetting'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.displaysetting') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.mainapp.menu.displaysetting') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
        <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content" style="float:left;">
                        
                            <div class="col s12 m6">
                            <form id="dsetting" action="{{ route('update_displaytext') }}" method="post" >
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="textup">Text Up</label>
                                        <input id="textup" type="text" name="textup" placeholder="{{ trans('messages.name') }}" value="{{ $displaysetting->textup }}" data-error=".textup">
                                        <div class="textup">
                                            @if($errors->has('textup'))<div class="error">{{ $errors->first('textup') }}</div>@endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="textdown">Text Down</label>
                                        <input id="textdown" type="text" name="textdown" placeholder="{{ trans('messages.users.email') }}" value="{{ $displaysetting->textdown }}" data-error=".textdown">
                                        <div class="textdown">
                                            @if($errors->has('textdown'))<div id="textdown-error" class="error">{{ $errors->first('textdown') }}</div>@endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="work">Going Instruction</label>
                                        <input id="work" type="text" name="work" placeholder="{{ trans('messages.users.email') }}" value="{{ $displaysetting->work }}" data-error=".work">
                                        <div class="work">
                                            @if($errors->has('work'))<div id="work-error" class="error">{{ $errors->first('work') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
             
             <!----------------------->
           
                <div class="row">
                    <div class="col s12">
                        <label>Department Name Display in Heading : </label>
                        <select id="deptflag" name="deptflag">
                 @if($displaysetting->deptflag==1) 
                 <option selected value="{{ $displaysetting->deptflag }}">English</option>
                 @elseif($displaysetting->deptflag==2) 
                 <option selected value="{{ $displaysetting->deptflag }}">Other Language</option>
                 @elseif($displaysetting->deptflag==3)
                 <option selected value="{{ $displaysetting->deptflag }}"> Both </option>
                 @else @endif
                 <option value="1">English</option>
                    <option value="2">Other Language</option>
                    <option value="3">Both</option>
                    
                        </select>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <label>Department Name Display in Table : </label>
                        <select id="deptcflag" name="deptcflag">
                 @if($displaysetting->deptcflag==1) 
                 <option selected value="{{ $displaysetting->deptcflag }}">English</option>
                 @elseif($displaysetting->deptcflag==2) 
                 <option selected value="{{ $displaysetting->deptcflag }}">Other Language</option>
                 @elseif($displaysetting->deptcflag==3)
                 <option selected value="{{ $displaysetting->deptcflag }}"> Both </option>
                 @else @endif
                 <option value="1">English</option>
                    <option value="2">Other Language</option>
                    <option value="3">Both</option>
                    
                        </select>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <label>Display Column Option (Doctor or Department) : </label>
                        <select id="columnflag" name="columnflag">
                 @if($displaysetting->columnflag==1) 
                 <option selected value="{{ $displaysetting->columnflag }}">Department Name</option>
                 @elseif($displaysetting->columnflag==2) 
                 <option selected value="{{ $displaysetting->columnflag }}">Doctor Name</option>
                 @elseif($displaysetting->columnflag==3)
                 <option selected value="{{ $displaysetting->columnflag }}"> Both </option>
                 @else @endif
                 <option value="1">Department Name</option>
                    <option value="2">Doctor Name</option>
                    <option value="3">Both</option>
                    
                        </select>
                       
                    </div>
                </div>

                

                <div class="row">
                    <div class="col s12">
                        <label>Doctor Name Display in : </label>
                        <select id="doctorflag" name="doctorflag">
                    <option value="{{ $displaysetting->doctorflag }}"> @if($displaysetting->doctorflag==1) English @elseif($displaysetting->doctorflag==2) Other Language @elseif ($displaysetting->doctorflag==3) Both @else @endif
                    </option>
                    <option value="1">English</option>
                    <option value="2">Other Language</option>
                    <option value="3">Both</option>
                        </select>
                        
                    </div>
                </div>
            
            <!----------------------->
                               
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit">
                                            {{ trans('messages.update') }}<i class="mdi-action-swap-vert left"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                </div>
            <!------------------------->
            <div class="col s12 m6">
            <form enctype="multipart/form-data" id="displaybg" action="{{ route('update_displaybg') }}" method="post" >
            {{ csrf_field() }}
             <div class="row">
             <div class="input-field col s12">
             <span style="display:block">Update Display Background Image(size=233px*227px)</span>
             <input id="bgimg" type="file" name="bgimg" value="{{ $displaysetting->bgimg }}">
             <button class="btn waves-effect waves-light right" type="submit">
            {{ trans('messages.update') }}<i class="mdi-action-swap-vert left"></i></button>
             <div style="width:100px; margin: auto"> <img style="max-width:100%" src="{{url('public/displaysetting')}}/{{ $displaysetting->bgimg }}" > </div>               
            </div>
            </div>
            
           
            </form>
                </div>

            <div class="col s12 m6">
            <form enctype="multipart/form-data" id="displayvideo" action="{{ route('update_displayvideo') }}" method="post" >
            {{ csrf_field() }}
            <div class="row">
            <div class="input-field col s12">
            <span style="display:block">Update Display Video(size=1.14MB maximum)</span>
            <input id="video" type="file" name="video" value="{{ $displaysetting->video }}">
            <div style="width:100px; height:100px; margin: auto; overflow-y:hidden;"> <iframe style="max-width:100%; border:none;" src="{{url('public/displaysetting')}}/{{ $displaysetting->video }}" > </iframe> </div>               
            </div>
            </div>

            <div class="row">
             <div class="input-field col s12">
            <button class="btn waves-effect waves-light right" type="submit">
            {{ trans('messages.update') }}<i class="mdi-action-swap-vert left"></i>
             </div>
            </div>
             
              </form>
                </div>
            <!------------------------->



                        </div>
                    </div>
                </div>


        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script>
    //--------------------------
    $("#dsetting").validate({
            rules: {
                textup: {
                    required: true
                },
                textdown: {
                    required: true,
                },
               
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

    //--------------------------
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
