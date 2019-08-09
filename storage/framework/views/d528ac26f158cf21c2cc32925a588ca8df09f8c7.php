<?php $__env->startSection('title', trans('messages.mainapp.menu.displaysetting')); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.displaysetting')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.displaysetting')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
        <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content" style="float:left;">
                        
                            <div class="col s12 m6">
                            <form id="dsetting" action="<?php echo e(route('update_displaytext')); ?>" method="post" >
                            <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="textup">Text Up</label>
                                        <input id="textup" type="text" name="textup" placeholder="<?php echo e(trans('messages.name')); ?>" value="<?php echo e($displaysetting->textup); ?>" data-error=".textup">
                                        <div class="textup">
                                            <?php if($errors->has('textup')): ?><div class="error"><?php echo e($errors->first('textup')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="textdown">Text Down</label>
                                        <input id="textdown" type="text" name="textdown" placeholder="<?php echo e(trans('messages.users.email')); ?>" value="<?php echo e($displaysetting->textdown); ?>" data-error=".textdown">
                                        <div class="textdown">
                                            <?php if($errors->has('textdown')): ?><div id="textdown-error" class="error"><?php echo e($errors->first('textdown')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="work">Going Instruction</label>
                                        <input id="work" type="text" name="work" placeholder="<?php echo e(trans('messages.users.email')); ?>" value="<?php echo e($displaysetting->work); ?>" data-error=".work">
                                        <div class="work">
                                            <?php if($errors->has('work')): ?><div id="work-error" class="error"><?php echo e($errors->first('work')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
             
             <!----------------------->
           
                <div class="row">
                    <div class="col s12">
                        <label>Department Name Display in Heading : </label>
                        <select id="deptflag" name="deptflag">
                 <?php if($displaysetting->deptflag==1): ?> 
                 <option selected value="<?php echo e($displaysetting->deptflag); ?>">English</option>
                 <?php elseif($displaysetting->deptflag==2): ?> 
                 <option selected value="<?php echo e($displaysetting->deptflag); ?>">Other Language</option>
                 <?php elseif($displaysetting->deptflag==3): ?>
                 <option selected value="<?php echo e($displaysetting->deptflag); ?>"> Both </option>
                 <?php else: ?> <?php endif; ?>
                 <option value="1">English</option>
                    <option value="2">Other Language</option>
                    <option value="3">Both</option>
                    
                        </select>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <label>Department Name Display in Table : </label>
                        <select id="deptcflag" name="deptcflag">
                 <?php if($displaysetting->deptcflag==1): ?> 
                 <option selected value="<?php echo e($displaysetting->deptcflag); ?>">English</option>
                 <?php elseif($displaysetting->deptcflag==2): ?> 
                 <option selected value="<?php echo e($displaysetting->deptcflag); ?>">Other Language</option>
                 <?php elseif($displaysetting->deptcflag==3): ?>
                 <option selected value="<?php echo e($displaysetting->deptcflag); ?>"> Both </option>
                 <?php else: ?> <?php endif; ?>
                 <option value="1">English</option>
                    <option value="2">Other Language</option>
                    <option value="3">Both</option>
                    
                        </select>
                       
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <label>Display Column Option (Doctor or Department) : </label>
                        <select id="columnflag" name="columnflag">
                 <?php if($displaysetting->columnflag==1): ?> 
                 <option selected value="<?php echo e($displaysetting->columnflag); ?>">Department Name</option>
                 <?php elseif($displaysetting->columnflag==2): ?> 
                 <option selected value="<?php echo e($displaysetting->columnflag); ?>">Doctor Name</option>
                 <?php elseif($displaysetting->columnflag==3): ?>
                 <option selected value="<?php echo e($displaysetting->columnflag); ?>"> Both </option>
                 <?php else: ?> <?php endif; ?>
                 <option value="1">Department Name</option>
                    <option value="2">Doctor Name</option>
                    <option value="3">Both</option>
                    
                        </select>
                       
                    </div>
                </div>

                

                <div class="row">
                    <div class="col s12">
                        <label>Doctor Name Display in : </label>
                        <select id="doctorflag" name="doctorflag">
                    <option value="<?php echo e($displaysetting->doctorflag); ?>"> <?php if($displaysetting->doctorflag==1): ?> English <?php elseif($displaysetting->doctorflag==2): ?> Other Language <?php elseif($displaysetting->doctorflag==3): ?> Both <?php else: ?> <?php endif; ?>
                    </option>
                    <option value="1">English</option>
                    <option value="2">Other Language</option>
                    <option value="3">Both</option>
                        </select>
                        
                    </div>
                </div>
            
            <!----------------------->
                               
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit">
                                            <?php echo e(trans('messages.update')); ?><i class="mdi-action-swap-vert left"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                </div>
            <!------------------------->
            <div class="col s12 m6">
            <form enctype="multipart/form-data" id="displaybg" action="<?php echo e(route('update_displaybg')); ?>" method="post" >
            <?php echo e(csrf_field()); ?>

             <div class="row">
             <div class="input-field col s12">
             <span style="display:block">Update Display Background Image(size=233px*227px)</span>
             <input id="bgimg" type="file" name="bgimg" value="<?php echo e($displaysetting->bgimg); ?>">
             <button class="btn waves-effect waves-light right" type="submit">
            <?php echo e(trans('messages.update')); ?><i class="mdi-action-swap-vert left"></i></button>
             <div style="width:100px; margin: auto"> <img style="max-width:100%" src="<?php echo e(url('public/displaysetting')); ?>/<?php echo e($displaysetting->bgimg); ?>" > </div>               
            </div>
            </div>
            
           
            </form>
                </div>

            <div class="col s12 m6">
            <form enctype="multipart/form-data" id="displayvideo" action="<?php echo e(route('update_displayvideo')); ?>" method="post" >
            <?php echo e(csrf_field()); ?>

            <div class="row">
            <div class="input-field col s12">
            <span style="display:block">Update Display Video(size=1.14MB maximum)</span>
            <input id="video" type="file" name="video" value="<?php echo e($displaysetting->video); ?>">
            <div style="width:100px; height:100px; margin: auto; overflow-y:hidden;"> <iframe style="max-width:100%; border:none;" src="<?php echo e(url('public/displaysetting')); ?>/<?php echo e($displaysetting->video); ?>" > </iframe> </div>               
            </div>
            </div>

            <div class="row">
             <div class="input-field col s12">
            <button class="btn waves-effect waves-light right" type="submit">
            <?php echo e(trans('messages.update')); ?><i class="mdi-action-swap-vert left"></i>
             </div>
            </div>
             
              </form>
                </div>
            <!------------------------->



                        </div>
                    </div>
                </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    <script>
    //--------------------------
    $("#dsetting").validate({
            rules: {
                textup: {
                    required: true
                },
                textdown: {
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

    //--------------------------
        $(function() {
            $('#department-table').DataTable({
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>