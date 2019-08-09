@extends('layouts.mainappqueue')

@section('title', trans('messages.issue').' '.trans('messages.display.token'))

@section('css')
    <style>
        .btn-queue{padding:25px;font-size:47px;line-height:36px;height:auto;margin:10px;letter-spacing:0;text-transform:none}
    </style>
@endsection

@section('content')
    <div class="row">
    
    <div class="col s12">
    <!----start-old-patient-review-doctor-wise---->   
    <div id="old_patient_doctor" class="modal">
                <div class="modal-content">
                <div class="customform"> 

                <div class = "row" style="margin-bottom:0px;">
                <div class="input-field col s12">      
                <div class="regboxx">
                <span><input type="text" value="REVIEW NO." readonly disabled  /></span>
                <span>
                <label>Enter Your Review Number :</label>
                <input autocomplete="off" class="call_id regvalues" style="color:#777;" name="call_id" type="text" placeholder="" value="" onkeyup="getReviewDoctor(this.value);" /></span> 
                </div>         
                </div> 
            <!-------check-review-validation------------->
             <div class="col s12 checkregistd"> 
             <ul> <li class="validregbox" style="font-size:0.8rem" id="revdoctor"></li> </ul>
           </div>
             <!---------------------------------------->
                </div>
                <div class="modal-footer">
                <ul><li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a></li>
                </ul>
                </div> 

                </div>
                </div>
                </div>
             <!----End-old-patient-review-doctor-wise----> 
              <!----start-old-patient-review-department-wise---->   
    <div id="old_patient_department" class="modal">
                <div class="modal-content">
                <div class="customform"> 

                <div class = "row" style="margin-bottom:0px;">
                <div class="input-field col s12">      
                <div class="regboxx">
                <span><input type="text" value="REVIEW NO." readonly disabled  /></span>
                <span>
                <label>Enter Your Review Number :</label>
                <input autocomplete="off" class="call_id regvalues" style="color:#777;" name="call_id" type="text" placeholder="" value="" onkeyup="getReviewDepartment(this.value);" /></span> 
                </div>         
                </div> 
            <!-------check-review-validation------------->
             <div class="col s12 checkregistd"> 
             <ul> <li class="validregbox" style="font-size:0.8rem" id="revdepartment"></li> </ul>
           </div>
             <!---------------------------------------->
                </div>
                <div class="modal-footer">
                <ul><li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a></li>
                </ul>
                </div> 

                </div>
                </div>
                </div>
             <!----End-old-patient-review-department-wise----> 
           </div>
             


        <div class="col s12">
            <div class="card" style="background:#f9f9f9;box-shadow:none">
                <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.click_department') }}</span>
                <div class="divider" style="margin:10px 0 10px 0"></div>
