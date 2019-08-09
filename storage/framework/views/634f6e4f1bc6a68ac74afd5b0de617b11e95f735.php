<?php $__env->startSection('title', trans('messages.mainapp.menu.call')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.token_modification')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.token_modification')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
            <div class="col s12 m12">
                <div class="card">
                    <div class="card-content" style="font-size:14px">
                        <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.todays_queue')); ?></span>
                        <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
            <!---------------Start-Department-wise----------------------------->            
                 <?php if($kiosksetting->tokendisplay==1): ?>
                    <table id="token_detail" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Token</th>
                                <th>Patient Name</th>
                                <th>Sub Department</th>
                 <?php if($kiosksetting->reg_required==1): ?> <th>Registration No.</th> <?php endif; ?>
                                <th>Priority</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tokendetailbeforecall; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tokendept): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr>
                           <td> <?php echo e($loop->iteration); ?> </td>
                           <td><?php echo e($tokendept->number); ?></td>
                           <td><?php if($tokendept->pname !== NULL): ?><?php echo e($tokendept->pname); ?> <?php else: ?> No Name <?php endif; ?></td>
                           <td><?php echo e($tokendept->department->name); ?></td>
                           
                 <?php if($kiosksetting->reg_required==1): ?> <td><?php echo e($tokendept->regnumber); ?></td> <?php endif; ?>
                          
                           <td>
                            <?php if($tokendept->priority==1): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="plbox">Platinum</span> 
                            <?php elseif($tokendept->priority==2): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="glbox">Gold</span>
                            <?php elseif($tokendept->priority==3): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="slbox">Silver</span> 
                            <?php elseif($tokendept->priority==4): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="nlbox">Normal</span> 
                            <?php else: ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="nlbox">Normal</span>   
                            <?php endif; ?>  
                         

                           </td>
                           <td>
                           <a style="font-size:10px; padding:5px 10px; line-height:inherit; height:auto;" class="waves-effect waves-light btn modal-trigger" href="#modal1_<?php echo e($tokendept->id); ?>">MODIFY</a>

                           <a style="font-size:10px; margin:0px 4px; padding:5px 10px; line-height:inherit; height:auto;" href="<?php echo e(url('/calls/rePrintToken')); ?>/<?php echo e($tokendept->id); ?>" class="waves-effect waves-light btn green" >Reprint</a>

                      <!--------------------->
      <!------popup-start---------->     
     <div id="modal1_<?php echo e($tokendept->id); ?>" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4>TOKEN NUMBER : <?php echo e($tokendept->number); ?></h4>
     <form id="dep_isuuetkn_<?php echo e($tokendept->id); ?>" name="getValueform_<?php echo e($tokendept->id); ?>" action="/" method="GET">
         <input type="hidden" class="id_<?php echo e($tokendept->id); ?>" value="<?php echo e($tokendept->id); ?>" name="id" >
         <input type="hidden" class="department_id_<?php echo e($tokendept->id); ?>" value="<?php echo e($tokendept->department_id); ?>" name="department_id" >
         <?php if($tokendept->department->is_uhid_required == 1): ?>   
    <div class = "row">
    <div class="input-field col s12">      
      <label>Enter UHID :</label>
       <input class="uhid_<?php echo e($tokendept->id); ?>" name="uhid" type="text" placeholder="UHID" value="<?php echo e($tokendept->uhid); ?>" autocomplete="off" onkeyup="getPrioroty(this.value, <?php echo e($tokendept->id); ?>);" />          
    </div>
               
         <div class="col s12">
         <ul>
         <li style="font-size:0.8rem">Priority : <span id="uhidlbl_<?php echo e($tokendept->id); ?>"></span></li>
         </ul>
          </div>      
       </div> <?php endif; ?>
        <!----Name-Mobile-Email---------> 
        <div class = "row">
        <div class="col s4"><input class="pname_<?php echo e($tokendept->id); ?>" name="pname" type="text" placeholder="Patient Name" value="<?php echo e($tokendept->pname); ?>" autocomplete="off" /></div>
        <div class="col s4"><input class="pmobile_<?php echo e($tokendept->id); ?>" name="pmobile" type="text" placeholder="Patient Mobile No" value="<?php echo e($tokendept->pmobile); ?>" autocomplete="off" />  </div>
        <div class="col s4"><input class="pemail_<?php echo e($tokendept->id); ?>" name="pemail" type="text" placeholder="Patient Email Address" value="<?php echo e($tokendept->pemail); ?>" autocomplete="off" />  </div>
        </div>
        <!------------------------------->

       </form>
       <div class="modal-footer">
         <ul>
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">Cancel</a></li>
<li class="reloadclick">  <button class="btn waves-effect waves-light csfloat" onclick="call_deptdepartment(<?php echo e($tokendept->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 

                      <!---------------------->
                           </td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                         </tbody>
                        </table>
