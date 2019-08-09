<?php $__env->startSection('title', trans('messages.settings')); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.settings')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.settings')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', $settings)): ?>
            <div class="row">
                <div class="col s12 m6">
                    <div class="card">
                        <div id="userId" class="card-content">
                            <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.map_doctor')); ?></span>
                            <div class="divider" style="margin:10px 0 10px 0"></div>
                            <form id="mapdeptfrm" action="<?php echo e(route('post_map_dept')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

								
								<div class="row">
                                    <div class="input-field col s12">
                                        <label for="user" class="active"><?php echo e(trans('messages.call.doctor')); ?></label>
                                <select id="user" class="browser-default" name="user" data-error=".user">
                                <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.call.doctor')); ?></option>
                               <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                               <?php if($cuser->role=='D'): ?>
                                 <option value="<?php echo e($cuser->id); ?>"<?php echo $cuser->id==$user_details->id ?' selected':''; ?>><?php echo e($cuser->name); ?> (<?php echo e($cuser->role_text); ?>)</option>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        </select>
                                        <div class="user">
                                            <?php if($errors->has('user')): ?><div class="error"><?php echo e($errors->first('user')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="row">
                                <div class="input-field col s12">
                                    <label for="pid" class="active"><?php echo e(trans('messages.mainapp.menu.parent_department')); ?></label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.parent_department')); ?></option>
                                        <?php $__currentLoopData = $pdepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php if($pdepartment->id == $user_details->pid): ?>
                                                <option value="<?php echo e($pdepartment->id); ?>" selected><?php echo e($pdepartment->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($pdepartment->id); ?>"><?php echo e($pdepartment->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="pid">
                                        <?php if($errors->has('pid')): ?><div class="error"><?php echo e($errors->first('pid')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="department" class="active"><?php echo e(trans('messages.mainapp.menu.department')); ?></label>
                                    <select id="department" class="browser-default" name="department" data-error=".department">
                                        <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.department')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <?php if($department->id == $user_details->department_id): ?>
                                                <option value="<?php echo e($department->id); ?>" selected><?php echo e($department->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="department">
                                        <?php if($errors->has('department')): ?><div class="error"><?php echo e($errors->first('department')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>

                             <?php
                            $rooms_id = $user_details->counter_id; 
                            $array_rooms_id =  explode(', ', $rooms_id); $rmid = '';
                            foreach($array_rooms_id as $rroom){
                                $rmid .= $rroom; 
                            }
                            ?>

                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="counter" class="active"><?php echo e(trans('messages.mainapp.menu.counter')); ?></label>
                                    <select multiple id="counter" class="browser-default" name="counter[]" data-error=".counter">
                                        <option value="" disabled ><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.counter')); ?></option>
                                        <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <?php if($counter->id == $user_details->counter_id): ?>
                                                <option value="<?php echo e($counter->id); ?>" selected><?php echo e($counter->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($counter->id); ?>"><?php echo e($counter->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="counter">
                                        <?php if($errors->has('counter')): ?><div class="error"><?php echo e($errors->first('counter')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>



                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit">
                                            <?php echo e(trans('messages.update')); ?><i class="mdi-action-swap-vert left"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
 <script>
	
        $("#account").validate({
            rules: {
                name: {
                    required: true
                },
                username: {
                    required: true,
                    minlength: 6
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    minlength: 6
                },
                password_confirmation: {
                    minlength: 6,
                    equalTo: "#password"
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
        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', $settings)): ?>
            $("#company").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        email: true
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
            $("#overmissed").validate({
                rules: {
                    over_time: {
                        required: true,
                        digits: true
                    },
                    missed_time: {
                        required: true,
                        digits: true
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
            $("#languagefrm").validate({
                rules: {
                    language: {
                        required: true,
                        digits: true
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

            $('body').on('change', '#user', function(){
			var options = "<option value=''>Select Department </option>";
			if($(this).val() == ''){
				$('#pid').html(options);
			}
			var data = 'user='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_cuserdept')); ?>",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#pid').html(options);
										
                }
            });
		});
			
			$('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Parent Department</option>";
			if($(this).val() == ''){
				$('#department').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_spdept')); ?>",
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


        $('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Counter </option>";
			if($(this).val() == ''){
				$('#counter').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_cgdept')); ?>",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#counter').html(options);
										
                }
            });
		});
		
        <?php endif; ?>
		
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>