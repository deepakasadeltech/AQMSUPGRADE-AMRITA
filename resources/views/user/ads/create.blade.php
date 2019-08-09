@extends('layouts.app')

@section('title', trans('messages.add').' '.trans('messages.mainapp.menu.ads'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.add') }} {{ trans('messages.mainapp.menu.ads') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li><a href="{{ route('counters.index') }}">{{ trans('messages.mainapp.menu.ads') }}</a></li>
                        <li class="active">{{ trans('messages.add') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3" style="padding-top:10px;padding-bottom:10px">
                <a class="btn-floating waves-effect waves-light orange tooltipped right" href="{{ route('counters.index') }}" data-position="top" data-tooltip="{{ trans('messages.cancel') }}"><i class="mdi-navigation-arrow-back"></i></a>
                <form enctype="multipart/form-data"  id="add" action="{{ route('ads.store') }}" method="post">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">{{ trans('messages.adname') }}</label>
                            <input id="name" type="text" name="name" placeholder="{{ trans('messages.mainapp.menu.ads') }} {{ trans('messages.name') }}" value="{{ old('name') }}" data-error=".name">
                            <div class="name">
                                @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
            <div class="input-field col s12" style="margin-bottom:30px; padding-bottom:10px; border-bottom: 1px solid #9e9e9e;">
            <span style="display:block;font-size:.8rem;color:#9e9e9e; margin-bottom:10px;"> {{ trans('messages.mainapp.menu.ads') }} {{ trans('messages.adimg') }} (Image size: 1500px * 1300px) @if ($errors->has('adimg')) <strong style="color:red">Please check image dimension (1500px * 1300px)</strong> @endif</span>
            <input id="adimg" type="file" name="adimg" value="" required="required" >  
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
                adimg: {
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

 //-------------------------------

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
