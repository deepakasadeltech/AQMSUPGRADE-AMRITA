<?php $__env->startSection('title', trans('messages.add').' '.trans('messages.mainapp.menu.counter')); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.add')); ?> <?php echo e(trans('messages.mainapp.menu.counter')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li><a href="<?php echo e(route('counters.index')); ?>"><?php echo e(trans('messages.mainapp.menu.counter')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.add')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3" style="padding-top:10px;padding-bottom:10px">
                <a class="btn-floating waves-effect waves-light orange tooltipped right" href="<?php echo e(route('counters.index')); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.cancel')); ?>"><i class="mdi-navigation-arrow-back"></i></a>
                <form id="add" action="<?php echo e(route('counters.store')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>


                   
                    <div class="row">
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
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="department" class="active"><?php echo e(trans('messages.mainapp.menu.department')); ?></label>
                                    <select id="department_id" class="browser-default" name="department_id" data-error=".department_id">
                             <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.department')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php if(session()->has('department') && ($department->id==session()->get('department'))): ?>
                                                <option value="<?php echo e($department->id); ?>" selected><?php echo e($department->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="department_id">
                                        <?php if($errors->has('department_id')): ?><div class="error"><?php echo e($errors->first('department_id')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>


                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name"><?php echo e(trans('messages.name')); ?></label>
                            <input id="name" type="text" name="name" placeholder="<?php echo e(trans('messages.mainapp.menu.counter')); ?> <?php echo e(trans('messages.name')); ?>" value="<?php echo e(old('name')); ?>" data-error=".name">
                            <div class="name">
                                <?php if($errors->has('name')): ?><div class="error"><?php echo e($errors->first('name')); ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="display_sequence"><?php echo e(trans('messages.users.display_sequence')); ?></label>
                            <input id="display_sequence" type="text" name="display_sequence" placeholder="<?php echo e(trans('messages.users.display_sequence')); ?>" value="<?php echo e(old('display_sequence')); ?>" data-error=".display_sequence">
                            <div class="display_sequence">
                                <?php if($errors->has('display_sequence')): ?><div class="error"><?php echo e($errors->first('display_sequence')); ?></div><?php endif; ?>
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
                display_sequence: {
                    required: true
                },
                pid: {
                    required: true
                },
                department_id: {
                    required: true
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

 //-------------------------------

 $('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Department</option>";
			if($(this).val() == ''){
				$('#department_id').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_mpdept')); ?>",
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>