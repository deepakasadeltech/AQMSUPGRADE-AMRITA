<?php $__env->startSection('title', trans('messages.mainapp.menu.call')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">

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
                <ul><li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a></li>
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
                <ul><li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a></li>
                </ul>
                </div> 

                </div>
                </div>
                </div>
             <!----End-old-patient-review-department-wise----> 
           </div></div>

          
          <!--------------------------------> 
            <div class="row">
            <div class="col s12 m12 l12">
            <div class="popupmain">
            <?php if(session()->has('department_name')): ?> 
            <div class="popuptoken"> 
            <div class="tknpopupbox">
            <?php echo e(trans('messages.users.token_number')); ?> : <?php echo e(session()->get('number')); ?>  ( <?php echo e(session()->get('registration_no')); ?> )
            </div>
            <div>
            <?php endif; ?>
            <?php if(session()->has('user_name')): ?> 
            <div class="popuptoken"> 
            <div class="tknpopupbox">
           <?php echo e(trans('messages.users.token_number')); ?> : <?php echo e(session()->get('number')); ?>  
            </div>
            <div>
            <?php endif; ?>
            </div>
            </div> </div>
        <!--------------------------------> 

            <div class="row">
                <div class="col s12 m12 l12">
             <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.token_issue')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.token_issue')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col s12 m6">
                <div class="card" style="overflow:inherit;">
                    <div class="card-content">

               <!-----start-Old-Patient------->        
                    <div class="oldpatientsection callold">
                <?php if($kiosksetting->tokendisplay==2): ?>     
                <a class="btnreview modal-trigger" href="#old_patient_doctor">OLD PATIENT</a>
                <?php else: ?> 
                <a class="btnreview modal-trigger" href="#old_patient_department">OLD PATIENT</a> 
                <?php endif; ?>
                </div>
               <!-----End-Old-Patient---------->

     
                        
         <!----start-sms-on-mobile-------->
         <?php
        /* if(session()->has('department_name')){    //department wise activedted
          require_once(base_path('assets/Sms/textlocal.class.php'));
          require_once(base_path('assets/Sms/credential.php'));

         if(session()->get('patient_mobile') !== NULL) {
         $token = 'Token No. : '.session()->get('number');
         $department = 'Department : '.session()->get('department_name'); 
         $company = $settings->name;
         $textlocal = new Textlocal(false, false, API_KEY);
         $numbers = array(session()->get('patient_mobile'));
         $sender = 'ASADEL';
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
           // die('SMS API Error: ' . $e->getMessage());
        }
    }


          } */ 
           ?>
          
    <!----End-sms-on-mobile-------->      

         <!----------Start-Token-Issue-By-Admin-and-User-------------->     
    
         <?php if($kiosksetting->tokendisplay==2): ?> 
         <!-----start-Style-1---------> 
     <?php if($kiosksetting->dr_tokenstyle==1): ?> 
     <div class="row queuetokenbox calltab">
    <div class="col s12 padtop">
      <ul class="tabs">
      <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
     <?php if( $department->is_uhid_required == 1): ?>
        <li class="tab"><a class="inactive" href="#department_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> <sup class="startsub">*</sup></a></li>
      <?php else: ?>  
      <li class="tab"><a class="" href="#department_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> </a></li>
        <?php endif; ?>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>  
      </ul>
    </div>
    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
     <?php if( $department->is_uhid_required == 1): ?>
    <div id="department_<?php echo e($department->id); ?>" class="col s12 animated zoomIn tabbox custompopup callpopup">
    <button class="tabbtn">&times;</button>
    <h1><?php echo e($department->name); ?> *</h1>
    <?php $__currentLoopData = $activedoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activedoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
    <?php if($department->id == $activedoctor->department_id): ?>
    <a class="waves-effect waves-light btn modal-trigger ttabbox" href="#modal1_<?php echo e($activedoctor->id); ?>"><?php echo e($activedoctor->name); ?> <sup class="startsub">*</sup></a>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </div>
    <?php else: ?>
    <div id="department_<?php echo e($department->id); ?>" class="col s12 animated zoomIn tabbox custompopup callpopup">
    <button class="tabbtn">&times;</button>
    <h1><?php echo e($department->name); ?></h1>
    <?php $__currentLoopData = $activedoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activedoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
    <?php if($department->id == $activedoctor->department_id): ?>
    <a class="waves-effect waves-light btn modal-trigger ttabbox" href="#modal1_<?php echo e($activedoctor->id); ?>"><?php echo e($activedoctor->name); ?></a>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    </div>
    <?php endif; ?>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
 

     <!-----End-Style-1---------> 
     <?php elseif($kiosksetting->dr_tokenstyle==2): ?>    
     <!------start-Style-2-------->
         <?php $__currentLoopData = $activedoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activedoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
           <?php if( $activedoctor->department->is_uhid_required == 1): ?>
     <a class="modal-trigger drtokenname dphotobox" href="#modal1_<?php echo e($activedoctor->id); ?>">
     <div class="doctorimgbox"> <span class="startsub">*</span>
     <?php if($activedoctor->photo !== NULL): ?><img src="<?php echo e(url('public/doctorimg')); ?>/<?php echo e($activedoctor->photo); ?>" alt="User Photo"> 
     <?php else: ?> <img src="<?php echo e(url('public/doctorimg')); ?>/avatar.jpg" alt="Default Image" > <?php endif; ?>
         <h2><?php echo e($activedoctor->name); ?> </h2>
         <h3><?php echo e($activedoctor->profile); ?></h3>
        </div>
     </a>
                <?php else: ?>
    <a class="modal-trigger drtokenname dphotobox" href="#modal1_<?php echo e($activedoctor->id); ?>">

     <div class="doctorimgbox">
     <?php if($activedoctor->photo !== NULL): ?><img src="<?php echo e(url('public/doctorimg')); ?>/<?php echo e($activedoctor->photo); ?>" alt="User Photo"> 
     <?php else: ?> <img src="<?php echo e(url('public/doctorimg')); ?>/avatar.jpg" alt="Default Image" > <?php endif; ?>
         <h2><?php echo e($activedoctor->name); ?> </h2>
         <h3><?php echo e($activedoctor->profile); ?></h3>
        </div> 
    
    </a>
                <?php endif; ?>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
       <!------End-Style-2-------->
       <?php else: ?> <?php endif; ?>
      <!------------------------->

         <!------------------------------------------>
                <?php $__currentLoopData = $activedoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activedoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <div id="modal1_<?php echo e($activedoctor->id); ?>" class="modal">
                <div class="modal-content">
                <div class="customform">
                <h4><?php echo e($activedoctor->name); ?></h4>
                <form id="dep_isuuetkn2_<?php echo e($activedoctor->id); ?>" name="getValueform2_<?php echo e($activedoctor->id); ?>" action="/" method="GET">
                <input class="department_id_<?php echo e($activedoctor->id); ?>" name="department_id" type="hidden" value="<?php echo e($activedoctor->department_id); ?>" />

                <?php if($activedoctor->department->is_uhid_required == 1): ?>
                <div class = "row" >
                <div class="input-field col s12">      
                    <label>Enter Valid UHID :</label>
                    <input class="uhid_<?php echo e($activedoctor->id); ?>" name="uhid" type="text" placeholder="UHID" value="" autofocus="autofocus" autocomplete="off" onkeyup="getPrioroty(this.value, <?php echo e($activedoctor->id); ?>);" />          
                </div>
                    <div class="col s12">
                        <ul>
                        <li style="font-size:0.8rem">Priority Check : <span id="uhidlbl_<?php echo e($activedoctor->id); ?>"></span></li>
                        </ul>
                        </div> 
                        </div> 
                <?php endif; ?> 
                <?php if($kiosksetting->reg_required==1): ?>
                <div class = "row">
                <div class="input-field col s12">      
                <div class="regboxx">
                <span><input type="text" value="<?php echo e($activedoctor->department->regcode); ?><?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
                <span>
                <label>Enter Your Number :</label>
                <input autocomplete="off" class="registration_<?php echo e($activedoctor->id); ?> regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistrationInDoctor(this.value, <?php echo e($activedoctor->id); ?>);" /></span> 
                </div>         
                </div> 
            <!-------check-reg-validation------------->
             <div class="col s12 checkregistd"> 
             <ul> <li class="validregbox" style="font-size:0.8rem" id="registindoctor_<?php echo e($activedoctor->id); ?>"></li> </ul>
           </div>
             <!---------------------------------------->
                </div><?php elseif($kiosksetting->reg_required==2): ?>
                <input autocomplete="off" class="registration_<?php echo e($activedoctor->id); ?> regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" onkeyup="getRegistrationInDoctor(this.value, <?php echo e($activedoctor->id); ?>);" /> <?php else: ?>
                 <?php endif; ?>

             <!----Name-Mobile-Email---------> 
                <div class = "row">
                <div class="col s4"><input class="pname_<?php echo e($activedoctor->id); ?>" name="pname" type="text" placeholder="Patient Name" value="" autocomplete="off" /></div>
                <div class="col s4"><input class="pmobile_<?php echo e($activedoctor->id); ?>" name="pmobile" type="text" placeholder="Patient Mobile No" value="" autocomplete="off" />  </div>
                <div class="col s4"><input class="pemail_<?php echo e($activedoctor->id); ?>" name="pemail" type="text" placeholder="Patient Email Address" value="" autocomplete="off" />  </div>
                </div>
             <!------------------------------->
                </form>
                <div class="modal-footer">
                <ul>

                <li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a></li>
                <li> <button class="btn waves-effect waves-light csfloat subbutton" onclick="queue_doctor(<?php echo e($activedoctor->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
                </button></li>
                </ul>
                </div>  
                </div>
                </div>
                </div> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>     
