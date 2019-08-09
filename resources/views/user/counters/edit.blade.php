@extends('layouts.app')

@section('title', trans('messages.edit').' '.trans('messages.mainapp.menu.counter'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.add') }} {{ trans('messages.mainapp.menu.counter') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li><a href="{{ route('counters.index') }}">{{ trans('messages.mainapp.menu.counter') }}</a></li>
                        <li class="active">{{ trans('messages.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3" style="padding-top:10px;padding-bottom:10px">
                <a class="btn-floating waves-effect waves-light orange tooltipped right" href="{{ route('counters.index') }}" data-position="top" data-tooltip="{{ trans('messages.cancel') }}"><i class="mdi-navigation-arrow-back"></i></a>
                <form id="edit" action="{{ route('counters.update', ['counters' => $counter->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}


                    <div class="row">
                                <div class="input-field col s12">
                                    <label for="pid" class="active">{{ trans('messages.mainapp.menu.parent_department') }}</label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        
                                        @foreach($pdepartments as $pdepartment)
                                          
                                           <option value="{{ $pdepartment->id }}"{!! $pdepartment->id == $counter->pid ?' selected':'' !!}>{{ $pdepartment->name }}</option>
                                          
                                          
                                        
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
                                    <select id="department_id" class="browser-default" name="department_id" data-error=".department_id">
                                        
                                       
                                        @foreach($departments as $department)
                                 <option value="{{ $department->id }}"{!! $department->id == $counter->department_id ?' selected':'' !!}>{{ $department->name }}</option>
                                            
                                        @endforeach
                                    </select>
                                    <div class="department_id">
                                        @if($errors->has('department_id'))<div class="error">{{ $errors->first('department_id') }}</div>@endif
                                    </div>
                                </div>
                            </div>


                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">{{ trans('messages.users.room_number') }}</label>
                            <input id="name" type="text" name="name" placeholder="{{ trans('messages.users.room_number') }}" value="{{ $counter->name }}" data-error=".name">
                            <div class="name">
                                @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="display_sequence">{{ trans('messages.users.display_sequence') }}</label>
                            <input id="display_sequence" type="text" name="display_sequence" placeholder="{{ trans('messages.users.display_sequence') }}" value="{{ $counter->display_sequence }}" data-error=".display_sequence">
                            <div class="display_sequence">
                                @if($errors->has('display_sequence'))<div class="error">{{ $errors->first('display_sequence') }}</div>@endif
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
@endsection

@section('script')
    <script>
        $("#edit").validate({
            rules: {
                name: {
                    required: true
                },
                display_sequence: {
                    required: true
                },
                pid: {
                    required: true
                },
                department_id: {
                    required: true
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

        $('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Department</option>";
			if($(this).val() == ''){
				$('#department_id').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_mpdept') }}",
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
    </script>
@endsection
