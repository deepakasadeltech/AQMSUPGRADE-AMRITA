<?php $__env->startSection('title', trans('messages.mainapp.menu.dashboard')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/css/materialize-colorpicker.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">

        <!--------------------------------> 
        <div class="row">
            <div class="col s12 m12 l12">
            <div class="popupmain">
            <?php if(session()->has('department_name')): ?> 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
            <ul>
        <li><?php echo e(trans('messages.users.token_number')); ?> : <?php echo e(session()->get('number')); ?>  (<?php echo e(session()->get('registration_no')); ?>) 
        &nbsp;&nbsp;&nbsp;Referred To</li><li><?php echo e(session()->get('department_name')); ?></li> 
           </ul> 
            </div>
            <div>
            <?php endif; ?>
            <?php if(session()->has('user_name')): ?> 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
                <ul>
        <li><?php echo e(trans('messages.users.token_number')); ?> : <?php echo e(session()->get('number')); ?>  (<?php echo e(session()->get('registration_no')); ?>) 
        &nbsp;&nbsp;&nbsp;Referred To</li><li><?php echo e(session()->get('user_name')); ?></li> <li>Room No. : <?php echo e(session()->get('room_number')); ?></li>
           </ul> 
            </div>
            <div>
            <?php endif; ?>
            <?php if(session()->has('reviewcall')): ?> 
            <div class="popuptoken referrralbox"> 
            <div class="tknpopupbox">
                <ul>
        <li style="color:#000; font-size:13px; font-weight:900;">Review Details : </li>        
        <li>Review ID : <?php echo e(session()->get('reviewcall')); ?> </li>
        <?php if(session()->get('patient_name') != ''): ?><li>Patient Name : <?php echo e(session()->get('patient_name')); ?> </li><?php endif; ?>
        <li><?php echo e(trans('messages.users.token_number')); ?> : <?php echo e(session()->get('number')); ?> </li>
           </ul> 
            </div>
            <div>
            <?php endif; ?>

            </div>
            </div> </div>
        <!--------------------------------> 

            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="card-stats">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.today_queue')); ?></p>
                                <h4 class="card-stats-number">
                                <?php $today_total_patients_in_queue = '0'; $today_total_patients_called = '0'; $today_total_patients_in_waiting = '0'; $today_total_patients_to_doctor = '0' ?>
                               <?php $__currentLoopData = $today_queue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quedetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                <?php ( $today_total_patients_in_queue += count($quedetail->number) ); ?>

                                <?php if($quedetail->called==0): ?>
                                <?php ( $today_total_patients_in_waiting += count($quedetail->number) ); ?>
                                <?php endif; ?>
                                
                                <?php if($quedetail->called==1): ?>
                                <?php ( $today_total_patients_called += count($quedetail->number) ); ?>
                                <?php endif; ?>  
                                
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>

                            
                              
                              
                                <ul class="ttissuedetails">
                               <li>Total : <span><?php echo e($today_total_patients_in_queue); ?></span></li>
                               <li>Waiting : <span><?php echo e($today_total_patients_in_waiting); ?></span></li>
                               <li>Missed : <span><?php echo e($today_total_patients_called-count($getTodayAvgConsultingTime)); ?></span></li>
                              
                               
                             </ul> 

                                </h4>
                                </p>
                            </div>
                            <div class="card-action light-blue darken-4">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content green lighten-1 white-text">
                    <p class="card-stats-title truncate"><i class="mdi-communication-call-missed"></i> <?php echo e(trans('messages.avgtime')); ?></p>
                                <h4 class="card-stats-number">

                                <?php $tavg_start_w_time = '0'; $tavg_end_w_time = '0'; $tt_patients_w = '0'; $tt_avg_time_w='0'; $tttoken_w='0'  ?>
                                <?php $__currentLoopData = $getTodayAvgWaitingTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $awaitingTime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                   
                                <?php ( $tavg_end_w_time += strtotime($awaitingTime->updated_at) ); ?>
                                <?php ( $tavg_start_w_time += strtotime($awaitingTime->created_at)); ?>
                                <?php ( $tt_patients_w += count($awaitingTime->number)); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                             
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
                <p class="card-stats-title truncate"><i class="mdi-action-trending-up"></i> <?php echo e(trans('messages.consultingtime')); ?></p>
                                <h4 class="card-stats-number">
                                <?php $tavg_start_time = '0'; $tavg_end_time = '0'; $tt_patients = '0'; $tt_avg_time='0';  ?>
                                <?php $__currentLoopData = $getTodayAvgConsultingTime; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aconsultingTime): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                   
                                <?php ( $tavg_end_time += strtotime($aconsultingTime->doctor_work_end_date) ); ?>
                                <?php ( $tavg_start_time += strtotime($aconsultingTime->doctor_work_start_date)); ?>
                                <?php ( $tt_patients += count($aconsultingTime->number)); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                               
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
                                <p class="card-stats-title truncate"><i class="mdi-image-timer"></i> <?php echo e(trans('messages.totalconsultant')); ?></p>
                                <h4 class="card-stats-number"><?php echo e(count($getTodayAvgConsultingTime)); ?></h4>
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
            <?php endif; ?>

            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark teal lighten-3 white-text" style="display:inherit">
                            <span class="chart-title"><?php echo e(trans('messages.queue_details')); ?></span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="queue-details-chart" height="155" style="height:308px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark" style="display:inherit">
                            <span class="chart-title"><?php echo e(trans('messages.today_yesterday')); ?></span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="today-vs-yesterday-chart" height="155" style="height:308px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <?php if($role == 'H'): ?>
			<div class="row">
					<div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.dat')); ?></p>
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_present)); ?></h4>
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
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i><?php echo e(trans('messages.drabsent')); ?></p>
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_absent)); ?></h4>
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
    <li class="tab"><a class="active" href="#tabname_doctor"><?php echo e(trans('messages.mainapp.role.Doctor')); ?></a></li>
    <li class="tab"><a href="#tabname_user"><?php echo e(trans('messages.mainapp.role.Staff')); ?></a></li>
  </ul>
  <div id="tabname_doctor" style="width:100%;">
            <h3 class="listdoctor"><?php echo e(trans('messages.doctorlist')); ?></h3>
                <div class="cardp card-panel">
                    <table id="doctor-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.counter')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($tuser->name); ?></td>
                                    <td><?php echo e($tuser->email); ?></td>
                                    <td>
                                    <?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $tuser->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>
                                    <td><?php echo e($tuser->department->name); ?></td>
                                    <td><?php if($tuser->counter_id == ''): ?> Not Allowted <?php else: ?> <?php echo e($tuser->counter->name); ?> <?php endif; ?></td>
                                    <td><?php echo e($tuser->role_text); ?></td>
                                  <td class="caction">
                                  <?php if($tuser->user_status == 1): ?>
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  <?php else: ?>
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  <?php endif; ?>
                                 </td>
                                   
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                </div>
                </div>
