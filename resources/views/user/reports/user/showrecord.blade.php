@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.reports.user_report'))

@section('css')
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('assets/js/plugins/data-tables/css/buttons.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    
@endsection

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">Doctor Report</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li>{{ trans('messages.mainapp.menu.reports.reports') }}</li>
                        <li class="active">Doctor Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <div class="row">
                       
                    <div class="input-field col s12 m4">
                        <button class="btn waves-effect waves-light left light-blue">{{ trans('messages.rot') }}<span style=" color: #fff;
    font-size: 14px; display: inline-block; border: 0px solid #f00; background:#c51162; line-height: normal; border-radius: 100%; padding: 7px; margin:0 3px;">{{count($doctorReportwithDateRange)}}</span> {{ trans('messages.doctrr') }}</button>
                        </div>

                        <div class="input-field col s12 m3">
                            <label for="asdate">{{ trans('messages.starting') }} {{ trans('messages.date') }}</label>
                            <input id="asdate" type="text" placeholder="dd-mm-yyyy" value="{{ $asdate }}">
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="aedate">{{ trans('messages.ending') }} {{ trans('messages.date') }}</label>
                            <input id="aedate" type="text" placeholder="dd-mm-yyyy" value="{{ $aedate }}">
                        </div>
                        <div class="input-field col s12 m1">
                            <button id="gobtns" class="btn waves-effect waves-light right disabled" onclick="gobtns()">{{ trans('messages.go') }}</button>
                        </div>
                        
                    </div>
                </div>
                <!-----------Start-All-Key-deatils------------------>

                
                <!--------End-All-Key-deatils---------------------> 
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <span style="line-height:0;font-size:22px;font-weight:300">{{ trans('messages.report') }}</span>
                    <div class="divider" style="margin:15px 0 10px 0"></div>
                    <table id="report-table" class="display tablemodify" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('messages.doctorname') }}</th>
                                <th>{{ trans('messages.departments') }}</th>
                                <th>{{ trans('messages.roomnumber') }}</th>
                                <th>{{ trans('messages.dr_act') }}</th>
                                <th>{{ trans('messages.dept_awt') }}</th>
                                <th>{{ trans('messages.hosp_act') }}</th>
                                <th>{{ trans('messages.tm') }}</th>
                                <th>{{ trans('messages.tppd') }}</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                            @foreach($doctorReportwithDateRange as $doctordetail)
                                <tr <?php $i++ ?>>
                                    <td> {{$i}}   </td>
                                    <td>{{$doctordetail->name}}</td>
                                    <td>{{$doctordetail->department->name}}</td>
                                    <td>
                                    <?php if(!empty($doctordetail->counter_id))
                                    { $rooms_id = $doctordetail->counter_id;
                                    $array_rooms_id =  explode(', ', $rooms_id); 
                                    foreach($array_rooms_id as $room_id){
                                    foreach($counters as $rooms){if($rooms->id == $room_id ){echo $rooms->name.'<br>';}
                                    } 
                                    }
                                    }else{
                                    echo 'Not Allotted';   
                                    }
                                    ?>

                                   
                                    
                                    </td>
                                    <td>
                                        <?php $totalconsutingtime='0'; $avgconsutingtime='0'; $tconsutingpatient='0'; $total_end_time=''; $total_start_time=''; $ttpatient=''; ?>
                                        @foreach($getAvgCTimeEachDoctorWithDateRange as $avgctime)
                                        @if($doctordetail->id == $avgctime->user_id )
                                         
                                        @php( $total_end_time += strtotime($avgctime->doctor_work_end_date))
                                        @php( $total_start_time += strtotime($avgctime->doctor_work_start_date))
                                        @php( $tconsutingpatient += count($avgctime->number))
                                        @endif
                                        @endforeach
                                        <?php
                                        if($tconsutingpatient > 0){
                                            $ttpatient = $tconsutingpatient; 
                                        }else{
                                            $ttpatient = 1;
                                        }
                                        $totalconsutingtime = $total_end_time-$total_start_time;

                                       $avgconsutingtime = ($totalconsutingtime)/$ttpatient;
                                       if(gmdate("H:i:s", $avgconsutingtime) > gmdate("H:i:s", 0)){
                                     echo '<span style="color:#00FF00">'.gmdate("H:i:s", $avgconsutingtime).'<sub style="font-size:12px;">&nbsp; Hrs / P</sub>'.'</span>';
                                        }else{
                                       echo '<span style="color:#f00">'.gmdate("H:i:s", $avgconsutingtime).'<sub style="font-size:12px;">&nbsp; Hrs / P</sub>'.'</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                <?php $waiting_end_time='0'; $waiting_start_time='0'; $waitingpatient='0'; $tmpatient='0'; $twaiting_time='0'; $avgwaitingtime='0'; ?>        
                                 @foreach($avgWaitingTimeofTokenForEachDepartment as $avgwtime)
                                 @if($doctordetail->department_id == $avgwtime->department_id )
                                 @php( $waiting_end_time += strtotime($avgwtime->updated_at))
                                 @php( $waiting_start_time += strtotime($avgwtime->created_at))
                                 @php( $waitingpatient += count($avgwtime->number))
                                 @endif
                                 @endforeach

                                 <?php
                                        if($waitingpatient > 0){
                                            $tmpatient = $waitingpatient; 
                                        }else{
                                            $tmpatient = 1;
                                        }
                                        $twaiting_time = $waiting_end_time-$waiting_start_time;

                                       $avgwaitingtime = ($twaiting_time)/$tmpatient;
                                       if(gmdate("H:i:s", $avgwaitingtime) > gmdate("H:i:s", 0)){
                                     echo '<span style="color:#00FF00">'.gmdate("H:i:s", $avgwaitingtime).'<sub style="font-size:12px;">&nbsp; Hrs / P</sub>'.'</span>';
                                        }else{
                                       echo '<span style="color:#f00">'.gmdate("H:i:s", $avgwaitingtime).'<sub style="font-size:12px;">&nbsp; Hrs / P</sub>'.'</span>';
                                        }
                                        ?>
                                
                                    </td>

                                    <td>
                                    <?php $hwaiting_end_time='0'; $hwaiting_start_time='0'; $hwaitingpatient='0'; $htmpatient='0'; $htwaiting_time='0'; $havgwaitingtime='0'; ?>        
                                 @foreach($avgWaitingTimeofTokenForEachDepartment as $avgwtime)
                                 @php( $hwaiting_end_time += strtotime($avgwtime->updated_at))
                                 @php( $hwaiting_start_time += strtotime($avgwtime->created_at))
                                 @php( $hwaitingpatient += count($avgwtime->number))
                                 @endforeach 
                                
                                  <?php
                                        if($hwaitingpatient > 0){
                                            $htmpatient = $hwaitingpatient; 
                                        }else{
                                            $htmpatient = 1;
                                        }
                                        $htwaiting_time = $hwaiting_end_time-$hwaiting_start_time;

                                       $havgwaitingtime = ($htwaiting_time)/$htmpatient;
                                       if(gmdate("H:i:s", $havgwaitingtime) > gmdate("H:i:s", 0)){
                                     echo '<span style="color:#00FF00">'.gmdate("H:i:s", $havgwaitingtime).'<sub style="font-size:12px;">&nbsp; Hrs / P</sub>'.'</span>';
                                        }else{
                                       echo '<span style="color:#f00">'.gmdate("H:i:s", $havgwaitingtime).'<sub style="font-size:12px;">&nbsp; Hrs / P</sub>'.'</span>';
                                        }
                                        ?>

                                    </td>

                                    <td>
                                   <?php $tmissedbydoctor='0'; ?>     
                                   @foreach($gettokenMissedDoctorWithDateRange as $doctortmissed)
                                   @if($doctordetail->id == $doctortmissed->user_id )
                                   @php( $tmissedbydoctor += count($doctortmissed->number))
                                   @endif
                                   @endforeach
                                   @if($tmissedbydoctor > 0)
                                   <span style="color:#f00">{{$tmissedbydoctor}}</span>
                                   @else  <span style="color:#00FF00"> 0 </span>      @endif   
                                   </td>

                                    <td>
                                    <?php $ttconsultantofdoctor='0'; $total_no_of_days='0'; $ttday='0'; ?>
                                        @foreach($getAvgCTimeEachDoctorWithDateRange as $avgctime)
                                        @if($doctordetail->id == $avgctime->user_id )
                                        @php( $ttconsultantofdoctor += count($avgctime->number))
                                        @endif
                                        @endforeach
                                       <?php  $total_no_of_days = round(strtotime($aedate)-strtotime($asdate))/86400;
                                       $ttday = $total_no_of_days+'1'; 
                                       ?>
                                        @if($ttconsultantofdoctor > 0)
                                        <span style="color:#00FF00"> {{$ttconsultantofdoctor}} <sub style="font-size:12px;">&nbsp;Patients</sub> / {{$ttday}} <sub style="font-size:12px;">&nbsp; Days </sub> </span>
                                        @else
                                        <span style="color:#f00"> 0 <sub style="font-size:12px;">&nbsp; Patients </sub> / 0 <sub style="font-size:12px;">&nbsp; Days</sub> </span>
                                        @endif

                                    </td>
                                    
                             </tr>
                          @endforeach   
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/tableplg/buttons.html5.min.js') }}"></script>
    <script>

        //----------------------------------------------------

 var from_$input = $('#asdate').pickadate({
                selectMonths: true,
                selectYears: 15,
                format: 'dd-mm-yyyy',
                clear: false,
                onSet: function(ele) {
                    if(ele.select) {
                        this.close();
                    }
                },
                closeOnSelect: true,
                onClose: function() {
                    document.activeElement.blur();
                }}),
    from_picker = from_$input.pickadate('picker')

var to_$input = $('#aedate').pickadate({
                selectMonths: true,
                selectYears: 15,
                format: 'dd-mm-yyyy',
                clear: false,
                onSet: function(ele) {
                    if(ele.select) {
                        this.close();
                    }
                },
                closeOnSelect: true,
                onClose: function() {
                    document.activeElement.blur();
                }}),
    to_picker = to_$input.pickadate('picker')


// Check if there’s a “from” or “to” date to start with.
if ( from_picker.get('value') ) {
  to_picker.set('min', from_picker.get('select'))
}
if ( to_picker.get('value') ) {
  from_picker.set('max', to_picker.get('select'))
}

// When something is selected, update the “from” and “to” limits.
from_picker.on('set', function(event) {
  if ( event.select ) {
    to_picker.set('min', from_picker.get('select'))    
  }
  else if ( 'clear' in event ) {
    to_picker.set('min', false)
  }
})
to_picker.on('set', function(event) {
  if ( event.select ) {
    from_picker.set('max', to_picker.get('select'))
  }
  else if ( 'clear' in event ) {
    from_picker.set('max', false)
  }
})


//--------------------------------------------------        
        $(function() {
            $('#report-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search",
                    },
                    dom: 'Bfrtip',
                   buttons: [
             { extend: 'copy', title: ''+'Data Record  :'+' From '+$('#asdate').val()+' -To- '+$('#aedate').val()+'',},
             { extend: 'csv', title: ''+'Data Record  :'+' From '+$('#asdate').val()+' -To- '+$('#aedate').val()+'',},
             { extend: 'excel', title: ''+'Data Record  :'+' From '+$('#asdate').val()+' -To- '+$('#aedate').val()+'',},
             { extend: 'pdf', title: ''+'Data Record :'+' From '+$('#asdate').val()+' -To- '+$('#aedate').val()+'', },
             { extend: 'print', title: '<span style="font-size:15px; font-weight:700; text-transform:uppercase; display:block; text-align:center; padding:15px 0 0 0">'+'Data Record :'+' From '+$('#asdate').val()+' -To- '+$('#aedate').val()+'</span>', },
             ] 
                  
            });
        });

        $('#asdate, #aedate').change(function(event){
            var asdate = $('#asdate').val();
            var aedate = $('#aedate').val();

            action = '{{ url('reports/user/') }}/'+asdate+'/'+aedate;

            if(asdate=='' || aedate=='') {
                $('#gobtns').addClass('disabled');
            } else {
                $('#gobtns').removeClass('disabled');
            }
        });

        function gobtns() {
            if (!$('#gobtns').hasClass('disabled')) {
                $('body').removeClass('loaded');
                window.location = action;
            }
        }
    </script>
@endsection