<!----------------------------------------------------->
                 <div class="addtoqueuesection" style="background:url({{url('public/kiosksetting')}}/{{ $kiosksetting->bgimg }}) no-repeat center; background-size:cover;">
             <!--------Start-kiosk-Adverisement------------------->
             <div class="kioskadvertisement"><marquee>{{ $settings->notification }}</marquee></div>   
             <!---------Start-kiosk-Adverisement------------>    
                <div class="queuetokenbox kioskboxx">

                <div class="row">
        <!-------Start-Company-logo----------> 
            <div class="col s8">      
               <div class="queuelogo">
               <span><img src="{{url('public/logo')}}/{{ $settings->logo }}" alt="logo"></span> <span class="amritahosp">
               {{ $settings->name }}
                   </span>
                </div>
            </div>       
         <!--------Start-Datetime-box-----> 
         <div class="col s4">      
                <div class="queue_time">  <span></span> <span><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span>
                <span id="gtime"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM';
             echo $timestamp = date('h:i:s ').$a; ?> </span> </div>
         </div>   
        <!--------End-Datetime-box-----> 
                </div>

        <!--------Start-Heading----->    
                <div class="queue_time"><span>{{ $kiosksetting->texteng }} <br> {{ $kiosksetting->textotherlang }}</span> <span style=display:none;></span><span style=display:none;></span> 
                
                <div class="oldpatientsection">
                @if($kiosksetting->tokendisplay==2)     
                <a class="btnreview modal-trigger" href="#old_patient_doctor">OLD PATIENT</a>
                @else 
                <a class="btnreview modal-trigger" href="#old_patient_department">OLD PATIENT</a> 
                @endif
                </div>
                
                </div>
         <!-------End-Heading---------->

         

       
     
        
         <!----start-sms-on-mobile-------->
         
         <?php
         if(session()->has('department_name')){    //department wise activedted
          require_once(base_path('assets/Sms/textlocal.class.php'));
          require_once(base_path('assets/Sms/credential.php'));

         if(session()->get('patient_mobile') !== NULL) {
         $token = 'Token No. : '.session()->get('number');
         $department = 'Department : '.session()->get('department_name'); 
         $textlocal = new Textlocal(false, false, API_KEY);
         $numbers = array(session()->get('patient_mobile'));
         $sender = 'ASADEL';
         $company = $settings->name;
         $OTP = mt_rand(10000, 99999);
         if(session()->has('user_name')) {
            $room = 'Room No. : '.session()->get('room_number'); //doctor wise activated
            $doctor = 'Doctor Name : '.session()->get('user_name'); //doctor wise activated
            $message = $company."%n %n %n"."TOKEN DETAILS :-"."%n %n".$token."%n".$room."%n".$doctor;
         }else{
            $message = $company."%n %n %n"."TOKEN DETAILS :-"."%n %n".$token."%n".$department;   //department wise activedted
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

<!--------=========Start-Token-Doctor-Wise============-------------------------->

<!----------------------------------------------->
         @if($kiosksetting->tokendisplay==2) 
     <!-----start-Style-1---------> 
     @if($kiosksetting->dr_tokenstyle==1) 
     <div class="row">
    <div class="col s12 padtop">
      <ul class="tabs">
      @foreach($departments as $department)
     @if( $department->is_uhid_required == 1)
        <li class="tab"><a class="inactive" href="#department_{{$department->id}}">{{$department->name}} <sup class="startsub">*</sup></a></li>
      @else  
      <li class="tab"><a class="" href="#department_{{$department->id}}">{{$department->name}} </a></li>
        @endif
     @endforeach  
      </ul>
    </div>
    @foreach($departments as $department)
     @if( $department->is_uhid_required == 1)
    <div id="department_{{$department->id}}" class="col s12 animated zoomIn tabbox custompopup" style="display:none">
    <button class="tabbtn">&times;</button>
    <h1>{{$department->name}} *</h1>
    @foreach($activedoctors as $activedoctor)
    @if($department->id == $activedoctor->department_id)
    <a class="waves-effect waves-light btn modal-trigger ttabbox" href="#modal1_{{ $activedoctor->id }}">{{ $activedoctor->name }} <sup class="startsub">*</sup></a>
    @endif
    @endforeach
    </div>
    @else
    <div id="department_{{$department->id}}" class="col s12 animated zoomIn tabbox custompopup" style="display:none">
    <button class="tabbtn">&times;</button>
    <h1>{{$department->name}}</h1>
    @foreach($activedoctors as $activedoctor)
    @if($department->id == $activedoctor->department_id)
    <a class="waves-effect waves-light btn modal-trigger ttabbox" href="#modal1_{{ $activedoctor->id }}">{{ $activedoctor->name }}</a>
    @endif
    @endforeach
    </div>
    @endif
     @endforeach
  </div>

     <!-----End-Style-1---------> 
     @elseif($kiosksetting->dr_tokenstyle==2)    
     <!------start-Style-2-------->
         <div class="boxdept" id="token_section">
         @foreach($activedoctors as $activedoctor)
           @if( $activedoctor->department->is_uhid_required == 1)
     <a  style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger dphotobox" href="#modal1_{{ $activedoctor->id }}">
     <div class="doctorimgbox"> <span class="startsub">*</span>
     @if($activedoctor->photo !== NULL)<img src="{{url('public/doctorimg')}}/{{ $activedoctor->photo }}" alt="User Photo"> 
     @else <img src="{{url('public/doctorimg')}}/avatar.jpg" alt="Default Image" > @endif
         <h2>{{ $activedoctor->name }} </h2>
         <h3>{{ $activedoctor->profile }}</h3>
        </div>
       </a>
                @else
    <a  style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger dphotobox" href="#modal1_{{ $activedoctor->id }}">
    <div class="doctorimgbox">
    @if($activedoctor->photo !== NULL)<img src="{{url('public/doctorimg')}}/{{ $activedoctor->photo }}" alt="User Photo"> 
     @else <img src="{{url('public/doctorimg')}}/avatar.jpg" alt="Default Image" > @endif
         <h2>{{ substr($activedoctor->name, 0, 17) }} </h2>
         <h3>{{ substr($activedoctor->profile, 0, 16) }}</h3>
        </div>
         </a>
                @endif
           @endforeach
         </div> 
      <!------End-Style-2-------->
      @else @endif
      <!------------------------->

         </div>
        </div>
    <!------------->
    <!------------------------------------------>
 @foreach($activedoctors as $activedoctor)
<div id="modal1_{{ $activedoctor->id }}" class="modal">
<div class="modal-content">
<div class="customform">
<h4>{{ $activedoctor->name }}</h4>
<form id="dep_isuuetkn2_{{ $activedoctor->id }}" name="getValueform2_{{ $activedoctor->id }}" action="/" method="GET">
<input class="department_id_{{ $activedoctor->id }}" name="department_id" type="hidden" value="{{ $activedoctor->department_id }}" />

@if($activedoctor->department->is_uhid_required == 1)
<div class = "row" style="display:none;">
<div class="input-field col s12">      
      <label>Enter Valid UHID :</label>
       <input class="uhid_{{ $activedoctor->id }}" name="uhid" type="text" placeholder="UHID" value="" autofocus="autofocus" autocomplete="off" onkeyup="getPrioroty(this.value, {{ $activedoctor->id }});" />          
    </div>
      <div class="col s12">
         <ul>
         <li style="font-size:0.8rem">Priority Check : <span id="uhidlbl_{{ $activedoctor->id }}"></span></li>
         </ul>
          </div> 
          </div> 
 @endif 
 @if($kiosksetting->reg_required==1)
 <div class = "row">
<div class="input-field col s12">      
<div class="regboxx">
<span><input type="text" value="{{$activedoctor->department->regcode }}<?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
<span>
<label>Enter Your Number :</label>
<input autocomplete="off" class="registration_{{ $activedoctor->id }} regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistration(this.value, {{ $activedoctor->id }});" /></span> 
</div>         
</div>   
</div>@elseif($kiosksetting->reg_required==2)
    <input autocomplete="off" class="registration_{{ $activedoctor->id }} regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" onkeyup="getRegistrationInDoctor(this.value, {{ $activedoctor->id }});" /> @else
     @endif
<!----Name-Mobile-Email---------> 
<div class = "row">
<div class="col s4"><input class="pname_{{ $activedoctor->id }}" name="pname" type="text" placeholder="Patient Name" value="" autocomplete="off" /></div>
<div class="col s4"><input class="pmobile_{{ $activedoctor->id }}" name="pmobile" type="number" maxlength="10" placeholder="Patient Mobile No" value="" autocomplete="off" /> </div>
<div class="col s4"><input class="pemail_{{ $activedoctor->id }}" name="pemail" type="email" placeholder="Patient Email Address" value="" autocomplete="off" />  </div>
</div>
 <!------------------------------->
</form>
<div class="modal-footer">
<ul>

<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a></li>
<li> <button class="btn waves-effect waves-light csfloat subbutton1" onclick="queue_doctor({{ $activedoctor->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
</div>  
</div>
</div>
</div> 
  @endforeach     
<!--------=========End-Token-Doctor-Wise============-------------------------->

    <!---------------------------> 
         @elseif($kiosksetting->tokendisplay==1)
<!--------=========Start-Token-Department-Wise============-------------------------->
                <div class="boxdept" id="token_section">
     @foreach($departments as $department)
     @if( $department->is_uhid_required == 1)
     <a  style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_{{ $department->id }}">
     @if($kiosksetting->deptflag==1) {{ $department->name }} <sup class="startsub">*</sup>
     @elseif($kiosksetting->deptflag==2) {{ $department->olangname }} <sup class="startsub">*</sup>
     @elseif($kiosksetting->deptflag==3)
     <div class="depdisplay"><sup>*</sup><span>{{ $department->name }}</span><span>( {{ $department->olangname }} )</span></div>
    @endif
    </a>
     @else
     <a  style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_{{ $department->id }}">
     @if($kiosksetting->deptflag==1) {{ $department->name }}
     @elseif($kiosksetting->deptflag==2) {{ $department->olangname }}
     @elseif($kiosksetting->deptflag==3)
     <div class="depdisplay"><span>{{ $department->name }}</span><span>( {{ $department->olangname }} )</span></div>
    @endif
    </a>
     @endif
     @endforeach
                 </div>
                </div>
                </div>
<!------------------------------------------>
 @foreach($departments as $department)
<div id="modal2_{{ $department->id }}" class="modal">
<div class="modal-content">
<div class="customform">
<h4>{{ $department->name }}</h4>
<form id="dep_isuuetkn2_{{ $department->id }}" name="getValueform2_{{ $department->id }}" action="/" method="GET">

@if( $department->is_uhid_required == 1)
<div class = "row">
<div class="input-field col s12">      
      <label>Enter Valid UHID :</label>
       <input class="uhid_{{ $department->id }}" name="uhid" type="text" placeholder="UHID" value="" autofocus="autofocus" autocomplete="off" onkeyup="getPrioroty(this.value, {{ $department->id }});" />          
    </div>
      <div class="col s12">
         <ul>
         <li style="font-size:0.8rem">Priority Check : <span id="uhidlbl_{{ $department->id }}"></span></li>
         </ul>
          </div> 
          </div> 
 @endif 
 @if($kiosksetting->reg_required==1)
 <div class = "row">
<div class="input-field col s12">      
<div class="regboxx">
<span><input type="text" value="{{ $department->regcode }}<?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
<span>
<label>Enter Your Number :</label>
<input autocomplete="off" class="registration_{{ $department->id }} regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistration(this.value, {{ $department->id }});" /></span> 
</div>         
</div> 
</div>@elseif($kiosksetting->reg_required==2)
    <input autocomplete="off" class="registration_{{ $department->id }} regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" onkeyup="getRegistrationInDoctor(this.value, {{ $department->id }});" /> @else
     @endif
<!----Name-Mobile-Email---------> 
<div class = "row">
<div class="col s4"><input class="pname_{{ $department->id }}" name="pname" type="text" placeholder="Patient Name" value="" autocomplete="off" /></div>
<div class="col s4"><input class="pmobile_{{ $department->id }}" name="pmobile" type="text" placeholder="Patient Mobile No" maxlength="10" value="" autocomplete="off" />  </div>
<div class="col s4"><input class="pemail_{{ $department->id }}" name="pemail" type="text" placeholder="Patient Email Address" value="" autocomplete="off" />  </div>
</div>
<!------------------------------->
</form>
<div class="modal-footer">
<ul>

<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a></li>
<li> <button class="btn waves-effect waves-light csfloat subbutton1" onclick="queue_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
</div>  
</div>
</div>
</div> 
  @endforeach
<!--------=========End-Token-Department-Wise============-------------------------->
@else
@endif
     <!--------------------->   
     </div>
     
        </div>
    </div>
@endsection



@section('print')

@if($kiosksetting->tokendisplay==1)

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
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="{{url('public/logo')}}/{{ $settings->logo }}" alt="logo"> {{str_limit( $settings->name)}}</span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}  <sup>{{ session()->get('review') }}</sup></span>

   @if($kiosksetting->reg_required==1)
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>@endif
  </td></tr>
   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('patient_name') }}</td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('department_name') }}</td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total')-1 }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Token slip created by (टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td> <td style="padding:4px; border:1px solid #ccc;"> <strong>Self (KIOSK)</strong></td></tr>

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
@elseif($kiosksetting->tokendisplay==2)
<!------===========================------------------------->