<!------------------------------------------------>

<div id="tabname_user" style="width:100%;">
            <h3 class="listdoctor"><?php echo e(trans('messages.userlist')); ?></h3>
                <div class="cardp card-panel">
                    <table id="user-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $staffusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($staffuser->name); ?></td>
                                    <td><?php echo e($staffuser->email); ?></td>
                                    <td><?php echo e($staffuser->role_text); ?></td>
                                  <td class="caction">
                                  <?php if($staffuser->user_status == 1): ?>
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  <?php else: ?>
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  <?php endif; ?>
                                 </td>
                                   
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                </div>
               
               </div>


<!-------------------------------------------->

               </div>


            </div>
        </div>
    </div>
			<?php endif; ?>

			
			
			<?php if($role == 'S'): ?>
			<div class="row userdashboard">
            <ul id="tabs-swipe-demo" class="tabs">    
            <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content yellow darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i><?php echo e(trans('messages.tit')); ?></p>
                                <h4 class="card-stats-number"><?php echo e(count($get_all_department_total_queue_in_today)); ?></h4>
                                </p>
                            </div>
                            <div class="card-action yellow darken-4">
                                <div class="center-align">
                                <a class="active" href="#tabname_queue"><?php echo e(trans('messages.md')); ?> <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.tct')); ?></p>
                                <h4 class="card-stats-number"><?php echo e(count($get_all_department_total_called_in_today)); ?></h4>
                                </p>
                            </div>
                            <div class="card-action pink darken-4">
                                <div class="center-align">
                                <a href="#tabname_called"><?php echo e(trans('messages.md')); ?> <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>

                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.dat')); ?></p>
                                <h4 class="card-stats-number"><?php echo e(count($totaldoctor_present)); ?></h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                <a href="#tabname_dpresent"><?php echo e(trans('messages.md')); ?> <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                            <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.cbns')); ?></p>
        <h4 class="card-stats-number"><?php echo e(count($get_all_department_total_called_but_not_seen_today)); ?></h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                <a href="#tabname_dabsent"><?php echo e(trans('messages.md')); ?> <i class="mdi-navigation-arrow-down"></i></a>
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
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.token_number')); ?></th>
                                <th>Registration No.</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $get_all_department_total_queue_in_today->sortBy('department_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                           <td><?php echo e($loop->iteration); ?></td>
                           <td><?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $q->department->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?></td>
                           <td><?php echo e($q->department->name); ?></td>
                           <td><?php echo e($q->department->letter); ?><?php echo e($q->number); ?></td>
                           <td><?php echo e($q->regnumber); ?></td>
                           </tr>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>    
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
								<th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.token_number')); ?></th>
                                <th><?php echo e(trans('messages.users.room_number')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $get_all_department_total_called_in_today; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <tr>
                           <td><?php echo e($loop->iteration); ?></td>
						   <td><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uc): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <?php if( $c->counter_id == $uc->counter_id ): ?>
                           <?php echo e($uc->name); ?>

                           <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?></td>
                           <td><?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $c->department->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?></td>
                           <td><?php echo e($c->department->name); ?></td>
                           <td><?php echo e($c->department->letter); ?><?php echo e($c->number); ?></td>
                           <td>
                          <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uc): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <?php if( $c->counter_id == $uc->counter_id ): ?>
                           <?php echo e($uc->counter->name); ?>

                           <?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                           </td>
                           </tr> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 
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
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.counter')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($tuser->user_status == 1): ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($tuser->name); ?></td>
                                    <td><?php echo e($tuser->email); ?></td>
                                    <td>
                                    <?php $__currentLoopData = $pardepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pardepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <?php if( $tuser->pid == $pardepartment->id ): ?>
                                    <?php echo e($pardepartment->name); ?> <?php else: ?> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </td>
                                    <td><?php echo e($tuser->department->name); ?></td>
                                    <td><?php if($tuser->counter_id == ''): ?> Not Allowted <?php else: ?> <?php echo e($tuser->counter->name); ?> <?php endif; ?></td>
                                    <td><?php echo e($tuser->role_text); ?></td>
                                  <td class="caction">
                                <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  </td>
                                    </tr>
                                    
                                  <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
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
                                <th><?php echo e(trans('messages.users.department')); ?></th>
                                <th><?php echo e(trans('messages.users.token_number')); ?></th>
                                <th>Registration No.</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php $__currentLoopData = $get_all_department_total_called_but_not_seen_today; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           <tr>
                           <td><?php echo e($loop->iteration); ?></td>
                           <td><?php echo e($d->department->name); ?></td>
                           <td><?php echo e($d->number); ?></td>
                           <td><?php echo e($d->queue->regnumber); ?></td>
                           </tr> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?> 

                           
                        </tbody>
                    </table>
                </div> </div>
      </div>

      </div>            
                    
      <!------------------------------->              
                </div>	
			<?php endif; ?>
			
			<?php if($role == 'D'): ?>
           <!----------------------------------> 
            <div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span><?php echo e(trans('messages.departments')); ?> :</span><span>
           <?php if($pdepartments->id == ''): ?> <a style="color:red">Not Allotted</a>  <?php else: ?> <?php echo e($pdepartments->name); ?>  <?php endif; ?>
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span><?php echo e(trans('messages.subdepartment')); ?> :</span><span><?php if($user_details->department_id == ''): ?> <a style="color:red">Not Allotted </a> <?php else: ?> <?php echo e($user_details->department->name); ?>   <?php endif; ?></span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span><?php echo e(trans('messages.roomnumber')); ?> :</span><span><?php if($user_details->counter_id == ''): ?> <a style="color:red">Not Allotted</a> <?php else: ?> <?php echo e($user_details->counter->name); ?>  <?php endif; ?></span>
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
 
        <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.prioritypending')); ?></p>
                    <div class="prioritybox"> <ul>
             <?php if($queuesetting->tokendisplay==2): ?>
             <li><span class="plclr"><?php echo e(trans('messages.platinum')); ?></span><span class="plclr"><?php echo e(count($platinum_patient)); ?><span></li>
             <li><span class="glclr"><?php echo e(trans('messages.gold')); ?></span><span class="glclr"><?php echo e(count($gold_patient)); ?><span></li>
             <li><span class="slclr"><?php echo e(trans('messages.silver')); ?></span><span class="slclr"><?php echo e(count($silver_patient)); ?><span></li>
             <?php else: ?>
             <li><span class="plclr"><?php echo e(trans('messages.platinum')); ?></span><span class="plclr"><?php echo e(count($today_queue_platinum)); ?><span></li>
             <li><span class="glclr"><?php echo e(trans('messages.gold')); ?></span><span class="glclr"><?php echo e(count($today_queue_gold)); ?><span></li>
             <li><span class="slclr"><?php echo e(trans('messages.silver')); ?></span><span class="slclr"><?php echo e(count($today_queue_silver)); ?><span></li>
             <?php endif; ?>

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
                         <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.patientseen')); ?> </p>
                                <h4 class="card-stats-number"><?php echo e($patient_seen); ?></h4>
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
            <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.patientcalled')); ?></p>
                                <h4 class="card-stats-number">
                                <?php echo e(count($patient_called_bydoctor)-$patient_seen); ?>

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
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.patientpending')); ?></p>
                                <h4 class="card-stats-number">
                                <?php if($queuesetting->tokendisplay==2): ?>
                                    <?php echo e(count($today_queue_bycounter_doctor)); ?>

                                <?php else: ?>
                                    <?php echo e(count($today_queue_bycounter)); ?>

                                <?php endif; ?>    
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
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.patientavgtime')); ?></p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               <?php $__currentLoopData = $daily_avgtime_of_doctor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php ( $total_end_time += strtotime($option->end_time) ); ?>
                                <?php ( $total_start_time += strtotime($option->start_time)); ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            
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
			<?php endif; ?>
			
			<?php if($role == 'D'): ?>
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
                                <th>Patient Called</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient_list_doctorwise->sortBy('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <!---------------------------------------->   
                                <tr>
                                    <td <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?> ><?php echo e($loop->iteration); ?></td>
                                    <td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>><?php echo e($patient->counter->name); ?></td>
									<td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>><?php echo e($patient->department->letter); ?><?php echo e($patient->number); ?></td>
									<td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>>
									<?php if($patient->priority==1): ?> <span class="boxmodi plbox">Plantinum </span>
									<?php elseif($patient->priority==2): ?> <span class="boxmodi glbox">Gold</span>
									<?php elseif($patient->priority==3): ?> <span class="boxmodi slbox">Silver</span>
									<?php elseif($patient->priority==4): ?> <span class="boxmodi nlbox">Normal</span>
									<?php else: ?>
                                     Normal										
									<?php endif; ?>	
                                    </td>

                            <td style="font-size:10px;"  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>>
                             <?php if($patient->queue->token_type == 'R'): ?> <a class="clr_yellow"> REVIEW </a>
                             <?php elseif($patient->queue->token_type == 'F'): ?> <a class="clr_red tooltipped" data-position="top" data-tooltip="Refer By : <?php echo e($patient->queue->refer_by); ?>">REFERRAL</a>
                              <?php else: ?> <a class="clr_green"> FIRST TIME </a> <?php endif; ?>
                                    </td>    
                                    
                                    <td  <?php if($patient->view_status == 1): ?> class="enabled" <?php else: ?> class="disabled"  <?php endif; ?>>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="<?php echo e(url('/dashboard/startCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.start_time')); ?>"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.you_do_first_start')); ?>"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="<?php echo e(trans('messages.You_have_started')); ?>"> <i class="mdi-av-timer"></i></a>

<a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="<?php echo e(url('/dashboard/endCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.end_time')); ?>"> <i class="mdi-action-schedule"></i></a>
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
                                    </td>
                                  
                                  
                                  <?php if(in_array($patient->view_status, array(1,2))): ?>
                                  <td>
                                  <?php if($patient->doctor_work_start == 1): ?>     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  <?php else: ?>
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="<?php echo e(url('/dashboard/PatientStatus')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>
                                 <?php endif; ?>
                                 </td> 
                                 <!--------->
                                  <?php else: ?>
                                  <td>  
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="<?php echo e(url('/dashboard/PatientStatus')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>
                                  <?php endif; ?>
                                  <!------------->

                           <!-----------Referral-Review---------------->       
                                  <td>
                                  <?php
                              if($patient->doctor_work_start == 1){
                                    ?>
                                      <?php if($queuesetting->tokendisplay==1): ?>
<a style="font-size:10px;margin-right:5px;" class="modal-trigger btn-floating waves-effect waves-light btn orange tooltipped" href="#modal2_<?php echo e($patient->id); ?>" data-position="top" data-tooltip="Refer"> <i class="mdi-communication-call-made"></i></a>
                                   <?php else: ?>
<a style="font-size:10px;margin-right:5px;" class="modal-trigger btn-floating waves-effect waves-light btn orange tooltipped" href="#modal1_<?php echo e($patient->id); ?>" data-position="top" data-tooltip="Refer"> <i class="mdi-communication-call-made"></i></a>
                                          <?php endif; ?>
                   
<a style="font-size:10px;" class="btn-floating waves-effect waves-light btn pink tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Review" onclick="review(<?php echo e($patient->id); ?>); this.style.visibility='hidden'; this.disable=true;"> <i class="mdi-editor-mode-edit"></i></a>
                                  
                                        <?php } else {?>

 <a style="font-size:10px;cursor:not-allowed; margin-right:5px;" class="disabled btn-floating waves-effect waves-light btn orange tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Refer"> <i class="mdi-communication-call-made"></i></a>

<a style="font-size:10px;cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn pink tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Review"> <i class="mdi-editor-mode-edit"></i></a>

                                        <?php } ?>
                                        

                                  </td>
                           <!------------------------------------------->      
                                 </tr>
                         <!------------------>  


                          <!---------------Popup-modal-1----------------------------->
                    <div id="modal1_<?php echo e($patient->id); ?>" class="custom-modal modal">
                <div class="modal-content">
                <div class="customform">
                <h4>Token No. : <?php echo e($patient->number); ?></h4>
                <h3>Refer To Next Doctor</h3>
            <form id="dep_isuuetkn2_<?php echo e($patient->id); ?>" name="getValueform2_<?php echo e($patient->id); ?>" action="/" method="GET">

            <input class="department_id_<?php echo e($patient->id); ?>" name="department_id" type="hidden" value="<?php echo e($patient->department_id); ?>" />

            <input autocomplete="off" class="registration_<?php echo e($patient->id); ?> regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" />
            
            <input class="uhid_<?php echo e($patient->id); ?>" name="uhid" type="hidden" placeholder="Enter Priority Number" value="<?php echo e($patient->queue->uhid); ?>" autofocus="autofocus" autocomplete="off" /> 

            <!----Name-Mobile-Email---------> 
        <input class="pname_<?php echo e($patient->id); ?>" name="pname" type="hidden"  value="<?php echo e($patient->queue->pname); ?>" />
        <input class="pmobile_<?php echo e($patient->id); ?>" name="pmobile" type="hidden" value="<?php echo e($patient->queue->pmobile); ?>" /> 
        <input class="pemail_<?php echo e($patient->id); ?>" name="pemail" type="hidden" value="<?php echo e($patient->queue->pemail); ?>"  />
        <input class="referralflag_<?php echo e($patient->id); ?>" name="referralflag" type="hidden" value="F"  />   
             <!------------------------------->         
                
            <div class="row refboxmrg">
                        <div class="input-field col s12">
                            <label for="doctor" class="active"><?php echo e(trans('messages.select')); ?> Doctor</label>
                            <select id="doctor" class="browser-default doctor_<?php echo e($patient->id); ?>" name="doctor" data-error=".doctor">
							<option value=""><?php echo e(trans('messages.select')); ?> Doctor</option>
							<?php $__currentLoopData = $activedoctortoseereferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activerefdoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <option value="<?php echo e($activerefdoctor->id); ?>">
        <?php echo e($activerefdoctor->name); ?> &#8596; <?php echo e($activerefdoctor->department->name); ?> &#8596; <?php echo e($activerefdoctor->counter->name); ?>

        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
							</select>
                            <div class="doctor">
                                <?php if($errors->has('doctor')): ?><div class="error"><?php echo e($errors->first('doctor')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
               <a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a>
               <button class="btn waves-effect waves-light csfloat subbutton" onclick="refer_to_doctor(<?php echo e($patient->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none; margin-left:10px;">REFER<i class="mdi-navigation-arrow-forward right"></i>
                </button>
            </div>
                </div>
                </div>
                </div>
                 <!---------------Popup-modal-2----------------------------->
                 <div id="modal2_<?php echo e($patient->id); ?>" class="custom-modal modal">
                <div class="modal-content">
                <div class="customform">
                <h4>Token No. : <?php echo e($patient->number); ?></h4>
                <h3>Refer To Next Doctor</h3>
            <form id="dep_isuuetkn2_<?php echo e($patient->id); ?>" name="getValueform2_<?php echo e($patient->id); ?>" action="/" method="GET">

            <input autocomplete="off" class="registration_<?php echo e($patient->id); ?> regvalues" style="color:#777;" name="registration" type="hidden" placeholder="" value="<?php echo rand(10000 , 99999); ?>" />
            
            <input class="uhid_<?php echo e($patient->id); ?>" name="uhid" type="hidden" placeholder="Enter Priority Number" value="<?php echo e($patient->queue->uhid); ?>" autofocus="autofocus" autocomplete="off" /> 

            <!----Name-Mobile-Email---------> 
        <input class="pname_<?php echo e($patient->id); ?>" name="pname" type="hidden"  value="<?php echo e($patient->queue->pname); ?>" />
        <input class="pmobile_<?php echo e($patient->id); ?>" name="pmobile" type="hidden" value="<?php echo e($patient->queue->pmobile); ?>" /> 
        <input class="pemail_<?php echo e($patient->id); ?>" name="pemail" type="hidden" value="<?php echo e($patient->queue->pemail); ?>"  />
        <input class="referralflag_<?php echo e($patient->id); ?>" name="referralflag" type="hidden" value="F"  />   
             <!------------------------------->         
                
            <div class="row refboxmrg">
                        <div class="input-field col s12">
                            <label for="department" class="active"><?php echo e(trans('messages.select')); ?> Department</label>
                            <select id="department" class="browser-default department_<?php echo e($patient->id); ?>" name="department" data-error=".department">
							<option value=""><?php echo e(trans('messages.select')); ?> Department</option>
							<?php $__currentLoopData = $activedepttoseereferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activedept): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <option value="<?php echo e($activedept->id); ?>">
        <?php echo e($activedept->name); ?> 
        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
							</select>
                            <div class="department">
                                <?php if($errors->has('department')): ?><div class="error"><?php echo e($errors->first('department')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
               <a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a>
               <button class="btn waves-effect waves-light csfloat subbutton" onclick="refer_to_department(<?php echo e($patient->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none; margin-left:10px;">REFER<i class="mdi-navigation-arrow-forward right"></i>
                </button>
            </div>
                </div>
                </div>
                </div>
                    <!------------End-modal----------------------------------->
                            
                        
                         <!------------------>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                    
                <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <?php if($queuesetting->tokendisplay==2): ?>
               <form id="new_call" action="<?php echo e(route('post_doctor_call_ourtoken')); ?>" method="post">
               <?php else: ?>    
               <form id="new_call" action="<?php echo e(route('post_doctor_call')); ?>" method="post"> 
                <?php endif; ?>    
                        <?php echo e(csrf_field()); ?>

                            <?php if(!($user->is_admin)||($user->role=='D')): ?>
                            <input type="hidden" name="user" value="<?php echo e($user->id); ?>">
                            <input type="hidden" name="ads_id" value="<?php echo e($user->ads_id); ?>">
                            <input type="hidden" name="pid" value="<?php echo e($user->pid); ?>">
                            <input type="hidden" name="department" value="<?php echo e($user->department_id); ?>">
                            <input type="hidden" name="counter" value="<?php echo e($user->counter_id); ?>">
                           <?php endif; ?>

                <div class="row">
                <div class="col s12">
             <?php if($queuesetting->tokendisplay==2): ?>
                <button <?php if((count($patient_list_doctorwise) >= 6)||(count($today_queue_bycounter_doctor)==0)): ?> disabled="disabled" <?php endif; ?> class="btn waves-effect waves-light pink" type="submit">
                <?php echo e(trans('messages.call.call_next')); ?><i class="mdi-content-send right"></i></i>
                </button>
             <?php else: ?>
             <button <?php if((count($patient_list_doctorwise) >= 6)||(count($today_queue_bycounter)==0)): ?> disabled="disabled" <?php endif; ?> class="btn waves-effect waves-light pink" type="submit">
                <?php echo e(trans('messages.call.call_next')); ?><i class="mdi-content-send right"></i></i>
                </button>
             <?php endif; ?> 

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
			<?php endif; ?>

      <!-----------Start-Superadmin----------------------->  
      <?php if($role == 'O'): ?>
      <div class="row">
      <div class="col s12">
      <div class="superadminbox">
      <ul>
      <li><span><?php echo e(trans('messages.ndoctor')); ?></span><span> <?php echo e(count($No_Of_Doctor)); ?></span></li>
      <li><span><?php echo e(trans('messages.nuser')); ?></span><span> <?php echo e(count($No_Of_Staff)); ?></span></li>
      <li><span><?php echo e(trans('messages.nhelpdesk')); ?></span><span> <?php echo e(count($No_Of_Helpdesk)); ?></span></li>
      <li><span><?php echo e(trans('messages.ncmo')); ?></span><span> <?php echo e(count($No_Of_CMO)); ?></span></li>
      <li><span><?php echo e(trans('messages.ndisplayctrl')); ?></span><span> <?php echo e(count($No_Of_Displayctrl)); ?></span></li>
      <li><span><?php echo e(trans('messages.ndepartment')); ?></span><span> <?php echo e(count($No_Of_Pdepartment)); ?></span></li>
      <li><span><?php echo e(trans('messages.nsupdepartment')); ?></span><span> <?php echo e(count($No_of_Department)); ?></span></li>
      <li><span><?php echo e(trans('messages.nroom')); ?></span><span> <?php echo e(count($No_of_Counter)); ?></span></li>
      <li><span><?php echo e(trans('messages.ntokenperday')); ?></span><span> <?php echo e(count($No_of_tokenPerDay)); ?></span></li>
      <li><span><?php echo e(trans('messages.nads')); ?></span><span><?php echo e(count($No_of_Ads)); ?></span></li>
      </ul>
      </div>

     
                
       </div>
      </div>
      <?php endif; ?>    
      <!------------End-Superadmin---------------------->
            
			<?php if($role == 'A'): ?>
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable waves-effect waves-dark" style="display:inherit">
                        <div class="card-move-up black-text">
                            <div class="move-up">
                                <div>
                                    <span class="chart-title"><?php echo e(trans('messages.dashboard.notification')); ?></span>
                                </div>
                                <div class="trending-line-chart-wrapper">
                                    <p><?php echo e(trans('messages.dashboard.preview')); ?>:</p>
                                    <span style="font-size:<?php echo e($setting->size); ?>px;color:<?php echo e($setting->color); ?>">
                                        <marquee><?php echo e($setting->notification); ?></marquee>
                                    </span>
                                    <p></p>
                                    <form id="noti" action="<?php echo e(route('dashboard_store')); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <label for="notification"><?php echo e(trans('messages.dashboard.notification_text')); ?></label>
                                                <input id="notification" name="notification" type="text" placeholder="<?php echo e(trans('messages.dashboard.notification_placeholder')); ?>" data-error=".errorNotification" value="<?php echo e($setting->notification); ?>">
                                                <div class="errorNotification"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <label for="size"><?php echo e(trans('messages.font_size')); ?></label>
                                                <input id="size" name="size" type="number" placeholder="Size" max="60" min="15" size="2" data-error=".errorSize" value="<?php echo e($setting->size); ?>">
                                                <div class="errorSize"></div>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <label for="color"><?php echo e(trans('messages.color')); ?></label>
                                                <input id="color" type="text" placeholder="Color" name="color" data-error=".errorColor" value="<?php echo e($setting->color); ?>">
                                                <div class="errorColor"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <button class="btn waves-effect waves-light right submit" type="submit" style="padding:0 1.3rem"><?php echo e(trans('messages.go')); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php endif; ?>
		</div>
    </div>
<?php $__env->stopSection(); ?>

<!----------Start-print-section----------------------->

<?php $__env->startSection('print'); ?>

<?php if($queuesetting->tokendisplay==1): ?>

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
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="<?php echo e(url('public/logo')); ?>/<?php echo e($setting->logo); ?>" alt="logo"> <?php echo e(str_limit( $company_name)); ?> </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?>  <sup><?php echo e(session()->get('referral')); ?></sup></span>
   <?php if($queuesetting->reg_required==1): ?>
   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : <?php echo e(session()->get('registration_no')); ?></span><?php endif; ?>

  </td></tr>
   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patient Name (रोगी का नाम) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('patient_name')); ?></td> </tr>

   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('department_name')); ?></td> </tr>
    
   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;"><?php echo e(session()->get('total')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> <?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Referred By <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('referred_by')); ?></td> </tr>

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
<?php elseif($queuesetting->tokendisplay==2): ?>
<!------===========================------------------------->

