<?php $__env->startSection('title', trans('messages.add').' '.trans('messages.mainapp.menu.users')); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.add')); ?> <?php echo e(trans('messages.mainapp.menu.users')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li><a href="<?php echo e(route('users.index')); ?>"><?php echo e(trans('messages.mainapp.menu.users')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.add')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3" style="padding-top:10px;padding-bottom:10px">
                <a class="btn-floating waves-effect waves-light orange tooltipped right" href="<?php echo e(route('users.index')); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.cancel')); ?>"><i class="mdi-navigation-arrow-back"></i></a>
                <form enctype="multipart/form-data" id="add" action="<?php echo e(route('users.store')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>


                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name"><?php echo e(trans('messages.name')); ?></label>
                            <input id="name" type="text" name="name" placeholder="<?php echo e(trans('messages.name')); ?>" value="<?php echo e(old('name')); ?>" data-error=".name">
                            <div class="name">
                                <?php if($errors->has('name')): ?><div class="error"><?php echo e($errors->first('name')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
            <div class="input-field col s12" style="margin-bottom:30px; padding-bottom:10px; border-bottom: 1px solid #9e9e9e;">
            <span style="display:block;font-size:.8rem;color:#9e9e9e; margin-bottom:10px;"> Photo (size:200px*230px)</span>
            <input id="photo" type="file" name="photo" value="">             
            </div>
            </div>

            <div class="row">
                        <div class="input-field col s12">
                            <label for="profile">Profile Name</label>
                            <input id="profile" type="text" name="profile" placeholder="Profile Name" value="<?php echo e(old('profile')); ?>" data-error=".profile">
                            <div class="profile">
                                <?php if($errors->has('profile')): ?><div class="error"><?php echo e($errors->first('profile')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>

                   
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="username"><?php echo e(trans('messages.users.username')); ?></label>
                            <input id="username" type="text" name="username" placeholder="<?php echo e(trans('messages.users.username')); ?>" value="<?php echo e(old('username')); ?>" data-error=".username">
                            <div class="username">
                                <?php if($errors->has('username')): ?><div class="error"><?php echo e($errors->first('username')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="email"><?php echo e(trans('messages.users.email')); ?></label>
                            <input id="email" type="text" name="email" placeholder="<?php echo e(trans('messages.users.email')); ?>" value="<?php echo e(old('email')); ?>" data-error=".email">
                            <div class="email">
                                <?php if($errors->has('email')): ?><div id="name-error" class="error"><?php echo e($errors->first('email')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    
					<div class="row">
                        <div class="input-field col s12">
                            <label for="name" class="active"><?php echo e(trans('messages.users.role')); ?></label>
                            <select id="role" class="browser-default" name="role" data-error=".role">
								<option value="D">Doctor</option>
								<option value="S">Staff</option>
                                <option value="H">Help Desk</option>
                                <option value="C">CMO</option>
                                <option value="I">Display Controller</option>
							</select>
                            <div class="name">
                                <?php if($errors->has('role')): ?><div class="error"><?php echo e($errors->first('role')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>
         <!-------------------------------------->

                        <div class="row" id="pid_section">
                                <div class="input-field col s12">
                                    <label for="pid" class="active"><?php echo e(trans('messages.mainapp.menu.parent_department')); ?></label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.parent_department')); ?></option>
                                        <?php $__currentLoopData = $pdepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php if(session()->has('pid') && ($pdepartment->id==session()->get('pid'))): ?>
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
							
                            <div class="row" id="depid_section">
                                <div class="input-field col s12">
                                    <label for="department_id" class="active"><?php echo e(trans('messages.mainapp.menu.department')); ?></label>
                                    <select id="department_id" class="browser-default" name="department_id" data-error=".department_id">
                                       
                                    </select>
                                    <div class="department_id">
                                        <?php if($errors->has('department_id')): ?><div class="error"><?php echo e($errors->first('department_id')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>

         <!--------------ads-with-doctor------------>  
         <div class="row" id="ads_section">
                                <div class="input-field col s12">
                                    <label for="ads_id" class="active"><?php echo e(trans('messages.mainapp.menu.ads')); ?></label>
                                    <select id="ads_id" class="browser-default" name="ads_id" data-error=".ads_id">
                                <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.ads')); ?></option>
                                        <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                 <option value="<?php echo e($ad->id); ?>"><?php echo e($ad->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="ads_id">
                                        <?php if($errors->has('ads_id')): ?><div class="error"><?php echo e($errors->first('ads_id')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
         <!--------------------------------------->
					
					
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password"><?php echo e(trans('messages.users.password')); ?></label>
                            <input id="password" type="password" name="password" placeholder="<?php echo e(trans('messages.users.password')); ?>" value="<?php echo e(old('password')); ?>" data-error=".password">
                            <div class="password">
                                <?php if($errors->has('password')): ?><div id="name-error" class="error"><?php echo e($errors->first('password')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password_confirmation"><?php echo e(trans('messages.users.confirm')); ?> <?php echo e(trans('messages.users.password')); ?></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="<?php echo e(trans('messages.users.confirm')); ?> <?php echo e(trans('messages.users.password')); ?>" value="<?php echo e(old('password_confirmation')); ?>" data-error=".password_confirmation">
                            <div class="password_confirmation">
                                <?php if($errors->has('password_confirmation')): ?><div id="name-error" class="error"><?php echo e($errors->first('password_confirmation')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                                <div class="input-field col s12">
                                    <label for="user_status" class="active"><?php echo e(trans('messages.mainapp.menu.counter')); ?></label>
                                    <select id="user_status" class="browser-default" name="user_status" data-error=".user_status">
                                    <option selected value="1">Active</option>
                                     <option value="2">InActive</option>
                                    </select>
                                    <div class="user_status">
                                        <?php if($errors->has('user_status')): ?><div class="error"><?php echo e($errors->first('user_status')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                   

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn waves-effect waves-light right" type="submit">
                                <?php echo e(trans('messages.save')); ?><i class="mdi-content-save left"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $("#add").validate({
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
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },

                pid: {
                    required: true,
                },

                department_id: {
                    required: true,
                },

                user_status: {
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

    //-------------------------------------------------
    $('body').on('change', '#pid', function(){
			var options = "<option selected value=''>Select Department</option>";
			if($(this).val() == ''){
				$('#department_id').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_updept')); ?>",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#department_id').html(options);
										
                }
            });
		});       
        $('body').on('change', '#role', function(){
            if($(this).val() != 'D'){
                $('#pid_section').css('display', 'none');
                $('#depid_section').css('display', 'none');
                $('#ads_section').css('display', 'none');
            }else{
                $('#pid_section').css('display', '');
                $('#depid_section').css('display', '');
                $('#ads_section').css('display', '');
            }
        });
        

    //-------------------------------------------------
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>