@if(session()->has('user_name'))
    <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="{{url('public/logo')}}/{{ $settings->logo }}" alt="logo"> {{str_limit( $settings->name)}}</span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}  <sup>{{ session()->get('review') }}</sup></span>
 
   @if($kiosksetting->reg_required==1)
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>@endif

  </td></tr>


   <tr><td colspan="2" style="padding:0px 3px; font-size:10px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Doctor Name (डॉक्टर नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('user_name') }}</td> </tr>
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Room No. (कमरा संख्या) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('room_number') }}</td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;">{{ session()->get('department_name') }}</td> </tr>

  
   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ session()->get('patient_name') }}</td> </tr>
  

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;">{{ session()->get('total')-1 }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> {{ \Carbon\Carbon::now()->format('d-m-Y') }}</td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;">{{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> </tr>
   
    </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:3px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 0px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
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


@endsection

@section('script')
<!---<script src="{{ url('assets/js/click_security.js') }}" type="text/javascript" ></script>--->
<script type="text/javascript">
//---------------------------------

//-----------------------


//-----------------------------------   
</script>

    <script type="text/javascript">
        $(function() {
            $('#main').css({'min-height': $(window).height()-134+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-134+'px'});
        });


        function queue_dept(value) {
           // $('body').removeClass('loaded');
		   var uhid = $('.uhid_'+value).val();
           var registration = $('.registration_'+value).val();
           var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pemail = $('.pemail_'+value).val();
            var revflag = $('.revflag_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
		//alert(registration+'---'+user_id+'----'+uhid + '---' + priority); return false;
            var myForm1 = '<form id="hidfrm1" action="{{ route('post_add_to_queue') }}" method="post">{{ csrf_field() }}<input type="hidden" name="department" value="'+value+'">'+'<input type="text" name="revflag" value="'+ revflag +'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+'<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm1);
            myForm1 = $('#hidfrm1');
            myForm1.submit();
        }

        function queue_doctor(value) {
		   var uhid = $('.uhid_'+value).val();
           var department_id = $('.department_id_'+value).val();
           var registration = $('.registration_'+value).val();
           var pname = $('.pname_'+value).val();
           var pmobile = $('.pmobile_'+value).val();
           var pemail = $('.pemail_'+value).val();
           var revflag = $('.revflag_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
		//alert(registration+'---'+user_id+'----'+uhid + '---' + priority); return false;
            var myForm2 = '<form id="hidfrm2" action="{{ route('post_add_to_queue_kiosk') }}" method="post">{{ csrf_field() }}<input type="hidden" name="user" value="'+value+'">'+'<input type="text" name="revflag" value="'+ revflag +'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'<input type="text" name="department_id" value="'+ department_id +'">'+'</form>';
            $('body').append(myForm2);
            myForm2 = $('#hidfrm2');
            myForm2.submit();
        }



        function refreshtoken()
        {
            var data = 'type=refresh&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                data:data,
                url:"{{ route('refresh_token') }}",
                success: function(result) {
					$('#token_section').html(result);
				}
            });
        }

        window.setInterval(function() {			
           // refreshtoken();
           window.location.reload();
        }, 300000);

//----------------------------

     //--------------------------------------
     var timer = '';
		function getRegistration(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'registration='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"POST",
						url:"{{ route('post_registration') }}",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#registlbl_'+id).html('Validating...');	
						},
						success: function(result) {							
							$('#registlbl_'+id).html(result);												
						}
					});
			}, 1000);
		}
   
   //--------------------------------------