<!-------------End-Department-wise----------------------->
 <?php elseif($kiosksetting->tokendisplay==2): ?>
<!------------Start-Doctor-Wise-------------------------->

<table id="token_detail" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Token</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Room No.</th>
             <?php if($kiosksetting->reg_required==1): ?> <th>Registration No.</th> <?php endif; ?>
                                <th>Sub Department</th>
                                <th>Priority</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tokendetailbeforecalldoctor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tokendetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr>
                           <td> <?php echo e($loop->iteration); ?> </td>
                           <td><?php echo e($tokendetail->number); ?></td>
                           <td><?php if($tokendetail->pname !== NULL): ?><?php echo e($tokendetail->pname); ?> <?php else: ?> No Name <?php endif; ?></td>
                           <td><?php if($tokendetail->user_id !== NULL): ?><?php echo e($tokendetail->user->name); ?> <?php else: ?> Department wise called <?php endif; ?></td>
                           <td><?php if($tokendetail->counter_id !== NULL): ?><?php echo e($tokendetail->counter->name); ?> <?php else: ?> Department wise called <?php endif; ?></td>
             <?php if($kiosksetting->reg_required==1): ?><td><?php echo e($tokendetail->regnumber); ?></td> <?php endif; ?>
                           <td><?php echo e($tokendetail->department->name); ?></td>
                           <td>
                            <?php if($tokendetail->priority==1): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="plbox">Platinum</span> 
                            <?php elseif($tokendetail->priority==2): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="glbox">Gold</span>
                            <?php elseif($tokendetail->priority==3): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="slbox">Silver</span> 
                            <?php elseif($tokendetail->priority==4): ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="nlbox">Normal</span> 
                            <?php else: ?> <span style="font-size:10px; text-transform:uppercase; padding:4px 10px; line-height:inherit; height:auto; width:50px; text-align:center;" class="nlbox">Normal</span>   
                            <?php endif; ?>  
                           </td>
                           <td>

                           <a style="font-size:10px; padding:5px 10px; line-height:inherit; height:auto;" class="waves-effect waves-light btn modal-trigger" href="#modal2_<?php echo e($tokendetail->id); ?>">MODIFY</a>

                           <a style="font-size:10px; margin:0px 4px; padding:5px 10px; line-height:inherit; height:auto;" href="<?php echo e(url('/calls/rePrintTokenDoctor')); ?>/<?php echo e($tokendetail->id); ?>" class="waves-effect waves-light btn green" >Reprint</a>

                      <!--------------------->
      <!------popup-start---------->     
     <div id="modal2_<?php echo e($tokendetail->id); ?>" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4>TOKEN NUMBER : <?php echo e($tokendetail->number); ?></h4>
     <form id="dep_isuuetkn_<?php echo e($tokendetail->id); ?>" name="getValueform_<?php echo e($tokendetail->id); ?>" action="/" method="GET">
         <input type="hidden" class="id_<?php echo e($tokendetail->id); ?>" value="<?php echo e($tokendetail->id); ?>" name="id" >
         <input type="hidden" class="department_id_<?php echo e($tokendetail->id); ?>" value="<?php echo e($tokendetail->department_id); ?>" name="department_id" >
         <?php if($tokendetail->department->is_uhid_required == 1): ?> 
    <div class = "row">
    <div class="input-field col s12">      
      <label>Enter UHID :</label>
       <input class="uhid_<?php echo e($tokendetail->id); ?>" name="uhid" type="text" placeholder="UHID" value="<?php echo e($tokendetail->uhid); ?>" autocomplete="off" onkeyup="getPrioroty(this.value, <?php echo e($tokendetail->id); ?>);" />          
    </div>
               
         <div class="col s12">
         <ul>
         <li style="font-size:0.8rem">Priority : <span id="uhidlbl_<?php echo e($tokendetail->id); ?>"></span></li>
         </ul>
          </div>      
       </div> <?php endif; ?>

        <!----Name-Mobile-Email---------> 
        <div class = "row">
        <div class="col s4"><input class="pname_<?php echo e($tokendetail->id); ?>" name="pname" type="text" placeholder="Patient Name" value="<?php echo e($tokendetail->pname); ?>" autocomplete="off" /></div>
        <div class="col s4"><input class="pmobile_<?php echo e($tokendetail->id); ?>" name="pmobile" type="text" placeholder="Patient Mobile No" value="<?php echo e($tokendetail->pmobile); ?>" autocomplete="off" />  </div>
        <div class="col s4"><input class="pemail_<?php echo e($tokendetail->id); ?>" name="pemail" type="text" placeholder="Patient Email Address" value="<?php echo e($tokendetail->pemail); ?>" autocomplete="off" />  </div>
        </div>
        <!------------------------------->

       </form>
       <div class="modal-footer">
         <ul>
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">Cancel</a></li>
<li class="reloadclick">  <button class="btn waves-effect waves-light csfloat" onclick="call_dept(<?php echo e($tokendetail->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 

                      <!---------------------->
                           </td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                         </tbody>
                        </table>


    <!----------------------------------->
             <?php else: ?>  <?php endif; ?>
