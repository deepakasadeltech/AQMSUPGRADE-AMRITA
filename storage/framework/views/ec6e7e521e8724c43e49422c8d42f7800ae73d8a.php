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
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">Doctor Report</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li><?php echo e(trans('messages.mainapp.menu.reports.reports')); ?></li>
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
                        <button class="btn waves-effect waves-light left light-blue"><?php echo e(trans('messages.rot')); ?><span style=" color: #fff;
    font-size: 14px; display: inline-block; border: 0px solid #f00; background:#c51162; line-height: normal; border-radius: 100%; padding: 7px; margin:0 3px;"><?php echo e(count($doctorReportwithDateRange)); ?></span> <?php echo e(trans('messages.doctrr')); ?></button>
                        </div>

                        <div class="input-field col s12 m3">
                            <label for="asdate"><?php echo e(trans('messages.starting')); ?> <?php echo e(trans('messages.date')); ?></label>
                            <input id="asdate" type="text" placeholder="dd-mm-yyyy" value="<?php echo e($asdate); ?>">
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="aedate"><?php echo e(trans('messages.ending')); ?> <?php echo e(trans('messages.date')); ?></label>
                            <input id="aedate" type="text" placeholder="dd-mm-yyyy" value="<?php echo e($aedate); ?>">
                        </div>
                        <div class="input-field col s12 m1">
                            <button id="gobtns" class="btn waves-effect waves-light right disabled" onclick="gobtns()"><?php echo e(trans('messages.go')); ?></button>
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
                    <span style="line-height:0;font-size:22px;font-weight:300"><?php echo e(trans('messages.report')); ?></span>
                    <div class="divider" style="margin:15px 0 10px 0"></div>
                    <table id="report-table" class="display tablemodify" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo e(trans('messages.doctorname')); ?></th>
                                <th><?php echo e(trans('messages.departments')); ?></th>
                                <th><?php echo e(trans('messages.roomnumber')); ?></th>
                                <th><?php echo e(trans('messages.dr_act')); ?></th>
                                <th><?php echo e(trans('messages.dept_awt')); ?></th>
                                <th><?php echo e(trans('messages.hosp_act')); ?></th>
                                <th><?php echo e(trans('messages.tm')); ?></th>
                                <th><?php echo e(trans('messages.tppd')); ?></th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                            <?php $__currentLoopData = $doctorReportwithDateRange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctordetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr <?php $i++ ?>>
                                    <td> <?php echo e($i); ?>   </td>
                                    <td><?php echo e($doctordetail->name); ?></td>
                                    <td><?php echo e($doctordetail->department->name); ?></td>
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
                                        <?php $__currentLoopData = $getAvgCTimeEachDoctorWithDateRange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avgctime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <?php if($doctordetail->id == $avgctime->user_id ): ?>
                                         
                                        <?php ( $total_end_time += strtotime($avgctime->doctor_work_end_date)); ?>
                                        <?php ( $total_start_time += strtotime($avgctime->doctor_work_start_date)); ?>
                                        <?php ( $tconsutingpatient += count($avgctime->number)); ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
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
                                 <?php $__currentLoopData = $avgWaitingTimeofTokenForEachDepartment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avgwtime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                 <?php if($doctordetail->department_id == $avgwtime->department_id ): ?>
                                 <?php ( $waiting_end_time += strtotime($avgwtime->updated_at)); ?>
                                 <?php ( $waiting_start_time += strtotime($avgwtime->created_at)); ?>
                                 <?php ( $waitingpatient += count($avgwtime->number)); ?>
                                 <?php endif; ?>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

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
                                 <?php $__currentLoopData = $avgWaitingTimeofTokenForEachDepartment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avgwtime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                 <?php ( $hwaiting_end_time += strtotime($avgwtime->updated_at)); ?>
                                 <?php ( $hwaiting_start_time += strtotime($avgwtime->created_at)); ?>
                                 <?php ( $hwaitingpatient += count($avgwtime->number)); ?>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 
                                
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
                                   <?php $__currentLoopData = $gettokenMissedDoctorWithDateRange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctortmissed): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                   <?php if($doctordetail->id == $doctortmissed->user_id ): ?>
                                   <?php ( $tmissedbydoctor += count($doctortmissed->number)); ?>
                                   <?php endif; ?>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                   <?php if($tmissedbydoctor > 0): ?>
                                   <span style="color:#f00"><?php echo e($tmissedbydoctor); ?></span>
                                   <?php else: ?>  <span style="color:#00FF00"> 0 </span>      <?php endif; ?>   
                                   </td>

                                    <td>
                                    <?php $ttconsultantofdoctor='0'; $total_no_of_days='0'; $ttday='0'; ?>
                                        <?php $__currentLoopData = $getAvgCTimeEachDoctorWithDateRange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avgctime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <?php if($doctordetail->id == $avgctime->user_id ): ?>
                                        <?php ( $ttconsultantofdoctor += count($avgctime->number)); ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                       <?php  $total_no_of_days = round(strtotime($aedate)-strtotime($asdate))/86400;
                                       $ttday = $total_no_of_days+'1'; 
                                       ?>
                                        <?php if($ttconsultantofdoctor > 0): ?>
                                        <span style="color:#00FF00"> <?php echo e($ttconsultantofdoctor); ?> <sub style="font-size:12px;">&nbsp;Patients</sub> / <?php echo e($ttday); ?> <sub style="font-size:12px;">&nbsp; Days </sub> </span>
                                        <?php else: ?>
                                        <span style="color:#f00"> 0 <sub style="font-size:12px;">&nbsp; Patients </sub> / 0 <sub style="font-size:12px;">&nbsp; Days</sub> </span>
                                        <?php endif; ?>

                                    </td>
                                    
                             </tr>
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

            action = '<?php echo e(url('reports/user/')); ?>/'+asdate+'/'+aedate;

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>