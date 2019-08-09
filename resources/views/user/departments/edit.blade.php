@extends('layouts.app')

@section('title', trans('messages.edit').' '.trans('messages.mainapp.menu.department'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.add') }} {{ trans('messages.mainapp.menu.department') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li><a href="{{ route('departments.index') }}">{{ trans('messages.mainapp.menu.department') }}</a></li>
                        <li class="active">{{ trans('messages.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3" style="padding-top:10px;padding-bottom:10px">
                <a class="btn-floating waves-effect waves-light orange tooltipped right" href="{{ route('departments.index') }}" data-position="top" data-tooltip="{{ trans('messages.cancel') }}"><i class="mdi-navigation-arrow-back"></i></a>
                <form id="edit" action="{{ route('departments.update', ['departments' => $department->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
					
					<div class="row">
                        <div class="input-field col s12">
                            <label for="name" class="active">{{ trans('messages.mainapp.menu.parent_department') }}</label>
                            <select id="pid" class="browser-default" name="pid" data-error=".pid">
							<option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.parent_department') }}</option>
							@foreach($pdepartment as $pidepartment)
								<option value="{{ $pidepartment->id }}"{!! $pidepartment->id==$department->pid?' selected':'' !!}>{{ $pidepartment->name }}</option>
							@endforeach
							</select>
                            <div class="name">
                                @if($errors->has('pid'))<div class="error">{{ $errors->first('pid') }}</div>@endif
                            </div>
                        </div>
                    </div>
					
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">{{ trans('messages.name') }}</label>
                            <input id="name" type="text" name="name" placeholder="{{ trans('messages.mainapp.menu.department') }} {{ trans('messages.name') }}" value="{{ $department->name }}" data-error=".name">
                            <div class="name">
                                @if($errors->has('name'))<div class="error">{{ $errors->first('name') }}</div>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="olangname">{{ trans('messages.mainapp.menu.subdept_otherlanguage') }}</label>
                            <input id="olangname" type="text" name="olangname" placeholder="{{ trans('messages.mainapp.menu.subdept_otherlanguage') }}" value="{{ $department->olangname }}" data-error=".olangname">
                            <div class="olangname">
                                @if($errors->has('olangname'))<div class="error">{{ $errors->first('olangname') }}</div>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="regcode">{{ trans('messages.registrationcode') }}</label>
                            <input id="regcode" type="text" name="regcode" placeholder="Registration Code" value="{{ $department->regcode }}" data-error=".regcode">
                            <div class="regcode">
                                @if($errors->has('regcode'))<div class="error">{{ $errors->first('regcode') }}</div>@endif
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="input-field col s12">
                            <label for="letter">{{ trans('messages.department.letter') }}</label>
                            <input id="letter" type="text" name="letter" placeholder="{{ trans('messages.department.letter') }}" value="{{ $department->letter }}" data-error=".letter">
                            <div class="letter">
                                @if($errors->has('letter'))<div class="error">{{ $errors->first('letter') }}</div>@endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="start">{{ trans('messages.department.start') }}</label>
                            <input id="start" type="text" name="start" placeholder="{{ trans('messages.department.start') }}" value="{{ $department->start }}" data-error=".start">
                            <div class="start">
                                @if($errors->has('start'))<div class="error">{{ $errors->first('start') }}</div>@endif
                            </div>
                        </div>
                    </div>
					
					<div class="row">
                        <div class="input-field col s12">
                            <label for="name" class="active">{{ trans('messages.mainapp.menu.uhid_required') }}</label>
                            <select id="is_uhid_required" class="browser-default" name="is_uhid_required" data-error=".is_uhid_required">
							<option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.uhid_required') }}</option>
							@foreach($uhids as $ukey=>$uvalue)
								<option value="{{ $ukey }}"{!! $ukey==$department->is_uhid_required?' selected':'' !!}>{{ $uvalue }}</option>
							@endforeach
							</select>
                            <div class="name">
                                @if($errors->has('is_uhid_required'))<div class="error">{{ $errors->first('is_uhid_required') }}</div>@endif
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

<script type="text/javascript" src="http://www.google.com/jsapi"></script>

<script type="text/javascript">
google.load("elements", "1", {packages: "transliteration"});
</script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
function OnLoad() {                
    var options = {
        sourceLanguage:
        google.elements.transliteration.LanguageCode.ENGLISH,
        destinationLanguage:
        [google.elements.transliteration.LanguageCode.HINDI],
        shortcutKey: 'ctrl+g',
        transliterationEnabled: true
    };

    var control = new google.elements.transliteration.TransliterationControl(options);
    control.makeTransliteratable(["olangname"]);
    var keyVal = 32; // Space key
    $("#name").on('keydown', function(event) {
        if(event.keyCode === 32) {
            var engText = $("#name").val() + " ";
            var engTextArray = engText.split(" ");
            $("#olangname").val($("#olangname").val() + engTextArray[engTextArray.length-2]);

            document.getElementById("olangname").focus();
            $("#olangname").trigger ( {
                type: 'keypress', keyCode: keyVal, which: keyVal, charCode: keyVal
            } );
        }
    });

   
	
	
} //end onLoad function

google.setOnLoadCallback(OnLoad);
</script> 

<!-------------------------------------->

    <script>
        $("#edit").validate({
            rules: {
                name: {
                    required: true
                },
                regcode: {
                    required: true
                },
                start: {
                    required: true,
                    digits: true
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
    </script>
@endsection