var timer = '';
		function getPrioroty(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'uid='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"POST",
						url:"{{ route('post_uhid') }}",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#uhidlbl_'+id).html('Validating...');	
						},
						success: function(result) {							
							$('#uhidlbl_'+id).html(result);												
						}
					});
			}, 1000);
		}  

        //-------------Patient-Review----------------------------------
     var timervd = '';
		function getReviewDoctor(val)
		{  
			clearTimeout(timervd);
			timervd = setTimeout(function() {
                    //var regt = $('.registration_'+value).val();
					var data = 'call_id='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"GET",
						url:"{{ route('post_reviewdoctorqueue') }}",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#revdoctor').html('<span class="notfbox revnoty">Your Record Not Found</span>');	
						},
						success: function(result) {							
							$('#revdoctor').html(result);												
						}
					});
			}, 1000);
		}   

        var timervp = '';
		function getReviewDepartment(val)
		{  
			clearTimeout(timervp);
			timervp = setTimeout(function() {
                    //var regt = $('.registration_'+value).val();
					var data = 'call_id='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"GET",
						url:"{{ route('post_reviewdepartmentqueue') }}",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#revdepartment').html('<span class="notfbox revnoty">Your Record Not Found</span>');	
						},
						success: function(result) {							
							$('#revdepartment').html(result);												
						}
					});
			}, 100);
		}         
     

//-------------------------------------------
$('.tabbtn').click(function(){
$('.tabbox').css('display','none');
});

$(document).ready(function(){

    $('.subbutton').attr('disabled',false);
    $('.regvalues').keyup(function(){
        if($(this).val().length !=0 && $(this).val().length >=5 && $(this).val().length < 6 ){
            $('.subbutton').attr('disabled',false);
        }else{
            $('.subbutton').attr('disabled',true);
        }
    })


   
     
});



//------------------------------------------

//----------------------------------------        
     
    </script>
@endsection