<?php if(session()->has('user_name')): ?>
    <style>#printarea{display:none;text-align:left}@media  print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
         
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:inline-block; text-transform:uppercase; font-size:12px; text-align:left;"><img style="width:50px; float:left; margin-right:5px; margin-top:-7px;" src="<?php echo e(url('public/logo')); ?>/<?php echo e($setting->logo); ?>" alt="logo"> <?php echo e(str_limit( $company_name)); ?> </span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?>  <sup><?php echo e(session()->get('referral')); ?></sup></span>

   <?php if($queuesetting->reg_required==1): ?>
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
   <tr> <td style="padding:4px; border:1px solid #ccc;">Referred By <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('referred_by')); ?></td> </tr>

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
<script type="text/javascript" src="<?php echo e(asset('assets/js/voice.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/materialize-colorpicker.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/chartjs/chart.min.js')); ?>"></script>  
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
 
   
    <script>
        <?php if(session()->get('printFlag')): ?>
        $('.tooltipped').removeAttr('data-tooltip'); 
        <?php endif; ?> 
      
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
            var myForm7 = '<form id="hidfrm7" action="<?php echo e(url('dashboard/doctor')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?><input type="hidden" name="doctor" value="'+doctor+'">'+'<input type="text" name="referralflag" value="'+ referralflag +'">'+'<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+'<input type="text" name="department_id" value="'+ department_id +'">'+'<input type="text" name="pname" value="'+ pname +'">'+'<input type="text" name="pmobile" value="'+ pmobile +'">'+'<input type="text" name="pemail" value="'+ pemail +'">'+'</form>';
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
			var myForm1 = '<form id="hidfrm1" action="<?php echo e(url('dashboard/department')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
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
            var myForm8 = '<form id="hidfrm8" action="<?php echo e(url('dashboard/review')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?><input type="hidden" name="id" value="'+value+'">'+'</form>';
            $('body').append(myForm8);
            myForm7 = $('#hidfrm8');
            myForm7.submit();
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
            bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }

        $(function() {
            $('#color').colorpicker();
        });

        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
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
                    labels: [<?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $counter): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($indx==0): ?> <?php echo "'$counter->name'"; ?>
                            <?php else: ?> <?php echo ", '$counter->name'"; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>],
                    datasets: [
                      {
                          label: "Today",
                          fillColor: "rgba(0,176,159,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(0,176,159,0.9)",
                          highlightStroke: "rgba(220,220,220,9)",
                          data: [<?php $__currentLoopData = $today_calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $today_call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                  <?php if($indx==0): ?> <?php echo "'$today_call'"; ?>
                                  <?php else: ?> <?php echo ", '$today_call'"; ?>
                                  <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>]
                      },
                      {
                          label: "Yesterday",
                          fillColor: "rgba(151,187,205,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(151,187,205,0.9)",
                          highlightStroke: "rgba(220,220,220,0.9)",
                          data: [<?php $__currentLoopData = $yesterday_calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $yesterday_call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                  <?php if($indx==0): ?> <?php echo "'$yesterday_call'"; ?>
                                  <?php else: ?> <?php echo ", '$yesterday_call'"; ?>
                                  <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>]
                      }
                    ]
                };
          
                var queueDetailsChartData = [
                  {
                      value: "<?php echo e($today_total_patients_in_queue); ?>",
                      color: "#00c0ef",
                      highlight: "#00c0ef",
                      label: "Token Issued"
                  },
                  {
                      value: "<?php echo e($today_total_patients_in_waiting); ?>",
                      color: "#00a65a",
                      highlight: "#00a65a",
                      label: "Waiting Patient"
                  },
                  {
                      value: "<?php echo e($today_total_patients_called-count($getTodayAvgConsultingTime)); ?>",
                      color: "#f39c12",
                      highlight: "#f39c12",
                      label: "Missed Patients"
                  },
                  {
                      value: "<?php echo e(count($getTodayAvgConsultingTime)); ?>",
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
        <?php endif; ?>

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>