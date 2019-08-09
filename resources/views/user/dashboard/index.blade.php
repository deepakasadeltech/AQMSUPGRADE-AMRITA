@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.dashboard'))

@section('css')
    <link href="{{ asset('assets/css/materialize-colorpicker.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection


@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">

                  <!----start-sms-on-mobile-------->
         
         <?php
        if(session()->has('dispensary')){    //department wise activedted
          require_once(base_path('assets/Sms/textlocal.class.php'));
          require_once(base_path('assets/Sms/credential.php'));

         if(session()->get('patient_mobile') !== NULL) {
         //$token = 'Token No. : '.session()->get('number');
         $token = session()->get('number');
         $department = 'Department : '.session()->get('dispensary'); 
         $textlocal = new Textlocal(false, false, API_KEY);
         $numbers = array(session()->get('patient_mobile'));
         $sender = 'ASADEL';
         $company = $setting->name;
         $OTP = mt_rand(10000, 99999);
         if(session()->has('doctor_dispensory')) {
            $room = 'Room No. : '.session()->get('room_number'); //doctor wise activated
            $doctor = 'Doctor Name : '.session()->get('doctor_dispensory'); //doctor wise activated
            //$message = $company."%n %n %n"."TOKEN DETAILS :-"."%n %n".$token."%n".$room."%n".$doctor;
            //$message = $company."%n %n %n".$token."%n";
            //$message = "Your Pharmacy Token"."%n %n".$token."%n %n"."Please proceed to pharmacy to collect your medicine";
            //$message = "Your Pharmacy"."%n".$token."%n"."Please proceed to pharmacy to collect your medicine";
            $message = "Your Pharmacy Token no. : "."%n".$token."%n"."Please proceed to pharmacy to collect your medicine";


            
         }else{
            $message = "Your Pharmacy Token no. : "."%n".$token."%n"."Please proceed to pharmacy to collect your medicine";
            //$message = $company."%n %n %n"."TOKEN DETAILS :-"."%n %n".$token."%n".$department;   //department wise activedted
             }
            
        try {
            $result = $textlocal->sendSms($numbers, $message, $sender);
            //setcookie('otp', $otp);
            //echo "OTP successfully send..";
        } catch (Exception $e) {
            //die('SMS API Error: ' . $e->getMessage());
        }
    }


          } 
           ?>
          
    <!----End-sms-on-mobile--------> 



        <!--------------------------------> 
        <div class="row">
            <div class="col s12 m12 l12">
            <div class="popupmain">
            @if(session()->has('department_name')) 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
            <ul>
        <li>{{trans('messages.users.token_number')}} : {{ session()->get('number') }}  ({{ session()->get('registration_no') }}) 
        &nbsp;&nbsp;&nbsp;Referred To</li><li>{{ session()->get('department_name') }}</li> 
           </ul> 
            </div>
            <div>
            @endif
            @if(session()->has('user_name')) 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
                <ul>
        <li>{{trans('messages.users.token_number')}} : {{ session()->get('number') }}  ({{ session()->get('registration_no') }}) 
        &nbsp;&nbsp;&nbsp;Referred To</li><li>{{ session()->get('user_name') }}</li> <li>Room No. : {{ session()->get('room_number') }}</li>
           </ul> 
            </div>
            <div>
            @endif
            @if(session()->has('reviewcall')) 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
                <ul>
        <li style="color:#000; font-size:13px; font-weight:900;">Review Details : </li>        
        <li>Review ID : {{ session()->get('reviewcall') }} </li>
        @if(session()->get('patient_name') != '')<li>Patient Name : {{ session()->get('patient_name') }} </li>@endif
        <li>{{trans('messages.users.token_number')}} : {{ session()->get('number') }} </li>
           </ul> 
            </div>
            <div>
            @endif

            @if(session()->has('dispensary')) 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
            <ul>
        <li>Your Pharmacy {{trans('messages.users.token_number')}} : {{ session()->get('number') }}  ({{ session()->get('registration_no') }}) Please proceed to pharmacy to collect your medicine</li> 
           </ul> 
            </div>
            <div>
            @endif

            </div>
            </div> </div>
        <!--------------------------------> 

            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.dashboard') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li class="active">{{ trans('messages.mainapp.menu.dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="card-stats">
            @can('access', \App\Models\User::class)
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.today_queue') }}</p>
                                <h4 class="card-stats-number">
                                <?php $today_total_patients_in_queue = '0'; $today_total_patients_called = '0'; $today_total_patients_in_waiting = '0'; $today_total_patients_to_doctor = '0' ?>
                               @foreach($today_queue as $quedetail)

                                @php( $today_total_patients_in_queue += count($quedetail->number) )

                                @if($quedetail->called==0)
                                @php( $today_total_patients_in_waiting += count($quedetail->number) )
                                @endif
                                
                                @if($quedetail->called==1)
                                @php( $today_total_patients_called += count($quedetail->number) )
                                @endif  
                                
                               @endforeach

                            
                              
                              
                                <ul class="ttissuedetails">
                               <li>Total : <span>{{$today_total_patients_in_queue}}</span></li>
                               <li>Waiting : <span>{{$today_total_patients_in_waiting}}</span></li>
                               <li>Missed : <span>{{$today_total_patients_called-count($getTodayAvgConsultingTime)}}</span></li>
                              
                               
                             </ul> 

                                </h4>
                                </p>
                            </div>
                            <div class="card-action light-blue darken-4">
                                <div class="center-align">
                                    <a href="{{ route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')]) }}" style="text-transform:none;color:#fff">{{ trans('messages.more_info') }} <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content green lighten-1 white-text">
                    <p class="card-stats-title truncate"><i class="mdi-communication-call-missed"></i> {{ trans('messages.avgtime') }}</p>
                                <h4 class="card-stats-number">

                                <?php $tavg_start_w_time = '0'; $tavg_end_w_time = '0'; $tt_patients_w = '0'; $tt_avg_time_w='0'; $tttoken_w='0'  ?>
                                @foreach($getTodayAvgWaitingTime as $awaitingTime)
                                   
                                @php( $tavg_end_w_time += strtotime($awaitingTime->updated_at) )
                                @php( $tavg_start_w_time += strtotime($awaitingTime->created_at))
                                @php( $tt_patients_w += count($awaitingTime->number))
                                @endforeach
                             
                                <?php 
                                 if($tt_patients_w > 0){
                                    $tttoken_w = $tt_patients_w;
                                    //echo $tttoken.'<br>';
                                   }else{
                                    $tttoken_w  = 1;
                                   }
                                   $tt_avg_time_w = ($tavg_end_w_time-$tavg_start_w_time)/$tttoken_w;
                                  // echo $tt_avg_time_w;
                                   
                                 echo gmdate("H:i:s", $tt_avg_time_w).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                   
                                    ?>
                                
                                </h4>
                                </p>
                            </div>
                            <div class="card-action green darken-2">
                                <div class="center-align">
                    <a href="javascript:void(0)" style="text-transform:none;color:#fff">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content blue-grey white-text">
                <p class="card-stats-title truncate"><i class="mdi-action-trending-up"></i> {{ trans('messages.consultingtime') }}</p>
                                <h4 class="card-stats-number">
                                <?php $tavg_start_time = '0'; $tavg_end_time = '0'; $tt_patients = '0'; $tt_avg_time='0';  ?>
                                @foreach($getTodayAvgConsultingTime as $aconsultingTime)
                                   
                                @php( $tavg_end_time += strtotime($aconsultingTime->doctor_work_end_date) )
                                @php( $tavg_start_time += strtotime($aconsultingTime->doctor_work_start_date))
                                @php( $tt_patients += count($aconsultingTime->number))
                                @endforeach
                               
                                <?php 
                                 if($tt_patients > 0){
                                    $tttoken = $tt_patients;
                                    //echo $tttoken.'<br>';
                                   }else{
                                    $tttoken  = 1;
                                   }
                                   $tt_avg_time = ($tavg_end_time-$tavg_start_time)/$tttoken;
                                   
                                 echo gmdate("H:i:s", $tt_avg_time).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                   
                                    ?>
                                
                                </h4>
                                </p>
                            </div>
                            <div class="card-action blue-grey darken-2">
                                <div class="center-align">
                        <a href="javascript:void(0);" style="text-transform:none;color:#fff">&nbsp; </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-image-timer"></i> {{ trans('messages.totalconsultant') }}</p>
                                <h4 class="card-stats-number">{{ count($getTodayAvgConsultingTime) }}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);" style="text-transform:none;color:#fff">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('access', \App\Models\User::class)
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark teal lighten-3 white-text" style="display:inherit">
                            <span class="chart-title">{{ trans('messages.queue_details') }}</span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="queue-details-chart" height="155" style="height:308px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark" style="display:inherit">
                            <span class="chart-title">{{ trans('messages.today_yesterday') }}</span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="today-vs-yesterday-chart" height="155" style="height:308px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan


            @if($role == 'H')
			<div class="row">
					<div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.dat') }}</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_present)}}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>{{ trans('messages.drabsent') }}</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_absent)}}</h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>	
                <div class="row">
            <div class="col s12">
            
            <div class="queuetokenbox">  
            
       <ul id="tabs-swipe-demo" class="tabs">    
    <li class="tab"><a class="active" href="#tabname_doctor">{{ trans('messages.mainapp.role.Doctor') }}</a></li>
    <li class="tab"><a href="#tabname_user">{{ trans('messages.mainapp.role.Staff') }}</a></li>
  </ul>
  <div id="tabname_doctor" style="width:100%;">
            <h3 class="listdoctor">{{ trans('messages.doctorlist') }}</h3>
                <div class="cardp card-panel">
                    <table id="doctor-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>
                                    <?php
                                     if(!empty($tuser->counter_id))
                                     {   $rooms_id = $tuser->counter_id;
                                          $array_rooms_id =  explode(', ', $rooms_id); 
                                         foreach($array_rooms_id as $room_id){
                                          foreach($doctorrooms as $rooms){ 
                                              if($rooms->id == $room_id ){echo $rooms->name.'<br>';}
                                            } 
                                         }
                                        }else{
                                         echo 'Not Allowted';   
                                        }
                                    ?>

                                    </td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                  @if($tuser->user_status == 1)
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  @else
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  @endif
                                 </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