<!--------=========End-Token-Doctor-Wise============-------------------------->

<!---------------------------> 
               <?php elseif($kiosksetting->tokendisplay==1): ?>
<!--------=========Start-Token-Department-Wise============-------------------------->
                <div class="boxdept callsection">
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <?php if( $department->is_uhid_required == 1): ?>
                <a  class="waves-effect waves-light btn modal-trigger deptokenname" href="#modal2_<?php echo e($department->id); ?>">
                <?php if($kiosksetting->deptflag==1): ?> <?php echo e($department->name); ?> <span class="startsub">*</span>
                <?php elseif($kiosksetting->deptflag==2): ?> <?php echo e($department->olangname); ?> <span class="startsub">*</span>
                <?php elseif($kiosksetting->deptflag==3): ?>
                <div class="depdisplay depcall"><sup>*</sup><span><?php echo e($department->name); ?></span><span>( <?php echo e($department->olangname); ?> )</span></div>
                <?php endif; ?>
                </a>
                <?php else: ?>
                <a  class="waves-effect waves-light btn modal-trigger deptokenname" href="#modal2_<?php echo e($department->id); ?>">
                <?php if($kiosksetting->deptflag==1): ?> <?php echo e($department->name); ?>

                <?php elseif($kiosksetting->deptflag==2): ?> <?php echo e($department->olangname); ?>

                <?php elseif($kiosksetting->deptflag==3): ?>
                <div class="depdisplay depcall"><span><?php echo e($department->name); ?></span><span>( <?php echo e($department->olangname); ?> )</span></div>
                <?php endif; ?>
                </a>
                <?php endif; ?>
              
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </div>
                <!------------------------------------------>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <div id="modal2_<?php echo e($department->id); ?>" class="modal">
                <div class="modal-content">
                <div class="customform">
                <h4><?php echo e($department->name); ?></h4>
                <form id="dep_isuuetkn2_<?php echo e($department->id); ?>" name="getValueform2_<?php echo e($department->id); ?>" action="/" method="GET">

                <?php if( $department->is_uhid_required == 1): ?>
                <div class = "row">
                <div class="input-field col s12">      
                <label>Enter Valid UHID :</label>
                <input class="uhid_<?php echo e($department->id); ?>" name="uhid" type="text" placeholder="UHID" value="" autofocus="autofocus" autocomplete="off" onkeyup="getPrioroty(this.value, <?php echo e($department->id); ?>);" />          
                </div>
                <div class="col s12">
                <ul>
                <li style="font-size:0.8rem">Priority Check : <span id="uhidlbl_<?php echo e($department->id); ?>"></span></li>
                </ul>
                </div> 
                </div> 
                <?php endif; ?> 

                <?php if($kiosksetting->reg_required==1): ?>
                <div class = "row">
                <div class="input-field col s12">      
                <div class="regboxx">
                <span><input type="text" value="<?php echo e($department->regcode); ?><?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
                <span>
                <label>Enter Your Number :</label>
                <input autocomplete="off" class="registration_<?php echo e($department->id); ?> regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistration(this.value, <?php echo e($department->id); ?>);" /></span> 
                </div>         
                </div>
             <!-------check-reg-validation------------->
             <div class="col s12 checkregistd"> 
             <ul> <li class="validregbox" style="font-size:0.8rem" id="registlbl_<?php echo e($department->id); ?>"></li> </ul>
           </div>
             <!---------------------------------------->
                </div><?php elseif($kiosksetting->reg_required==2): ?>
                <input autocomplete="off" class="registration_<?php echo e($department->id); ?> regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" onkeyup="getRegistrationInDoctor(this.value, <?php echo e($department->id); ?>);" /> <?php else: ?>
                 <?php endif; ?>
                 
                 <!----Name-Mobile-Email---------> 
                 <div class = "row">
                <div class="col s4"><input class="pname_<?php echo e($department->id); ?>" name="pname" type="text" placeholder="Patient Name" value="" autocomplete="off" /></div>
                <div class="col s4"><input class="pmobile_<?php echo e($department->id); ?>" name="pmobile" type="text" placeholder="Patient Mobile No" value="" autocomplete="off" />  </div>
                <div class="col s4"><input class="pemail_<?php echo e($department->id); ?>" name="pemail" type="text" placeholder="Patient Email Address" value="" autocomplete="off" />  </div>
                </div>
             <!------------------------------->
                </form>
                <div class="modal-footer">
                <ul>

                <li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a></li>
                <li> <button class="btn waves-effect waves-light csfloat subbutton" onclick="call_dept(<?php echo e($department->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
                </button></li>
                </ul>
                </div>  
                </div>
                </div>
                </div> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
              
