@extends('layouts.app')

@section('title', trans('messages.settings'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.settings') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.settings') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @can('access', $settings)
            <div class="row">
                <div class="col s12 m6">
                    <div class="card">
                        <div id="userId" class="card-content">
                            <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.map_doctor') }}</span>
                            <div class="divider" style="margin:10px 0 10px 0"></div>
                            <form id="mapdeptfrm" action="{{ route('post_map_dept')}}" method="post">
                                {{ csrf_field() }}
								
								<div class="row">
                                    <div class="input-field col s12">
                                        <label for="user" class="active">{{ trans('messages.call.doctor') }}</label>
                                <select id="user" class="browser-default" name="user" data-error=".user">
                                <option value="">{{ trans('messages.select') }} {{ trans('messages.call.doctor') }}</option>
                               @foreach($users as $cuser)
                               @if($cuser->role=='D')
                                 <option value="{{ $cuser->id }}"{!! $cuser->id==$user_details->id ?' selected':'' !!}>{{ $cuser->name }} ({{$cuser->role_text}})</option>
                                @endif
                                @endforeach
                                        </select>
                                        <div class="user">
                                            @if($errors->has('user'))<div class="error">{{ $errors->first('user') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
								
                                <div class="row">
                                <div class="input-field col s12">
                                    <label for="pid" class="active">{{ trans('messages.mainapp.menu.parent_department') }}</label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.parent_department') }}</option>
                                        @foreach($pdepartments as $pdepartment)
                                            @if($pdepartment->id == $user_details->pid)
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
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="department" class="active">{{ trans('messages.mainapp.menu.department') }}</label>
                                    <select id="department" class="browser-default" name="department" data-error=".department">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.department') }}</option>
                                        @foreach($departments as $department)
                                        @if($department->id == $user_details->department_id)
                                                <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                            @else
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="department">
                                        @if($errors->has('department'))<div class="error">{{ $errors->first('department') }}</div>@endif
                                    </div>
                                </div>
                            </div>

                             <?php
                            $rooms_id = $user_details->counter_id; 
                            $array_rooms_id =  explode(', ', $rooms_id); $rmid = '';
                            foreach($array_rooms_id as $rroom){
                                $rmid .= $rroom; 
                            }
                            ?>

                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="counter" class="active">{{ trans('messages.mainapp.menu.counter') }}</label>
                                    <select multiple id="counter" class="browser-default" name="counter[]" data-error=".counter">
                                        <option value="" disabled >{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.counter') }}</option>
                                        @foreach($counters as $counter)
                                        @if($counter->id == $user_details->counter_id)
                                                <option value="{{ $counter->id }}" selected>{{ $counter->name }}</option>
                                            @else
                                                <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="counter">
                                        @if($errors->has('counter'))<div class="error">{{ $errors->first('counter') }}</div>@endif
                                    </div>
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
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('script')
 <script>
	
        $("#account").validate({
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
                    minlength: 6
                },
                password_confirmation: {
                    minlength: 6,
                    equalTo: "#password"
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
        @can('access', $settings)
            $("#company").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        email: true
                    }
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
            $("#overmissed").validate({
                rules: {
                    over_time: {
                        required: true,
                        digits: true
                    },
                    missed_time: {
                        required: true,
                        digits: true
                    }
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
            $("#languagefrm").validate({
                rules: {
                    language: {
                        required: true,
                        digits: true
                    }
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

            $('body').on('change', '#user', function(){
			var options = "<option value=''>Select Department </option>";
			if($(this).val() == ''){
				$('#pid').html(options);
			}
			var data = 'user='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_cuserdept') }}",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#pid').html(options);
										
                }
            });
		});
			
			$('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Parent Department</option>";
			if($(this).val() == ''){
				$('#department').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_spdept') }}",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#department').html(options);
										
                }
            });
		});


        $('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Counter </option>";
			if($(this).val() == ''){
				$('#counter').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_cgdept') }}",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#counter').html(options);
										
                }
            });
		});
		
        @endcan
		
    </script>
@endsection