<!------------------------------------------------>

<div id="tabname_user" style="width:100%;">
            <h3 class="listdoctor">{{ trans('messages.userlist') }}</h3>
                <div class="cardp card-panel">
                    <table id="user-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffusers as $staffuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staffuser->name }}</td>
                                    <td>{{ $staffuser->email }}</td>
                                    <td>{{ $staffuser->role_text }}</td>
                                  <td class="caction">
                                  @if($staffuser->user_status == 1)
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  @else
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  @endif
                                 </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
               </div>


<!-------------------------------------------->

               </div>


            </div>
        </div>
    </div>
			@endif

			
			
			@if($role == 'S')
			<div class="row userdashboard">
            <ul id="tabs-swipe-demo" class="tabs">    
            <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content yellow darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>{{ trans('messages.tit') }}</p>
                                <h4 class="card-stats-number">{{count($get_all_department_total_queue_in_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action yellow darken-4">
                                <div class="center-align">
                                <a class="active" href="#tabname_queue">{{ trans('messages.md') }} <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.tct') }}</p>
                                <h4 class="card-stats-number">{{count($get_all_department_total_called_in_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action pink darken-4">
                                <div class="center-align">
                                <a href="#tabname_called">{{ trans('messages.md') }} <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>

                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.dat') }}</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_present)}}</h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                <a href="#tabname_dpresent">{{ trans('messages.md') }} <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                            <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.cbns') }}</p>
        <h4 class="card-stats-number">{{count($get_all_department_total_called_but_not_seen_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                <a href="#tabname_dabsent">{{ trans('messages.md') }} <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
                   
                </ul>
      <!------------------------------>  
      <div class="usertablebox">
      <div id="tabname_queue" class="col s12 m12 l12">
      <div class="cardp card-panel">
         
      <table id="queue-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                                <th>Registration No.</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($get_all_department_total_queue_in_today->sortBy('department_id') as $q)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>@foreach($pardepartments as $pardepartment)
                                    @if( $q->department->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach</td>
                           <td>{{$q->department->name}}</td>
                           <td>{{$q->department->letter}}{{$q->number}}</td>
                           <td>{{$q->regnumber}}</td>
                           </tr>
                       @endforeach    
                        </tbody>
                    </table>
                </div>

      </div>
      <div id="tabname_called" class="col s12 m12 l12">
      <div class="cardp card-panel">
                    <table id="called-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
								<th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                                <th>{{ trans('messages.users.room_number') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($get_all_department_total_called_in_today as $c)
                           <tr>
                           <td>{{ $loop->iteration }}</td>
						   <td>
                           <?php
                                     if(!empty($c->counter_id))
                                     {   $rooms_id = $c->counter_id;
                                          $array_rooms_id =  explode(', ', $rooms_id); 
                                         foreach($array_rooms_id as $room_id){
                                          foreach($doctorrooms as $rooms){ 
                                              if($rooms->id == $room_id ){echo $rooms->name.'<br>';}
                                            } 
                                         }
                                        }else{
                                         echo 'Not Allowted';   
                                        }
                                    ?>
                           </td>
                           <td>@foreach($pardepartments as $pardepartment)
                                    @if( $c->department->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach</td>
                           <td>{{$c->department->name}}</td>
                           <td>{{$c->department->letter}}{{$c->number}}</td>
                           <td>
                          
                           <?php
                                     if(!empty($c->counter_id))
                                     {   $rooms_id = $c->counter_id;
                                          $array_rooms_id =  explode(', ', $rooms_id); 
                                         foreach($array_rooms_id as $room_id){
                                          foreach($doctorrooms as $rooms){ 
                                              if($rooms->id == $room_id ){echo $rooms->name.'<br>';}
                                            } 
                                         }
                                        }else{
                                         echo 'Not Allowted';   
                                        }
                                    ?>
                           </td>
                           </tr> 
                        @endforeach 
                        </tbody>
                    </table>
                </div>

      </div>
      <div id="tabname_dpresent" class="col s12 m12 l12">
      <div class="cardp card-panel">
                    <table id="dp-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                            @if($tuser->user_status == 1)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>
                                    <?php
                                     if(!empty($tuser->counter_id))
                                     {   $rooms_id = $tuser->counter_id;
                                          $array_rooms_id =  explode(', ', $rooms_id); 
                                         foreach($array_rooms_id as $room_id){
                                          foreach($doctorrooms as $rooms){ 
                                              if($rooms->id == $room_id ){echo $rooms->name.'<br>';}
                                            } 
                                         }
                                        }else{
                                         echo 'Not Allowted';   
                                        }
                                    ?>
                                    </td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  </td>
                                    </tr>
                                    
                                  @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
      </div>
      <div id="tabname_dabsent" class="col s12 m12 l12">
       
      <div class="cardp card-panel">
      <table id="da-table"  class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                                <th>Registration No.</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach($get_all_department_total_called_but_not_seen_today as $d)
                           <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{$d->department->name}}</td>
                           <td>{{$d->number}}</td>
                           <td>{{$d->queue->regnumber}}</td>
                           </tr> 
                        @endforeach 

                           
                        </tbody>
                    </table>
                </div> </div>
      </div>

      </div>            
                    
      <!------------------------------->              
                </div>	
			@endif
			
			@if($role == 'D')
           <!----------------------------------> 
            <div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>{{ trans('messages.departments') }} :</span><span>
           @if($pdepartments->id == '') <a style="color:red">Not Allotted</a>  @else {{$pdepartments->name}}  @endif
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>{{ trans('messages.subdepartment') }} :</span><span>@if($user_details->department_id == '') <a style="color:red">Not Allotted </a> @else {{$user_details->department->name}}   @endif</span>
            </div></div>

            <div class="col s12 m6 l6">
            <div class="doctordetails">
            <span>{{ trans('messages.roomnumber') }} :</span>
            <span>
            <?php if(!empty($user_details->counter_id))
                   { $rooms_id = $user_details->counter_id;
                   $array_rooms_id =  explode(', ', $rooms_id); 
                   foreach($array_rooms_id as $room_id){
                   foreach($doctorrooms as $rooms){if($rooms->id == $room_id ){echo '<strong class="multiroom">'.$rooms->name.'</strong>';}
                                            } 
                   }
                                        }else{
                                         echo 'Not Allotted';   
                                        }
               ?>

            </span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row">

             <!------------------------->
             <div class="col s12 m3 l3 pd_right">
               
               <div class="card hoverable">
               <div class="pripad responsive_info card-content lightblack darken-2 white-text">
 
        <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.prioritypending') }}</p>
                    <div class="prioritybox"> <ul>
             @if($queuesetting->tokendisplay==2)
             <li><span class="plclr">{{ trans('messages.platinum') }}</span><span class="plclr">{{count($platinum_patient)}}<span></li>
             <li><span class="glclr">{{ trans('messages.gold') }}</span><span class="glclr">{{count($gold_patient)}}<span></li>
             <li><span class="slclr">{{ trans('messages.silver') }}</span><span class="slclr">{{count($silver_patient)}}<span></li>
             @else
             <li><span class="plclr">{{ trans('messages.platinum') }}</span><span class="plclr">{{count($today_queue_platinum)}}<span></li>
             <li><span class="glclr">{{ trans('messages.gold') }}</span><span class="glclr">{{count($today_queue_gold)}}<span></li>
             <li><span class="slclr">{{ trans('messages.silver') }}</span><span class="slclr">{{count($today_queue_silver)}}<span></li>
             @endif

                     </ul></div>
 
                  </div>
                         
              </div>
              </div>
 
<!-------------------------> 
            <div class="col s12 m9 l9 pd_right">
            <div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                         <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.patientseen') }} </p>
                                <h4 class="card-stats-number">{{ $patient_seen }}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
            <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.patientcalled') }}</p>
                                <h4 class="card-stats-number">
                                {{count($patient_called_bydoctor)-$patient_seen}}
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.patientpending') }}</p>
                                <h4 class="card-stats-number">
                                @if($queuesetting->tokendisplay==2)
                                    {{count($today_queue_bycounter_doctor)}}
                                @else
                                    {{count($today_queue_bycounter)}}
                                @endif    
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action orange darken-4">
                                <div class="center-align">
                                <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.patientavgtime') }}</p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               @foreach($daily_avgtime_of_doctor as $option)
                                @php( $total_end_time += strtotime($option->end_time) )
                                @php( $total_start_time += strtotime($option->start_time))
                               @endforeach
                            
                                <?php 
                               // echo $patient_seen.'<br>';
                               if($patient_seen > 0){
                                $ttpatient = $patient_seen;
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_time-$total_start_time)/$ttpatient;
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                ?>
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action blue darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>  
            <!---------------------------->
                    </div></div>
             
            <!------------------------->            
                </div>	
			@endif
			
			@if($role == 'D')
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room No.</th>
								<th>Token</th>
                                <th>Priority</th>
                                <th>Patient Type</th>
                                <th>Consult</th>
                                <th style="display:none;">Patient Called</th>
             @if($user->department_id !== $queuesetting->dispensary_id)  <th>{{ trans('messages.actions') }}</th> @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient_list_doctorwise->sortBy('id') as $patient)
                        <!---------------------------------------->   
                                <tr>
                                    <td @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif >{{ $loop->iteration }}</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    
                                    <?php if(!empty($patient->counter_id))
                   { $rooms_id = $patient->counter_id;
                   $array_rooms_id =  explode(', ', $rooms_id); 
                   foreach($array_rooms_id as $room_id){
                   foreach($doctorrooms as $rooms){if($rooms->id == $room_id ){echo '<strong class="multiroom">'.$rooms->name.'</strong>';}
                                            } 
                   }
                                        }else{
                                         echo 'No Room';   
                                        }
               ?>
                                    
                                    </td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{$patient->department->letter}}{{ $patient->number  }}</td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
									@if($patient->priority==1) <span class="boxmodi plbox">Plantinum </span>
									@elseif($patient->priority==2) <span class="boxmodi glbox">Gold</span>
									@elseif($patient->priority==3) <span class="boxmodi slbox">Silver</span>
									@elseif($patient->priority==4) <span class="boxmodi nlbox">Normal</span>
									@else
                                     Normal										
									@endif	
                                    </td>

                            <td style="font-size:10px;"  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                             @if($patient->queue->token_type == 'R') <a class="clr_yellow"> REVIEW </a>
                             @elseif($patient->queue->token_type == 'F') <a class="clr_red tooltipped" data-position="top" data-tooltip="Refer By : {{$patient->queue->refer_by}}">REFERRAL</a>
                              @else <a class="clr_green"> FIRST TIME </a> @endif
                                    </td>    
                                    
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="{{url('/dashboard/startCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.start_time') }}"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.you_do_first_start') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.You_have_started') }}"> <i class="mdi-av-timer"></i></a>

<a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="{{url('/dashboard/endCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.end_time') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else{
                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php
                                        }
                                    }else{

                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php    
                                    }
                                    ?>
        <!--------------------Start-Dispensary-button-&-Popup-------------------->
        @if($user->department_id !== $queuesetting->dispensary_id) <!---start-if-for-user-dept-and-kiosk-dept--->

        @if($queuesetting->tokendisplay==2)

             @if($patient->doctor_work_start == 1)
             <a class="modal-trigger dispensorybutton" href="#modaldispensary_{{ $patient->id }}">Dispensary</a>
            @else
            <a class="btndisabled dispensorybutton" href="javascript:void(0);">Dispensary</a>
            @endif
        <!-------Start-Dispensary-doctor-popup--------------> 

        <div id="modaldispensary_{{ $patient->id }}" class="custom-modal modal">
                <div class="modal-content">
                <div class="customform">
                <h4>Token No. : {{ $patient->number }} </h4>
                <h3>Please proceed to pharmacy to collect your medicine</h3>
            <form id="modaldispensary2_{{ $patient->id }}" name="modaldispensary2_{{ $patient->id }}" action="/" method="GET">

            <input class="department_id_{{ $patient->id }}" name="department_id" type="hidden" value="{{ $patient->department_id }}" />

            <input autocomplete="off" class="registration_{{ $patient->id }} regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" />
            
            <input class="uhid_{{ $patient->id }}" name="uhid" type="hidden" placeholder="Enter Priority Number" value="{{ $patient->queue->uhid }}" autofocus="autofocus" autocomplete="off" /> 

            <!----Name-Mobile-Email---------> 
        <input class="pname_{{ $patient->id }}" name="pname" type="hidden"  value="{{$patient->queue->pname}}" />
       <!------------------------>
       

      @if($patient->queue->pmobile !== NULL)
                    <input class="pmobile_{{ $patient->id }}"  name="pmobile" type="hidden" value="{{$patient->queue->pmobile}}"  />
         @else 
         <input autocomplete="off" autofocus id="pmobilevd" class="pmobilevd_{{ $patient->id }}"  name="pmobilevd" placeholder="Enter Mobile Number" maxlength="10" type="text" value=""  />
     @endif              
       
       <!------------------------>
        <input class="pemail_{{ $patient->id }}" name="pemail" type="hidden" value="{{$patient->queue->pemail}}"  />
        <input class="dispensaryflag_{{ $patient->id }}" name="dispensaryflag" type="hidden" value="M"  />   
             <!------------------------------->  
               
            <div class="row refboxmrg">
                        <div class="input-field col s12">
                            <label for="disdoctor" class="active">{{ trans('messages.select') }} Dispensary Counter</label>
                            <select id="disdoctor" class="browser-default disdoctor_{{ $patient->id }}" name="disdoctor" data-error=".disdoctor">
							<option value="">{{ trans('messages.select') }} Dispensary Counter</option>
							@foreach($activedoctordispensary as $activedispdoctor)
                           
        <option value="{{$activedispdoctor->id}}">
        <?php $dr_room = ''; if(!empty($activedispdoctor->counter_id))
                   { $rooms_id = $activedispdoctor->counter_id;
                   $array_rooms_id =  explode(', ', $rooms_id); 
                   foreach($array_rooms_id as $room_id){
                   foreach($doctorrooms as $rooms){if($rooms->id == $room_id ){$dr_room .= $rooms->name.', ';}
                                            } 
                   }
                                        }else{
                                        $dr_room .= 'No Room';   
                                        }
               ?>
        {{$activedispdoctor->name}} &#8596; {{$activedispdoctor->department->name}} &#8596; ( {{$dr_room}} )
        </option>
                        @endforeach
							</select>
                            <div class="doctor">
                                @if($errors->has('doctor'))<div class="error">{{ $errors->first('doctor') }}</div>@endif
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
               <a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a>
               <button class="btn waves-effect waves-light csfloat subbutton" onclick="send_to_dispensary({{ $patient->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none; margin-left:10px;">SEND TO DISPENSARY<i class="mdi-navigation-arrow-forward right"></i>
                </button>
            </div>
                </div>
                </div>
                </div>
          
        <!-------End-Dispensary-doctor-popup---------------->
        @else

        @if($patient->doctor_work_start == 1)
        <!----IF-not-mobile------->
            @if($patient->queue->pmobile !== NULL)
            <a class="dispensorybutton" href="{{url('/dashboard/endCounterdisp_department')}}/{{$patient->id}}">Dispensary</a>
            @else 
            <a class="modal-trigger dispensorybutton" href="#modaldispensarydepartment_{{ $patient->id }}">Dispensary</a>
            @endif
        <!-----IF-not-mobile-------->
            @else
            <a class="btndisabled dispensorybutton" href="javascript:void(0);">Dispensary</a>
            @endif

        <!---------------------->

        <div id="modaldispensarydepartment_{{ $patient->id }}" class="custom-modal modal">
                <div class="modal-content">
                <div class="customform">
                <h4>Token No. : {{ $patient->number }} </h4>
                <h3>Please proceed to pharmacy to collect your medicine</h3>
            <form id="modaldispensarydepartment_{{ $patient->id }}"  action="{{ url('dashboard/endCounterdisp_departmentdirect') }}/{{ $patient->id }}" method="GET">
            {{ csrf_field() }}
            <div class="row refboxmrg">
                        <div class="input-field col s12">
                            <label for="pmobilenumber" class="active">Enter 10 Digit Mobile Number</label>
                    <input autocomplete="off" autofocus id="pmobilenumber_{{ $patient->id }}"  name="pmobilenumber" placeholder="Enter Mobile Number" maxlength="10" type="text" value="" />
                            <div class="pmobile">
                                @if($errors->has('pmobilenumber'))<div class="error">{{ $errors->first('pmobilenumber') }}</div>@endif
                            </div>
                        </div>
                    </div>
          
                    <div class="row">
                        <div class="input-field col s12">
                        <button class="btn waves-effect waves-light csfloat subbutton" type="submit" this.style.visibility='hidden'; this.disable=true;" style="text-transform:none; margin-left:10px;">SEND TO DISPENSARY<i class="mdi-navigation-arrow-forward right"></i>
                </button>   
                        </div>
                    </div>
                     
            
                </form>
                </div>
                </div>
                </div>

        <!----------------------->   
        
        @endif

                             @endif   <!---end-if-for-user-dept-and-kiosk-dept--->
         <!--------------------Start-Dispensary-button-&-Popup-------------------->
                                    

                                    </td>
                                  
                                  
                                  @if(in_array($patient->view_status, array(1,2)))
                                  <td style="display:none;">
                                  @if($patient->doctor_work_start == 1)     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  @else
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>
                                 @endif
                                 </td> 
                                 <!--------->
                                  @else
                                  <td style="display:none;"> 
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>
                                  @endif
                                  <!------------->

                           <!-----------Referral-Review---------------->  
                           @if($user->department_id !== $queuesetting->dispensary_id)     
                                  <td>
                                  <?php
                              if($patient->doctor_work_start == 1){
                                    ?>
                                      @if($queuesetting->tokendisplay==1)
<a style="font-size:10px;margin-right:5px;" class="modal-trigger btn-floating waves-effect waves-light btn orange tooltipped" href="#modal2_{{ $patient->id }}" data-position="top" data-tooltip="Refer"> <i class="mdi-communication-call-made"></i></a>
                                   @else
<a style="font-size:10px;margin-right:5px;" class="modal-trigger btn-floating waves-effect waves-light btn orange tooltipped" href="#modal1_{{ $patient->id }}" data-position="top" data-tooltip="Refer"> <i class="mdi-communication-call-made"></i></a>
                                          @endif
                   
<a style="font-size:10px;" class="btn-floating waves-effect waves-light btn pink tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Review" onclick="review({{ $patient->id }}); this.style.visibility='hidden'; this.disable=true;"> <i class="mdi-editor-mode-edit"></i></a>
                                  
                                        <?php } else {?>

 <a style="font-size:10px;cursor:not-allowed; margin-right:5px;" class="disabled btn-floating waves-effect waves-light btn orange tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Refer"> <i class="mdi-communication-call-made"></i></a>

<a style="font-size:10px;cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn pink tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Review"> <i class="mdi-editor-mode-edit"></i></a>

                                        <?php } ?>
                                        

                                  </td> @endif
                           <!------------------------------------------->      
                                 </tr>
                         <!------------------>  


                          <!---------------Popup-modal-1----------------------------->
                    <div id="modal1_{{ $patient->id }}" class="custom-modal modal">
                <div class="modal-content">
                <div class="customform">
                <h4>Token No. : {{ $patient->number }}</h4>
                <h3>Refer To Next Doctor</h3>
            <form id="dep_isuuetkn2_{{ $patient->id }}" name="getValueform2_{{ $patient->id }}" action="/" method="GET">

            <input class="department_id_{{ $patient->id }}" name="department_id" type="hidden" value="{{ $patient->department_id }}" />

            <input autocomplete="off" class="registration_{{ $patient->id }} regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" />
            
            <input class="uhid_{{ $patient->id }}" name="uhid" type="hidden" placeholder="Enter Priority Number" value="{{ $patient->queue->uhid }}" autofocus="autofocus" autocomplete="off" /> 

            <!----Name-Mobile-Email---------> 
        <input class="pname_{{ $patient->id }}" name="pname" type="hidden"  value="{{$patient->queue->pname}}" />
        <input class="pmobile_{{ $patient->id }}" name="pmobile" type="hidden" value="{{$patient->queue->pmobile}}" /> 
        <input class="pemail_{{ $patient->id }}" name="pemail" type="hidden" value="{{$patient->queue->pemail}}"  />
        <input class="referralflag_{{ $patient->id }}" name="referralflag" type="hidden" value="F"  />   
             <!------------------------------->         
                
            <div class="row refboxmrg">
                        <div class="input-field col s12">
                            <label for="doctor" class="active">{{ trans('messages.select') }} Doctor</label>
                            <select id="doctor" class="browser-default doctor_{{ $patient->id }}" name="doctor" data-error=".doctor">
							<option value="">{{ trans('messages.select') }} Doctor</option>
							@foreach($activedoctortoseereferrals as $activerefdoctor)
                           
        <option value="{{$activerefdoctor->id}}">
        <?php $dr_room = ''; if(!empty($activerefdoctor->counter_id))
                   { $rooms_id = $activerefdoctor->counter_id;
                   $array_rooms_id =  explode(', ', $rooms_id); 
                   foreach($array_rooms_id as $room_id){
                   foreach($doctorrooms as $rooms){if($rooms->id == $room_id ){$dr_room .= $rooms->name.', ';}
                                            } 
                   }
                                        }else{
                                        $dr_room .= 'No Room';   
                                        }
               ?>
        {{$activerefdoctor->name}} &#8596; {{$activerefdoctor->department->name}} &#8596; ( {{$dr_room}} )
        </option>
                        @endforeach
							</select>
                            <div class="doctor">
                                @if($errors->has('doctor'))<div class="error">{{ $errors->first('doctor') }}</div>@endif
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
               <a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a>
               <button class="btn waves-effect waves-light csfloat subbutton" onclick="refer_to_doctor({{ $patient->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none; margin-left:10px;">REFER<i class="mdi-navigation-arrow-forward right"></i>
                </button>
            </div>
                </div>
                </div>
                </div>
                 <!---------------Popup-modal-2----------------------------->
                 <div id="modal2_{{ $patient->id }}" class="custom-modal modal">
                <div class="modal-content">
                <div class="customform">
                <h4>Token No. : {{ $patient->number }}</h4>
                <h3>Refer To Next Doctor</h3>
            <form id="dep_isuuetkn2_{{ $patient->id }}" name="getValueform2_{{ $patient->id }}" action="/" method="GET">

            <input autocomplete="off" class="registration_{{ $patient->id }} regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" />
            
            <input class="uhid_{{ $patient->id }}" name="uhid" type="hidden" placeholder="Enter Priority Number" value="{{ $patient->queue->uhid }}" autofocus="autofocus" autocomplete="off" /> 

            <!----Name-Mobile-Email---------> 
        <input class="pname_{{ $patient->id }}" name="pname" type="hidden"  value="{{$patient->queue->pname}}" />
        <input class="pmobile_{{ $patient->id }}" name="pmobile" type="hidden" value="{{$patient->queue->pmobile}}" /> 
        <input class="pemail_{{ $patient->id }}" name="pemail" type="hidden" value="{{$patient->queue->pemail}}"  />
        <input class="referralflag_{{ $patient->id }}" name="referralflag" type="hidden" value="F"  />   
             <!------------------------------->         
                
            <div class="row refboxmrg">
                        <div class="input-field col s12">
                            <label for="department" class="active">{{ trans('messages.select') }} Department</label>
                            <select id="department" class="browser-default department_{{ $patient->id }}" name="department" data-error=".department">
							<option value="">{{ trans('messages.select') }} Department</option>
							@foreach($activedepttoseereferrals as $activedept)
        <option value="{{$activedept->id}}">
        {{$activedept->name}} 
        </option>
                        @endforeach
							</select>
                            <div class="department">
                                @if($errors->has('department'))<div class="error">{{ $errors->first('department') }}</div>@endif
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
               <a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a>
               <button class="btn waves-effect waves-light csfloat subbutton" onclick="refer_to_department({{ $patient->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none; margin-left:10px;">REFER<i class="mdi-navigation-arrow-forward right"></i>
                </button>
            </div>
                </div>
                </div>
                </div>
                    <!------------End-modal----------------------------------->
                            
                        
                         <!------------------>

                            @endforeach
                        </tbody>
                    </table>
                    
                <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               @if($queuesetting->tokendisplay==2)
               <form id="new_call" action="{{ route('post_doctor_call_ourtoken') }}" method="post">
               @else    
               <form id="new_call" action="{{ route('post_doctor_call') }}" method="post"> 
                @endif   
              <!------------------------------------>   
                <?php  $doctroom = ''; $counter = ''; 
                    if(!empty($user->counter_id)){ 
                        $rooms_id = $user->counter_id;
                        $array_rooms_id =  explode(', ', $rooms_id); 
                        $rand_room = array_rand($array_rooms_id);
                        $doctroom = $array_rooms_id[$rand_room]; 

                        foreach($array_rooms_id as $room_id){
                            foreach($doctorRoomsInQueue as $queurooms){
                                if($queurooms->counter_id == $room_id ){$doctroom .= $room_id.' ,';}
                                                     } 
                            }
                       
                    }
                
               ?>
               <!----------------------------------->    
                        {{ csrf_field() }}
                            @if(!($user->is_admin)||($user->role=='D'))
                            
                   
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <input type="hidden" name="ads_id" value="{{ $user->ads_id }}">
                            <input type="hidden" name="pid" value="{{ $user->pid }}">
                            <input type="hidden" name="department" value="{{ $user->department_id }}">
                            <input type="hidden" name="counter" value="{{ $user->counter_id }}">
                           
                           @endif

                <div class="row">
                <div class="col s12">
             @if($queuesetting->tokendisplay==2)
                <button @if((count($patient_list_doctorwise) >= 6)||(count($today_queue_bycounter_doctor) == 0)) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                {{ trans('messages.call.call_next') }}<i class="mdi-content-send right"></i></i>
                </button>
             @else
             <button @if((count($patient_list_doctorwise) >= 6)||(count($today_queue_bycounter)==0)) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                {{ trans('messages.call.call_next') }}<i class="mdi-content-send right"></i></i>
                </button>
             @endif 

                </div>
                </div>


                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>
                    
                </div>
				</div>
			</div>
			@endif

      <!-----------Start-Superadmin----------------------->  
      @if($role == 'O')
      <div class="row">
      <div class="col s12">
      <div class="superadminbox">
      <ul>
      <li><span>{{ trans('messages.ndoctor') }}</span><span> {{count($No_Of_Doctor)}}</span></li>
      <li><span>{{ trans('messages.nuser') }}</span><span> {{count($No_Of_Staff)}}</span></li>
      <li><span>{{ trans('messages.nhelpdesk') }}</span><span> {{count($No_Of_Helpdesk)}}</span></li>
      <li><span>{{ trans('messages.ncmo') }}</span><span> {{count($No_Of_CMO)}}</span></li>
      <li><span>{{ trans('messages.ndisplayctrl') }}</span><span> {{count($No_Of_Displayctrl)}}</span></li>
      <li><span>{{ trans('messages.ndepartment') }}</span><span> {{count($No_Of_Pdepartment)}}</span></li>
      <li><span>{{ trans('messages.nsupdepartment') }}</span><span> {{count($No_of_Department)}}</span></li>
      <li><span>{{ trans('messages.nroom') }}</span><span> {{count($No_of_Counter)}}</span></li>
      <li><span>{{ trans('messages.ntokenperday') }}</span><span> {{count($No_of_tokenPerDay)}}</span></li>
      <li><span>{{ trans('messages.nads') }}</span><span>{{count($No_of_Ads)}}</span></li>
      </ul>
      </div>

     
                
       </div>
      </div>
      @endif    
      <!------------End-Superadmin---------------------->
            
			@if($role == 'A')
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable waves-effect waves-dark" style="display:inherit">
                        <div class="card-move-up black-text">
                            <div class="move-up">
                                <div>
                                    <span class="chart-title">{{ trans('messages.dashboard.notification') }}</span>
                                </div>
                                <div class="trending-line-chart-wrapper">
                                    <p>{{ trans('messages.dashboard.preview') }}:</p>
                                    <span style="font-size:{{ $setting->size }}px;color:{{ $setting->color }}">
                                        <marquee>{{ $setting->notification }}</marquee>
                                    </span>
                                    <p></p>
                                    <form id="noti" action="{{ route('dashboard_store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <label for="notification">{{ trans('messages.dashboard.notification_text') }}</label>
                                                <input id="notification" name="notification" type="text" placeholder="{{ trans('messages.dashboard.notification_placeholder') }}" data-error=".errorNotification" value="{{ $setting->notification }}">
                                                <div class="errorNotification"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <label for="size">{{ trans('messages.font_size') }}</label>
                                                <input id="size" name="size" type="number" placeholder="Size" max="60" min="15" size="2" data-error=".errorSize" value="{{ $setting->size }}">
                                                <div class="errorSize"></div>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <label for="color">{{ trans('messages.color') }}</label>
                                                <input id="color" type="text" placeholder="Color" name="color" data-error=".errorColor" value="{{ $setting->color }}">
                                                <div class="errorColor"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <button class="btn waves-effect waves-light right submit" type="submit" style="padding:0 1.3rem">{{ trans('messages.go') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			@endif
		</div>
    </div>
@endsection

<!----------Start-print-section----------------------->

@section('print')

@if($queuesetting->tokendisplay==1)

    @if(session()->has('department_name'))
    <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
          @if(session()->get('uhid') != '')
			<span style="position:absolute; top:0px; right:0px; font-size:10px; color:black;">
               @if(session()->get('priority') == '1') P 
               @elseif(session()->get('priority') == '2') G
               @elseif(session()->get('priority') == '3') S 
               @elseif(session()->get('priority') == '4') N 
               @else N  @endif
             </span>@else  @endif
   
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="{{url('public/logo')}}/{{ $setting->logo }}" alt="logo"> {{str_limit( $company_name)}} </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}  <sup>{{ session()->get('referral') }}</sup></span>
   @if($queuesetting->reg_required==1)
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>@endif

  </td></tr>
   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('patient_name') }}</td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('department_name') }}</td> </tr>
    
   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Referred By <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('referred_by') }}</td> </tr>

   </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:10px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>