<!--------=========End-Token-Department-Wise============-------------------------->
               <?php else: ?>
               <?php endif; ?>
     
     <!-----Div-adjustment----------------> 
     <?php if($kiosksetting->tokendisplay==2): ?> </div> <?php else: ?>  <?php endif; ?> 
     <?php if($kiosksetting->tokendisplay==1): ?> </div> <?php else: ?>  <?php endif; ?>
     <!---------------------> 
     <?php if($kiosksetting->dr_tokenstyle==2): ?> <?php else: ?> </div> <?php endif; ?> 
     <?php if($kiosksetting->dr_tokenstyle==1): ?>  <?php else: ?>  <?php endif; ?>         

  </div>
</div>

    
 <!----------End-Token-Issue-By-Admin--------------> 
 

                    

<!---------------Total-Token-Queue-today--------------->            
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content" style="font-size:14px">
                        <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.todays_queue')); ?></span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <table id="token-table" class="display" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Department</th>
                                    <th><?php echo e(trans('messages.call.number')); ?></th>
                                    <th>P. Name</th>
                                    <?php if($kiosksetting->reg_required==1): ?> <th>Registration No.</th> <?php endif; ?>
                                    <th>P. Type</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($kiosksetting->tokendisplay==1): ?>
                            <?php $__currentLoopData = $currenttokens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $token): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($token->department->name); ?></td>
                            <td><?php echo e($token->number); ?></td>
                            <td><?php if($token->pname !== NULL): ?><?php echo e($token->pname); ?> <?php else: ?> No Name <?php endif; ?></td>
                            <?php if($kiosksetting->reg_required==1): ?> <td><?php echo e($token->regnumber); ?></td><?php endif; ?>

                            <td style="font-size:11px;"><?php if($token->token_type == 'R'): ?> <a class="clr_yellow"> REVIEW </a>
                             <?php elseif($token->token_type == 'F'): ?> <a class="clr_red tooltipped" data-position="top" data-tooltip="Refer By : <?php echo e($token->refer_by); ?>">REFERRAL</a>
                              <?php else: ?> <a class="clr_green"> FIRST TIME </a> <?php endif; ?></td>
                            <td>
                            <button class="cssbtn" onclick="reprintDepartment(<?php echo e($token->id); ?>)">Reprint</button> 
                            </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                           
                            <?php elseif($kiosksetting->tokendisplay==2): ?>

                            <?php $__currentLoopData = $currenttokensdoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tokendoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($tokendoctor->department->name); ?></td>
                            <td><?php echo e($tokendoctor->number); ?></td>
                            <td><?php if($tokendoctor->pname !== NULL): ?><?php echo e($tokendoctor->pname); ?> <?php else: ?> No Name <?php endif; ?></td>
                            <?php if($kiosksetting->reg_required==1): ?> <td><?php echo e($tokendoctor->regnumber); ?></td><?php endif; ?>
                            <td> <button class="cssbtn" onclick="reprintDoctor(<?php echo e($tokendoctor->id); ?>)">Reprint</button>
                           </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                            <?php else: ?>
                            <tr><td colspan="5">No Data</td></tr>

                            <?php endif; ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<!-------------------------------------------->

        </div>
    </div>
