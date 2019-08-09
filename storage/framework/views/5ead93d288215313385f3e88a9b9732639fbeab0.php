<?php $__env->startSection('title', trans('messages.mainapp.menu.reports.user_report')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/buttons.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.reports.user_report')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li><?php echo e(trans('messages.mainapp.menu.reports.reports')); ?></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.reports.user_report')); ?></li>
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
                        <div class="input-field col s12 m5">
                            <label for="user" class="active"><?php echo e(trans('messages.call.user')); ?></label>
                            <select id="user" class="browser-default">
                                <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.call.user')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if($cuser->id==$suser->id): ?>
                                        <option value="<?php echo e($cuser->id); ?>" selected><?php echo e($cuser->name); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo e($cuser->id); ?>"><?php echo e($cuser->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </select>
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="sdate"><?php echo e(trans('messages.starting')); ?> <?php echo e(trans('messages.date')); ?></label>
                            <input id="sdate" type="text" placeholder="dd-mm-yyyy" value="<?php echo e($sdate); ?>">
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="sdate"><?php echo e(trans('messages.ending')); ?> <?php echo e(trans('messages.date')); ?></label>
                            <input id="edate" type="text" placeholder="dd-mm-yyyy" value="<?php echo e($edate); ?>">
                        </div>
                        <div class="input-field col s12 m1">
                            <button id="gobtn" class="btn waves-effect waves-light right disabled" onclick="gobtn()"><?php echo e(trans('messages.go')); ?></button>
                        </div>
                    </div>
                </div>
                <!-----------Start-All-Key-deatils------------------>

                <div class="card-panel">
                <div class="row" style="text-align:center">

                <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.act')); ?> </p>
                                <h4 class="card-stats-number">
                                
                                <?php $total_end_date = '0'; $total_start_date = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient; $patientseens='0';  ?>
                                
                                <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                 
                                <?php if($call->doctor_work_end==1): ?>
                                <?php ( $total_end_date += strtotime($call->doctor_work_end_date) ); ?>
                                <?php ( $total_start_date += strtotime($call->doctor_work_start_date)); ?>
                                <?php ( $patientseens += count($call->number)); ?>
                               <?php endif; ?>     
                             
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 
                                
                              <?php 
                              //echo 'diff-'.gmdate("H:i:s",$total_end_time-$total_start_time);
                             
                               if($patientseens > 0){
                                $ttpatient = $patientseens;
                                //echo $ttpatient.'<br>';
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_date-$total_start_date)/$ttpatient;
                                //echo $total_time_spent_for_patient.'<br>';
                                //echo $ttpatient.'<br>';
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                               
                                ?>
                                
                                </h4>
                                </p>
                            </div>
                        </div>
                    </div> 
            <!------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.awt')); ?></p>
                                <h4 class="card-stats-number">

                                <?php $total_waiting_end_time = '0'; $total_waiting_start_time = '0';  $ttpatient_inqueue='0'; $ttpatientq;$total_time_patient_spent_in_queue; ?>
                                
                                <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php $__currentLoopData = $queue_patient_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queuepatient): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                   
                                    <?php if($call->queue_id==$queuepatient->id ): ?>
                                <?php ( $total_waiting_end_time += strtotime($queuepatient->updated_at) ); ?>
                                <?php ( $total_waiting_start_time += strtotime($queuepatient->created_at)); ?>
                                <?php ( $ttpatient_inqueue += count($queuepatient->number)); ?>
                                    <?php endif; ?> 
                                  
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 

                                <?php 
                              
                             
                              if($ttpatient_inqueue > 0){
                               $ttpatientq = $ttpatient_inqueue;
                               //echo $ttpatient.'<br>';
                              }else{
                               $ttpatientq = 1;
                              }
                               $total_time_patient_spent_in_queue = ($total_waiting_end_time-$total_waiting_start_time)/$ttpatientq;
                               //echo $total_time_spent_for_patient.'<br>';
                               //echo $ttpatient.'<br>';
                                echo gmdate("H:i:s", $total_time_patient_spent_in_queue).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                              
                               ?>
                                
                             
                               
                                </h4>
                                </p>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.hwct')); ?></p>
                                <h4 class="card-stats-number">
                              

                                <?php $total_dept_end_time = '0'; $total_dept_start_time = '0'; $total_time_avg_for_each_department; $ttpatient_d; $patientseens_d='0';  ?>
                                
                              
                                
                                <?php $__currentLoopData = $getAvgtimeAllDepartmentWise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avgdept): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    
                                <?php ( $total_dept_end_time += strtotime($avgdept->doctor_work_end_date) ); ?>
                                <?php ( $total_dept_start_time += strtotime($avgdept->doctor_work_start_date)); ?>
                                <?php ( $patientseens_d += count($avgdept->number)); ?>
                                    
                                  
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                             
                                
                              <?php 
                              
                             
                               if($patientseens_d > 0){
                                $ttpatient_d = $patientseens_d;
                               // echo $ttpatient_d.'<br>';
                               }else{
                                $ttpatient_d = 1;
                               }
                                $total_time_avg_for_each_department = ($total_dept_end_time-$total_dept_start_time)/$ttpatient_d;
                                //echo $total_time_spent_for_patient.'<br>';
                               //echo $total_dept_end_time-$total_dept_start_time.'<br>';
                                 echo gmdate("H:i:s", $total_time_avg_for_each_department).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                               
                                ?>
                                
                                </h4>
                                </p>
                            </div>
                        </div>
                    </div> 
            <!---------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.hawt')); ?></p>
                                <h4 class="card-stats-number"> 
                                <?php $total_waiting_end_time = '0'; $total_waiting_start_time = '0';  $ttpatient_inqueue='0'; $ttpatientq;$total_time_patient_spent_in_queue; ?>
                                <?php $__currentLoopData = $getAvgtimeAllDepartmentWaiting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allwaiting): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                   
                                <?php ( $total_waiting_end_time += strtotime($allwaiting->updated_at) ); ?>
                                <?php ( $total_waiting_start_time += strtotime($allwaiting->created_at)); ?>
                                <?php ( $ttpatient_inqueue += count($allwaiting->number)); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                                <?php 
                              
                             
                              if($ttpatient_inqueue > 0){
                               $ttpatientq = $ttpatient_inqueue;
                               //echo $ttpatient.'<br>';
                              }else{
                               $ttpatientq = 1;
                              }
                               $total_time_patient_spent_in_queue = ($total_waiting_end_time-$total_waiting_start_time)/$ttpatientq;
                               //echo $total_time_spent_for_patient.'<br>';
                               //echo $ttpatient.'<br>';
                                echo gmdate("H:i:s", $total_time_patient_spent_in_queue).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                              
                               ?>


                                </h4>
                                </p>
                            </div>
                            
                        </div>
                    </div> 

            <!---------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content deep-orange darken-2 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.tti')); ?></p>
                                <h4 class="card-stats-number">

                                <?php $total_consultant = '0'; $total_token_called = '0';  ?> 
                                <?php $__currentLoopData = $totalTokenIssued; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ttissued): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php ( $total_consultant += count($ttissued->number)); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                <?php $__currentLoopData = $totalTokenCalled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ttcalled): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php ( $total_token_called += count($ttcalled->number)); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                             <ul class="ttissuedetails">
                               <li> Total : <span><?php echo e($total_token_called+$total_consultant); ?></span></li>
                               <li>Called : <span><?php echo e($total_token_called); ?></span></li>
                               <li> Missed : <span><?php echo e($total_consultant); ?></span></li>
                             </ul> 
                                 
                                </h4>
                                </p>
                            </div>
                            
                        </div>
                    </div> 
             <!---------------------->
             <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content brown darken-2 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.tcs')); ?></p>
                                <h4 class="card-stats-number">
                                <?php $total_consultant = '0';  ?>
                                
                                <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php if($call->doctor_work_end == 1): ?>
                                <?php ( $total_consultant += count($call->number)); ?>
                                <?php endif; ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                               <?php
                               if($total_consultant > 0){
                                echo $total_consultant;
                               }else{
                                echo '0';
                               }
                               ?>
                                </h4>
                                </p>
                            </div>
                            
                        </div>
                    </div> 
             <!---------------------->
             <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content grey darken-3 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.tm')); ?></p>
                                <h4 class="card-stats-number">
                                <?php $total_missed_token = '0';  ?>
                                
                                <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php if($call->doctor_work_start == 0): ?>
                                <?php ( $total_missed_token += count($call->number)); ?>
                                <?php endif; ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                               <?php
                               if($total_missed_token > 0){
                                echo $total_missed_token;
                               }else{
                                echo '0';
                               }
                               ?>
                                </h4>
                                </p>
                            </div>
                            
                        </div>
                    </div> 

             <!---------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content lime darken-4 white-text">
                                <p class="card-stats-title truncate"><?php echo e(trans('messages.tpd')); ?></p>
                                <h4 class="card-stats-number">
                                <?php $total_no_of_patient = '0';  $total_no_of_days = '0'; ?>
                                
                                <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php if($call->doctor_work_end == 1): ?>
                                <?php ( $total_no_of_patient += count($call->number)); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                           
                          <!------------------------------>
                               
                               
                               <?php
                               $total_no_of_days = round(strtotime($edate)-strtotime($sdate))/86400;
                               if($total_no_of_patient > 0){
                                echo $total_no_of_patient.'<sub style="font-size:12px;">&nbsp; Patient</sub>';
                                echo ' / ';
                                echo $total_no_of_days+'1'.'<sub style="font-size:12px;">&nbsp; Days</sub>';
                               }else{
                                echo '0';
                               }
                               ?>
                               
                                </h4>
                                </p>
                            </div>
                            
                        </div>
                    </div>                         


          <!------------------------>          
                
                </div>
                </div>
                <!--------End-All-Key-deatils---------------------> 
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <span style="line-height:0;font-size:22px;font-weight:300"><?php echo e(trans('messages.report')); ?></span>
                    <div class="divider" style="margin:15px 0 10px 0"></div>
                    <table id="report-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Doctor's Name</th>
                                <th><?php echo e(trans('messages.mainapp.menu.department')); ?></th>
                                <th><?php echo e(trans('messages.call.number')); ?></th>
                                <th><?php echo e(trans('messages.roomnumber')); ?></th>
                                <th><?php echo e(trans('messages.spantime')); ?></th>
                                <th><?php echo e(trans('messages.sd')); ?></th>
                                <th><?php echo e(trans('messages.qwt')); ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                            <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($call->doctor_work_end == 1): ?>
                                <tr <?php $i++ ?>>
                                    <td> <?php echo e($i); ?>   </td>
                                    <td><?php echo e($call->user->name); ?></td>
                                    <td><?php echo e($call->department->name); ?></td>
                                    <td><?php echo e(($call->department->letter!='')?$call->department->letter.'-':''); ?><?php echo e($call->number); ?></td>
                                    <td><?php echo e($call->counter->name); ?></td>
                                    <td>
                                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if($call->id==$doctor->call_id ): ?>
                                    <?php echo e(gmdate("H:i:s", (strtotime($doctor->end_time)-strtotime($doctor->start_time)) )); ?> Hrs.
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>

                                    <td>
                                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if($call->id==$doctor->call_id ): ?>
                                    <?php echo e(date('d-m-Y',strtotime($doctor->created_at))); ?>

                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>

                                    <td>
                                    <?php $__currentLoopData = $tokenwaitingtimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tokenwaitingtime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?> 
     <?php if($call->queue_id == $tokenwaitingtime->id ): ?>
     <?php echo e(gmdate("H:i:s", (strtotime($tokenwaitingtime->updated_at)-strtotime($tokenwaitingtime->created_at)) )); ?> Hrs.
      <?php endif; ?> 
      <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/dataTables.buttons.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/jszip.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/pdfmake.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/vfs_fonts.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/buttons.print.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/tableplg/buttons.html5.min.js')); ?>"></script>
    <script>
        //---------------date-with-user-----------------------------------        