<!--------------------->
        </div>
        @if(session()->get('printFlag'))
			<script>
				window.onload = function(){window.print();}
			</script>
		@endif	
    @endif
<!----------------------------->
@elseif($queuesetting->tokendisplay==2)
<!------===========================------------------------->

@if(session()->has('user_name'))
    <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="{{url('public/logo')}}/{{ $setting->logo }}" alt="logo"> {{str_limit( $company_name)}} </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}  <sup>{{ session()->get('referral') }}</sup></span>

   @if($queuesetting->reg_required==1)
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>@endif

  </td></tr>

   <tr><td colspan="2" style="padding:0px 3px; font-size:10px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Doctor Name (डॉक्टर नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('user_name') }}</td> </tr>
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Room No. (कमरा संख्या) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('room_number') }}</td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('doctor_department') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('patient_name') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Referred By <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('referred_by') }}</td> </tr>

   </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:3px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>
<!--------------------->
        </div>
        @if(session()->get('printFlag'))
			<script>
				window.onload = function(){window.print();}
			</script>
		@endif	
    @endif
<!------------>
    @endif
<!-----============================------------------------>



<!----==========Start=Dispensary-section=======-------------------------->
@if(session()->has('dispensary_doctor'))
    <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="{{url('public/logo')}}/{{ $setting->logo }}" alt="logo"> {{str_limit( $company_name)}} </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}  <sup>{{ session()->get('patient_type') }}</sup></span>

   @if($queuesetting->reg_required==1)
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>@endif

  </td></tr>

   <tr><td colspan="2" style="padding:0px 3px; font-size:10px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Doctor Name (डॉक्टर नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('doctor_name') }}</td> </tr>
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Room No. (कमरा संख्या) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('room_number') }}</td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('dispensary') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('patient_name') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Send By <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('referred_by') }}</td> </tr>

   </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:3px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>