<?php $__env->stopSection(); ?>



<!----------Start-print-section----------------------->

<?php $__env->startSection('print'); ?>

<?php if($kiosksetting->tokendisplay==1): ?>

    <?php if(session()->has('department_name')): ?>
    <style>#printarea{display:none;text-align:left}@media  print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
          <?php if(session()->get('uhid') != ''): ?>
			<span style="position:absolute; top:0px; right:0px; font-size:10px; color:black;">
               <?php if(session()->get('priority') == '1'): ?> P 
               <?php elseif(session()->get('priority') == '2'): ?> G
               <?php elseif(session()->get('priority') == '3'): ?> S 
               <?php elseif(session()->get('priority') == '4'): ?> N 
               <?php else: ?> N  <?php endif; ?>
             </span><?php else: ?>  <?php endif; ?>
   
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="<?php echo e(url('public/logo')); ?>/<?php echo e($settings->logo); ?>" alt="logo"> <?php echo e(str_limit( $company_name)); ?> </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?>  <sup><?php echo e(session()->get('review')); ?></sup></span>
   <?php if($kiosksetting->reg_required==1): ?>
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : <?php echo e(session()->get('registration_no')); ?></span><?php endif; ?>

  </td></tr>
   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('patient_name')); ?></td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('department_name')); ?></td> </tr>
    
   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;"><?php echo e(session()->get('total')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> <?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Token slip created by (टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td> <td style="padding:4px; border:1px solid #ccc;"> <strong><?php echo e(session()->get('staffname')); ?></strong></td></tr>

   </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:10px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>
