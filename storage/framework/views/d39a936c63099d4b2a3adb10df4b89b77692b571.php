<?php $__env->startSection('title', trans('messages.mainapp.menu.queuesetting')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.queuesetting')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.queuesetting')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            
        <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content" style="width:100%; float:left;">
                    <!--------------------------------->      
                        <div class="col s12 m6">
                            <form id="dsetting" action="<?php echo e(route('update_kiosktext')); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="texteng"><?php echo e(trans('messages.kiosk.textineng')); ?></label>
                                        <input id="texteng" type="text" name="texteng" placeholder="<?php echo e(trans('messages.kiosk.textineng')); ?>" value="<?php echo e($kiosksetting->texteng); ?>" data-error=".texteng">
                                        <div class="texteng">
                                            <?php if($errors->has('texteng')): ?><div class="error"><?php echo e($errors->first('texteng')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="textotherlang"><?php echo e(trans('messages.kiosk.textinother')); ?></label>
                                        <input id="textotherlang" type="text" name="textotherlang" placeholder="<?php echo e(trans('messages.kiosk.textinother')); ?>" value="<?php echo e($kiosksetting->textotherlang); ?>" data-error=".textotherlang">
                                        <div class="textotherlang">
                                            <?php if($errors->has('textotherlang')): ?><div id="textotherlang-error" class="error"><?php echo e($errors->first('textotherlang')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>Display Department Name In : </label>
                                    <select id="deptflag" name="deptflag">
                                    <option selected value="<?php echo e($kiosksetting->deptflag); ?>">
                                    <?php if($kiosksetting->deptflag==1): ?>  English
                                    <?php elseif($kiosksetting->deptflag==2): ?> Other Language
                                    <?php elseif($kiosksetting->deptflag==3): ?> Both <?php else: ?> English <?php endif; ?></option>
                                    
                                    <option value="1">English</option>
                                    <option value="2">Other Language</option>
                                    <option value="3">Both</option>

                                    </select>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>Token Display (Department Wise/Doctor Wise) : </label>
                                    <select id="tokendisplay" name="tokendisplay">
                                    <option selected value="<?php echo e($kiosksetting->tokendisplay); ?>">
                                    <?php if($kiosksetting->tokendisplay==1): ?>  Department Wise
                                    <?php elseif($kiosksetting->tokendisplay==2): ?> Doctor Wise
                                     <?php else: ?> Department Wise <?php endif; ?></option>
                                    <option value="1">Department Wise</option>
                                    <option value="2">Doctor Wise</option>
                                    </select>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>In Doctor Wise Token Display Style View : </label>
                                    <select id="dr_tokenstyle" name="dr_tokenstyle">
                                    <option selected value="<?php echo e($kiosksetting->dr_tokenstyle); ?>">
                                    <?php if($kiosksetting->dr_tokenstyle==1): ?>  Department With Doctor
                                    <?php elseif($kiosksetting->dr_tokenstyle==2): ?> Only Doctor
                                     <?php else: ?>  <?php endif; ?></option>
                                    <option value="1">Department With Doctor</option>
                                    <option value="2">Only Doctor</option>
                                    </select>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="col s12">
                                    <label>Registration Block Required (Yes/NO) : </label>
                                    <select id="reg_required" name="reg_required">
                                    <option selected value="<?php echo e($kiosksetting->reg_required); ?>">
                                    <?php if($kiosksetting->reg_required==1): ?>  YES
                                    <?php elseif($kiosksetting->reg_required==2): ?> NO
                                     <?php else: ?>  <?php endif; ?></option>
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                    </select>
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
        <!---------------------------------------->
        <div class="col s12 m6">
            <form enctype="multipart/form-data" id="displaykiosk" action="<?php echo e(route('update_kioskbg')); ?>" method="post" >
            <?php echo e(csrf_field()); ?>

             <div class="row">
             <div class="input-field col s12">
             <span style="display:block"><?php echo e(trans('messages.kiosk.kioskbgimg')); ?>(size=1920px*1080px)</span>
             <input id="bgimg" type="file" name="bgimg" value="<?php echo e($kiosksetting->bgimg); ?>">
             <button class="btn waves-effect waves-light right" type="submit">
            <?php echo e(trans('messages.update')); ?><i class="mdi-action-swap-vert left"></i></button>
             <div style="width:100px; margin: auto"> <img style="max-width:100%" src="<?php echo e(url('public/kiosksetting')); ?>/<?php echo e($kiosksetting->bgimg); ?>" > </div>               
            </div>
            </div>
            
           
            </form>
                </div>
        <!---------------------------------------->                   


                        </div>
                    </div>
                </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    <script>
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