<!--------------------->
        </div>
        @if(session()->get('printFlag'))
			<script>
				window.onload = function(){window.print();}
			</script>
		@endif	
    @endif
<!------------>

@if(session()->has('dispensary_department'))
    <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="{{url('public/logo')}}/{{ $setting->logo }}" alt="logo"> {{str_limit( $company_name)}} </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}  <sup>{{ session()->get('patient_type') }}</sup></span>

   @if($queuesetting->reg_required==1)
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>@endif

  </td></tr>

   <tr><td colspan="2" style="padding:0px 3px; font-size:10px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('dispensary') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('patient_pname') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Send By <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('referred_by') }}</td> </tr>

   </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:3px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>
<!--------------------->
        </div>
        @if(session()->get('printFlag'))
			<script>
				window.onload = function(){window.print();}
			</script>
		@endif	
    @endif
<!------------>

<!---==========End=Dispensory-section=======--------------------------->


@endsection

<!----------End-print-section----------------------->

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/voice.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/materialize-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/chartjs/chart.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
 
   
    <script>
        @if(session()->get('printFlag'))
        $('.tooltipped').removeAttr('data-tooltip'); 
        @endif 
      
    //------------------------------------------------------------------
    function refer_to_doctor(value) {
           var doctor = $('.doctor_'+value).val();
           var uhid = $('.uhid_'+value).val();
            var registration = $('.registration_'+value).val();
            var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pemail = $('.pemail_'+value).val();
            var referralflag = $('.referralflag_'+value).val();
            var department_id = $('.department_id_'+value).val();
		//alert(doctor); return false;
            var myForm7 = '<form id="hidfrm7" action="{{ url('dashboard/doctor') }}/'+value+'" method="post">{{ csrf_field() }}<input type="hidden" name="doctor" value="'+doctor+'">'+'<input type="text" name="referralflag" value="'+ referralflag +'">'+'<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="department_id" value="'+ department_id +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+'</form>';
            $('body').append(myForm7);
            myForm7 = $('#hidfrm7');
            myForm7.submit();
        }

        function refer_to_department(value) {
            //$('body').removeClass('loaded');
			var uhid = $('.uhid_'+value).val();
            var department = $('.department_'+value).val();
            var registration = $('.registration_'+value).val();
            var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pemail = $('.pemail_'+value).val();
            var referralflag = $('.referralflag_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
			var myForm1 = '<form id="hidfrm1" action="{{ url('dashboard/department') }}/'+value+'" method="post">{{ csrf_field() }}'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="department" value="'+ department +'">'+'<input type="text" name="referralflag" value="'+ referralflag +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+'<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm1);
			
            myForm1 = $('#hidfrm1');
            myForm1.submit();
            //-------------------
          // if(myForm1.submit()){
           // window.onload = function() {startTime() }
           // setTimeout(location.reload(), 1000);
            // }; 
            
            //----------------
        }

        function review(value) {
           
		//alert(doctor); return false;
            var myForm8 = '<form id="hidfrm8" action="{{ url('dashboard/review') }}/'+value+'" method="post">{{ csrf_field() }}<input type="hidden" name="id" value="'+value+'">'+'</form>';
            $('body').append(myForm8);
            myForm8 = $('#hidfrm8');
            myForm8.submit();
        }


        function send_to_dispensary(value) {
           var disdoctor = $('.disdoctor_'+value).val();
           var uhid = $('.uhid_'+value).val();
            var registration = $('.registration_'+value).val();
            var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pmobilevd = $('.pmobilevd_'+value).val();
            var pemail = $('.pemail_'+value).val();
            var dispensaryflag = $('.dispensaryflag_'+value).val();
            var department_id = $('.department_id_'+value).val();
            //alert(pmobile); return false;
            var myForm9 = '<form id="hidfrm9" action="{{ url('/dashboard/endCounterdisp_doctor') }}/'+value+'" method="post">{{ csrf_field() }}<input type="hidden" name="doctor" value="'+disdoctor+'">'+'<input type="text" name="dispensaryflag" value="'+ dispensaryflag +'">'+'<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="department_id" value="'+ department_id +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pmobilevd" value="'+ pmobilevd +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+'</form>';
            $('body').append(myForm9);
            myForm9 = $('#hidfrm9');
            myForm9.submit();
        }


    //-------------------------------------------------------------------    
        $(function() {
            $('#doctor-table').DataTable({
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

            $('#user-table').DataTable({
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


            $('#queue-table').DataTable({
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

            $('#called-table').DataTable({
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




            $('#dp-table').DataTable({
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

            $('#da-table').DataTable({
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

    <script>
        function nextPatient(){
            var bleep = new Audio();
            bleep.src = '{{ url('assets/sound/sound1.mp3') }}';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }

        $(function() {
            $('#color').colorpicker();
        });

        @can('access', \App\Models\User::class)
            $("#noti").validate({
                rules: {
                    notification: {
                        required: true,
                        minlength: 5
                    },
                    size: {
                        required: true,
                        digits: true
                    },
                    color: {
                        required: true
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

           $(function() {
                var todayVsYesterdayCartData = {
                    labels: [@foreach ($counters as $indx => $counter)
                            @if($indx==0) <?php echo "'$counter->name'"; ?>
                            @else <?php echo ", '$counter->name'"; ?>
                            @endif
                        @endforeach],
                    datasets: [
                      {
                          label: "Today",
                          fillColor: "rgba(0,176,159,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(0,176,159,0.9)",
                          highlightStroke: "rgba(220,220,220,9)",
                          data: [@foreach ($today_calls as $indx => $today_call)
                                  @if($indx==0) <?php echo "'$today_call'"; ?>
                                  @else <?php echo ", '$today_call'"; ?>
                                  @endif
                              @endforeach]
                      },
                      {
                          label: "Yesterday",
                          fillColor: "rgba(151,187,205,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(151,187,205,0.9)",
                          highlightStroke: "rgba(220,220,220,0.9)",
                          data: [@foreach ($yesterday_calls as $indx => $yesterday_call)
                                  @if($indx==0) <?php echo "'$yesterday_call'"; ?>
                                  @else <?php echo ", '$yesterday_call'"; ?>
                                  @endif
                              @endforeach]
                      }
                    ]
                };
          
                var queueDetailsChartData = [
                  {
                      value: "{{ $today_total_patients_in_queue }}",
                      color: "#00c0ef",
                      highlight: "#00c0ef",
                      label: "Token Issued"
                  },
                  {
                      value: "{{ $today_total_patients_in_waiting }}",
                      color: "#00a65a",
                      highlight: "#00a65a",
                      label: "Waiting Patient"
                  },
                  {
                      value: "{{ $today_total_patients_called-count($getTodayAvgConsultingTime) }}",
                      color: "#f39c12",
                      highlight: "#f39c12",
                      label: "Missed Patients"
                  },
                  {
                      value: "{{ count($getTodayAvgConsultingTime) }}",
                      color: "#dd4b39",
                      highlight: "#dd4b39",
                      label: "Consultant"
                  }
                ];

                var todayVsYesterdayCart = new Chart($("#today-vs-yesterday-chart").get(0).getContext("2d")).Bar(todayVsYesterdayCartData,{
                    responsive:true
                });

                var queueDetailsChart = new Chart($("#queue-details-chart").get(0).getContext("2d")).Pie(queueDetailsChartData,{
                    responsive:true
                });
            });
        @endcan

    </script>
@endsection