<!--------------------->
        </div>
        <?php if(session()->get('printFlag')): ?>
			<script>
				window.onload = function(){window.print();}
			</script>
		<?php endif; ?>	
    <?php endif; ?>
<!----------------------------->
<?php elseif($kiosksetting->tokendisplay==2): ?>
<!------===========================------------------------->

<?php if(session()->has('user_name')): ?>
    <style>#printarea{display:none;text-align:left}@media  print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="<?php echo e(url('public/logo')); ?>/<?php echo e($settings->logo); ?>" alt="logo"> <?php echo e(str_limit( $company_name)); ?> </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?>  <sup><?php echo e(session()->get('review')); ?></sup></span>

   <?php if($kiosksetting->reg_required==1): ?>
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : <?php echo e(session()->get('registration_no')); ?></span><?php endif; ?>

  </td></tr>

   <tr><td colspan="2" style="padding:0px 3px; font-size:10px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Doctor Name (डॉक्टर नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('user_name')); ?></td> </tr>
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Room No. (कमरा संख्या) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('room_number')); ?></td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('doctor_department')); ?></td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('patient_name')); ?></td> </tr>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;"><?php echo e(session()->get('total')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> <?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Token slip created by (टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td> <td style="padding:4px; border:1px solid #ccc;"> <strong><?php echo e(session()->get('staffname')); ?></strong></td></tr>
  
   </table>
   </td></tr>
   
   <tr><td colspan="2" style="padding:3px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>
<!--------------------->
        </div>
        <?php if(session()->get('printFlag')): ?>
			<script>
				window.onload = function(){window.print();}
			</script>
		<?php endif; ?>	
    <?php endif; ?>
<!------------>
    <?php endif; ?>
<!-----============================------------------------>


<?php $__env->stopSection(); ?>

<!----------End-print-section----------------------->


