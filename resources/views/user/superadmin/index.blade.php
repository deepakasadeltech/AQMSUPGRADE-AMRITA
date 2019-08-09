@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.updatelimitdata'))

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.updatelimitdata') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.mainapp.menu.updatelimitdata') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!--------------------->
    <div class="container">
        <div class="row">
            
        <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                <!-------------------------------->        
                         <div class="col s12 m12">
                 <div class="formblock">   <!----start-form-block------->            
            <form id="limitsetting" action="{{ route('update_limitdata') }}" method="post" >
                            {{ csrf_field() }}

                            <div class="superadminformblock">
                                <ul>
                                <li> <div class="fblock"> 
                                    <span>{{ trans('messages.ndoctor') }}</span>
                                    <span><input id="doctor" type="text" name="doctor" placeholder="{{ trans('messages.name') }}" value="{{ $datalimits->doctor }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.nuser') }}</span>
                                    <span><input id="user" type="text" name="user" placeholder="{{ trans('messages.nuser') }}" value="{{ $datalimits->user }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.ncmo') }}</span>
                                    <span><input id="cmo" type="text" name="cmo" placeholder="{{ trans('messages.ncmo') }}" value="{{ $datalimits->cmo }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.ndisplayctrl') }}</span>
                                    <span><input id="displayctrl" type="text" name="displayctrl" placeholder="{{ trans('messages.ndisplayctrl') }}" value="{{ $datalimits->displayctrl }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.nhelpdesk') }}</span>
                                    <span><input id="helpdesk" type="text" name="helpdesk" placeholder="{{ trans('messages.nhelpdesk') }}" value="{{ $datalimits->helpdesk }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.ndepartment') }}</span>
                                    <span><input id="pdepartment" type="text" name="pdepartment" placeholder="{{ trans('messages.ndepartment') }}" value="{{ $datalimits->pdepartment }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span> {{ trans('messages.nsupdepartment') }}</span>
                                    <span><input id="department" type="text" name="department" placeholder="{{ trans('messages.nsupdepartment') }}" value="{{ $datalimits->department }}"></span>
                                    </div>
                                </li>
                                
                                <li><div class="fblock">
                                    <span>{{ trans('messages.nroom') }}</span>
                                    <span><input id="room" type="text" name="room" placeholder="{{ trans('messages.nroom') }}" value="{{ $datalimits->room }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.nads') }}</span>
                                    <span><input id="ads" type="text" name="ads" placeholder="{{ trans('messages.nads') }}" value="{{ $datalimits->ads }}"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span>{{ trans('messages.ntokenperday') }}</span>
                                    <span><input id="tokenperday" type="text" name="tokenperday" placeholder="{{ trans('messages.ntokenperday') }}" value="{{ $datalimits->tokenperday }}"></span>
                                    </div>
                                </li>
                                </ul>
                            <div class="submitlimitbtn">
                            <button class="btn waves-effect waves-light" type="submit">
                                            {{ trans('messages.update') }}<i class="mdi-action-swap-vert left"></i>
                                        </button>
                            </div>

                            </div>



                </div>   <!----End-form-block-------> 
            </form>


                         </div>
                <!-------------------------------->          
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