var from_$input1 = $('#sdate').pickadate({
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
    from_picker1 = from_$input1.pickadate('picker')

var to_$input1 = $('#edate').pickadate({
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
    to_picker1 = to_$input1.pickadate('picker')


// Check if there’s a “from” or “to” date to start with.
if ( from_picker1.get('value') ) {
  to_picker1.set('min', from_picker1.get('select'))
}
if ( to_picker1.get('value') ) {
  from_picker1.set('max', to_picker1.get('select'))
}

// When something is selected, update the “from” and “to” limits.
from_picker1.on('set', function(event) {
  if ( event.select ) {
    to_picker1.set('min', from_picker1.get('select'))    
  }
  else if ( 'clear' in event ) {
    to_picker1.set('min', false)
  }
})
to_picker1.on('set', function(event) {
  if ( event.select ) {
    from_picker1.set('max', to_picker1.get('select'))
  }
  else if ( 'clear' in event ) {
    from_picker1.set('max', false)
  }
})
//----------------------------------
        $(function() {
           
            $('#report-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search",
                    },
                    dom: 'Bfrtip',
                   buttons: [
             { extend: 'copy', title: ''+$('#user option:selected').text()+' : '+'Data Record  :'+' From '+$('#sdate').val()+' -To- '+$('#edate').val()+'',},
             { extend: 'csv', title: ''+$('#user option:selected').text()+' : '+'Data Record  :'+' From '+$('#sdate').val()+' -To- '+$('#edate').val()+'',},
             { extend: 'excel', title: ''+$('#user option:selected').text()+' : '+'Data Record  :'+' From '+$('#sdate').val()+' -To- '+$('#edate').val()+'',},
             { extend: 'pdf', title: ''+$('#user option:selected').text()+' : '+'Data Record :'+' From '+$('#sdate').val()+' -To- '+$('#edate').val()+'', },
             { extend: 'print', title: '<span style="font-size:15px; font-weight:700; text-transform:uppercase; display:block; text-align:center; padding:15px 0 0 0">'+$('#user option:selected').text()+' : '+'Data Record :'+' From '+$('#sdate').val()+' -To- '+$('#edate').val()+'</span>', },
             ] 
                  
            });
        });

        $('#user, #sdate, #edate').change(function(event){
            var user = $('#user').val();
            var sdate = $('#sdate').val();
            var edate = $('#edate').val();

            action = '<?php echo e(url('reports/user/')); ?>/'+user+'/'+sdate+'/'+edate;

            if(user=='' || sdate=='' || edate=='') {
                $('#gobtn').addClass('disabled');
            } else {
                $('#gobtn').removeClass('disabled');
            }
        });

        function gobtn() {
            if (!$('#gobtn').hasClass('disabled')) {
                $('body').removeClass('loaded');
                window.location = action;
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>