<?php $__env->startSection('script'); ?>

    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    
    <script>
    //-------------------------------
        $("#new_call").validate({
            rules: {
                user: {
                    required: true,
                    digits: true
                },
                pid: {
                    required: true,
                    digits: true
                },
				department: {
                    required: true,
                    digits: true
                },
                counter: {
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

 //--------------------------
    

    //---------------------------

        function call_dept(value) {
            //$('body').removeClass('loaded');
			var uhid = $('.uhid_'+value).val();
            var registration = $('.registration_'+value).val();
            var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pemail = $('.pemail_'+value).val();
            var revflag = $('.revflag_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
			var myForm1 = '<form id="hidfrm1" action="<?php echo e(url('calls/dept')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="revflag" value="'+ revflag +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+'<input type="text" name="priority" value="'+ priority +'">'+'</form>';
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


        function queue_doctor(value) {
		   var uhid = $('.uhid_'+value).val();
           var department_id = $('.department_id_'+value).val();
           var registration = $('.registration_'+value).val();
           var pname = $('.pname_'+value).val();
           var pmobile = $('.pmobile_'+value).val();
           var pemail = $('.pemail_'+value).val();
           var revflag = $('.revflag_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
		//alert(pname+'---'+pmobile+'----'+pemail + '---' + priority); return false;
            var myForm2 = '<form id="hidfrm2" action="<?php echo e(route('post_add_to_queue_doctor')); ?>" method="post"><?php echo e(csrf_field()); ?><input type="hidden" name="user" value="'+value+'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="revflag" value="'+ revflag +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'<input type="text" name="department_id" value="'+ department_id +'">'+'</form>';
            $('body').append(myForm2);
            myForm2 = $('#hidfrm2');
            myForm2.submit();
        }
        

        function recall(call_id) {
            $('body').removeClass('loaded');
            var data = 'call_id='+call_id+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_recall')); ?>",
                data:data,
                cache:false,
                success: function(response) {
                    location.reload();
                }
            });
        }
          
        function reprintDepartment(value) {
            var myForm3 = '<form id="hidfrm3" action="<?php echo e(url('calls/reprintDepartment')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
            '<input type="text" name="id" value="'+ value +'">'+'</form>';
            $('body').append(myForm3);
			
            myForm3 = $('#hidfrm3');
            myForm3.submit();
        }

        function reprintDoctor(value) {
            var myForm4 = '<form id="hidfrm4" action="<?php echo e(url('calls/reprintDoctor')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
            '<input type="text" name="id" value="'+ value +'">'+'</form>';
            $('body').append(myForm4);
			
            myForm4 = $('#hidfrm4');
            myForm4.submit();
        }



		$('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Parent Department</option>";
			if($(this).val() == ''){
				$('#department').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_pdept')); ?>",
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

		
        $(function() {

             //----------------------------------    
        $('#token-table').dataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }],
                
            });

         //-------------------------------- 
            
            var calltable = $('#call-table').dataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }],
                "ajax": "<?php echo e(url('assets/files/call')); ?>",
                "columns": [
                    { "data": "id" },
                    { "data": "department" },
                    { "data": "number" },
                    { "data": "called" },
                    { "data": "counter" },
                    { "data": "recall" }
                ]
            });

            setInterval(function(){
                calltable.api().ajax.reload(null,false);
            }, 3000);
        });

    //-----------------------------------------------
     var timerg = '';
		function getRegistration(val, id)
		{  
			clearTimeout(timerg);
			timerg = setTimeout(function() {
                    //var regt = $('.registration_'+value).val();
					var data = 'registration='+val+'&department='+id+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"GET",
						url:"<?php echo e(route('post_registration')); ?>",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#registlbl_'+id).html('<span class="notfbox">Not Found, You Can Create</span>');	
						},
						success: function(result) {							
							$('#registlbl_'+id).html(result);												
						}
					});
			}, 1000);
		}
//-------------------------------------------------------------------
        var timerd = '';
		function getRegistrationInDoctor(val, id)
		{  
			clearTimeout(timerd);
			timerd = setTimeout(function() {
                    //var regt = $('.registration_'+value).val();
					var data = 'registration='+val+'&doctor='+id+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"GET",
						url:"<?php echo e(route('post_registrationindoctor')); ?>",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#registindoctor_'+id).html('<span class="notfbox">Not Found, You Can Create</span>');	
						},
						success: function(result) {							
							$('#registindoctor_'+id).html(result);												
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
					var data = 'uid='+val+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"POST",
						url:"<?php echo e(route('post_uhid')); ?>",
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
					var data = 'call_id='+val+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"GET",
						url:"<?php echo e(route('post_reviewdoctor')); ?>",
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
					var data = 'call_id='+val+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"GET",
						url:"<?php echo e(route('post_reviewdepartment')); ?>",
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
   

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>