<!------------End-Doctor-Wise----------------------------->
                    </div>
                </div>
            </div>
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
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?></span>

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
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?></span>

   <?php if($kiosksetting->reg_required==1): ?>
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : <?php echo e(session()->get('registration_no')); ?></span><?php endif; ?>
  </td></tr>


   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('patient_name')); ?></td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Doctor Name (डॉक्टर नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('user_name')); ?></td> </tr>
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Room No. (कमरा संख्या) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('room_number')); ?></td> </tr>
   
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('deptname')); ?></td> </tr>

    <?php if(session()->get('uhid') != ''): ?>
   <tr> <td style="padding:4px; border:1px solid #ccc;">UHID No. (यूएचआईडी संख्या) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('uhid')); ?></td> </tr>
   <?php else: ?>  <?php endif; ?>

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
            var id = $('.id_'+value).val();
            var department_id = $('.department_id_'+value).val();
			var uhid = $('.uhid_'+value).val();
            var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pemail = $('.pemail_'+value).val();
			//alert(uhid +'--'+ department_id + '---' + id); return false;
			var myForm1 = '<form id="hidfrm1" action="<?php echo e(url('calls/modify')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
            '<input type="text" name="id" value="'+ id +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+
            '<input type="text" name="department_id" value="'+ department_id +'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'</form>';
            $('body').append(myForm1);
			
            myForm1 = $('#hidfrm1');
            myForm1.submit();
            //-------------------
        }

        function call_deptdepartment(value) {
            var id = $('.id_'+value).val();
            var department_id = $('.department_id_'+value).val();
			var uhid = $('.uhid_'+value).val();
            var pname = $('.pname_'+value).val();
            var pmobile = $('.pmobile_'+value).val();
            var pemail = $('.pemail_'+value).val();
			//alert(uhid +'--'+ department_id + '---' + id); return false;
			var myForm5 = '<form id="hidfrm5" action="<?php echo e(url('calls/modifydepartmet')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
            '<input type="text" name="id" value="'+ id +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+
            '<input type="text" name="department_id" value="'+ department_id +'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'</form>';
            $('body').append(myForm5);
			
            myForm5 = $('#hidfrm5');
            myForm5.submit();
            //-------------------
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

    //--------------------------------------------

            $('#token_detail').DataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
               "bInfo": false,
               "bAutoWidth": false
                
            });    

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
   

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>