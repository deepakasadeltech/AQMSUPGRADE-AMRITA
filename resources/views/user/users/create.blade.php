@extends('layouts.app')

@section('title', trans('messages.add').' '.trans('messages.mainapp.menu.users'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.add') }} {{ trans('messages.mainapp.menu.users') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li><a href="{{ route('users.index') }}">{{ trans('messages.mainapp.menu.users') }}</a></li>
                        <li class="active">{{ trans('messages.add') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3" style="padding-top:10px;padding-bottom:10px">
                <a class="btn-floating waves-effect waves-light orange tooltipped right" href="{{ route('users.index') }}" data-position="top" data-tooltip="{{ trans('messages.cancel') }}"><i class="mdi-navigation-arrow-back"></i></a>
                <form enctype="multipart/form-data" id="add" action="{{ route('users.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">{{ trans('messages.name') }}</label>
                            <input id="name" type="text" name="name" placeholder="{{ trans('messages.name') }}" value="{{ old('name') }}" data-error=".name">
                            <div class="name">
                                @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
            <div class="input-field col s12" style="margin-bottom:30px; padding-bottom:10px; border-bottom: 1px solid #9e9e9e;">
            <span style="display:block;font-size:.8rem;color:#9e9e9e; margin-bottom:10px;"> Photo (size:200px*230px)</span>
            <input id="photo" type="file" name="photo" value="">             
            </div>
            </div>

            <div class="row">
                        <div class="input-field col s12">
                            <label for="profile">Profile Name</label>
                            <input id="profile" type="text" name="profile" placeholder="Profile Name" value="{{ old('profile') }}" data-error=".profile">
                            <div class="profile">
                                @if($errors->has('profile'))<div class="error">{{ $errors->first('profile') }}</div>@endif
                            </div>
                        </div>
                    </div>

                   
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="username">{{ trans('messages.users.username') }}</label>
                            <input id="username" type="text" name="username" placeholder="{{ trans('messages.users.username') }}" value="{{ old('username') }}" data-error=".username">
                            <div class="username">
                                @if($errors->has('username'))<div class="error">{{ $errors->first('username') }}</div>@endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="email">{{ trans('messages.users.email') }}</label>
                            <input id="email" type="text" name="email" placeholder="{{ trans('messages.users.email') }}" value="{{ old('email') }}" data-error=".email">
                            <div class="email">
                                @if($errors->has('email'))<div id="name-error" class="error">{{ $errors->first('email') }}</div>@endif
                            </div>
                        </div>
                    </div>

                    
                    
					<div class="row">
                        <div class="input-field col s12">
                            <label for="name" class="active">{{ trans('messages.users.role') }}</label>
                            <select id="role" class="browser-default" name="role" data-error=".role">
								<option value="D">Doctor</option>
								<option value="S">Staff</option>
                                <option value="H">Help Desk</option>
                                <option value="C">CMO</option>
                                <option value="I">Display Controller</option>
							</select>
                            <div class="name">
                                @if($errors->has('role'))<div class="error">{{ $errors->first('role') }}</div>@endif
                            </div>
                        </div>
                    </div>
         <!-------------------------------------->

                        <div class="row" id="pid_section">
                                <div class="input-field col s12">
                                    <label for="pid" class="active">{{ trans('messages.mainapp.menu.parent_department') }}</label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.parent_department') }}</option>
                                        @foreach($pdepartments as $pdepartment)
                                            @if(session()->has('pid') && ($pdepartment->id==session()->get('pid')))
                                                <option value="{{ $pdepartment->id }}" selected>{{ $pdepartment->name }}</option>
                                            @else
                                                <option value="{{ $pdepartment->id }}">{{ $pdepartment->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="pid">
                                        @if($errors->has('pid'))<div class="error">{{ $errors->first('pid') }}</div>@endif
                                    </div>
                                </div>
                            </div>
							
                            <div class="row" id="depid_section">
                                <div class="input-field col s12">
                                    <label for="department_id" class="active">{{ trans('messages.mainapp.menu.department') }}</label>
                                    <select id="department_id" class="browser-default" name="department_id" data-error=".department_id">
                                       
                                    </select>
                                    <div class="department_id">
                                        @if($errors->has('department_id'))<div class="error">{{ $errors->first('department_id') }}</div>@endif
                                    </div>
                                </div>
                            </div>

         <!--------------ads-with-doctor------------>  
         <div class="row" id="ads_section">
                                <div class="input-field col s12">
                                    <label for="ads_id" class="active">{{ trans('messages.mainapp.menu.ads') }}</label>
                                    <select id="ads_id" class="browser-default" name="ads_id" data-error=".ads_id">
                                <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.ads') }}</option>
                                        @foreach($ads as $ad)
                                 <option value="{{ $ad->id }}">{{ $ad->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="ads_id">
                                        @if($errors->has('ads_id'))<div class="error">{{ $errors->first('ads_id') }}</div>@endif
                                    </div>
                                </div>
                            </div>
         <!--------------------------------------->
					
					
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password">{{ trans('messages.users.password') }}</label>
                            <input id="password" type="password" name="password" placeholder="{{ trans('messages.users.password') }}" value="{{ old('password') }}" data-error=".password">
                            <div class="password">
                                @if($errors->has('password'))<div id="name-error" class="error">{{ $errors->first('password') }}</div>@endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password_confirmation">{{ trans('messages.users.confirm') }} {{ trans('messages.users.password') }}</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="{{ trans('messages.users.confirm') }} {{ trans('messages.users.password') }}" value="{{ old('password_confirmation') }}" data-error=".password_confirmation">
                            <div class="password_confirmation">
                                @if($errors->has('password_confirmation'))<div id="name-error" class="error">{{ $errors->first('password_confirmation') }}</div>@endif
                            </div>
                        </div>
                    </div>


                    <div class="row">
                                <div class="input-field col s12">
                                    <label for="user_status" class="active">{{ trans('messages.mainapp.menu.counter') }}</label>
                                    <select id="user_status" class="browser-default" name="user_status" data-error=".user_status">
                                    <option selected value="1">Active</option>
                                     <option value="2">InActive</option>
                                    </select>
                                    <div class="user_status">
                                        @if($errors->has('user_status'))<div class="error">{{ $errors->first('user_status') }}</div>@endif
                                    </div>
                                </div>
                            </div>
                   

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn waves-effect waves-light right" type="submit">
                                {{ trans('messages.save') }}<i class="mdi-content-save left"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#add").validate({
            rules: {
                name: {
                    required: true
                },
                username: {
                    required: true,
                    minlength: 6
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },

                pid: {
                    required: true,
                },

                department_id: {
                    required: true,
                },

                user_status: {
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

    //-------------------------------------------------
    $('body').on('change', '#pid', function(){
			var options = "<option selected value=''>Select Department</option>";
			if($(this).val() == ''){
				$('#department_id').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_updept') }}",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#department_id').html(options);
										
                }
            });
		});       
        $('body').on('change', '#role', function(){
            if($(this).val() != 'D'){
                $('#pid_section').css('display', 'none');
                $('#depid_section').css('display', 'none');
                $('#ads_section').css('display', 'none');
            }else{
                $('#pid_section').css('display', '');
                $('#depid_section').css('display', '');
                $('#ads_section').css('display', '');
            }
        });
        

    //-------------------------------------------------
    </script>
@endsection
