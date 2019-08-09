<?php $__env->startSection('title', trans('messages.mainapp.menu.updatelimitdata')); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.updatelimitdata')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.updatelimitdata')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<!--------------------->
    <div class="container">
        <div class="row">
            
        <div class="col s12 m12">
                    <div class="card">
                        <div class="card-content">
                <!-------------------------------->        
                         <div class="col s12 m12">
                 <div class="formblock">   <!----start-form-block------->            
            <form id="limitsetting" action="<?php echo e(route('update_limitdata')); ?>" method="post" >
                            <?php echo e(csrf_field()); ?>


                            <div class="superadminformblock">
                                <ul>
                                <li> <div class="fblock"> 
                                    <span><?php echo e(trans('messages.ndoctor')); ?></span>
                                    <span><input id="doctor" type="text" name="doctor" placeholder="<?php echo e(trans('messages.name')); ?>" value="<?php echo e($datalimits->doctor); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.nuser')); ?></span>
                                    <span><input id="user" type="text" name="user" placeholder="<?php echo e(trans('messages.nuser')); ?>" value="<?php echo e($datalimits->user); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.ncmo')); ?></span>
                                    <span><input id="cmo" type="text" name="cmo" placeholder="<?php echo e(trans('messages.ncmo')); ?>" value="<?php echo e($datalimits->cmo); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.ndisplayctrl')); ?></span>
                                    <span><input id="displayctrl" type="text" name="displayctrl" placeholder="<?php echo e(trans('messages.ndisplayctrl')); ?>" value="<?php echo e($datalimits->displayctrl); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.nhelpdesk')); ?></span>
                                    <span><input id="helpdesk" type="text" name="helpdesk" placeholder="<?php echo e(trans('messages.nhelpdesk')); ?>" value="<?php echo e($datalimits->helpdesk); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.ndepartment')); ?></span>
                                    <span><input id="pdepartment" type="text" name="pdepartment" placeholder="<?php echo e(trans('messages.ndepartment')); ?>" value="<?php echo e($datalimits->pdepartment); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span> <?php echo e(trans('messages.nsupdepartment')); ?></span>
                                    <span><input id="department" type="text" name="department" placeholder="<?php echo e(trans('messages.nsupdepartment')); ?>" value="<?php echo e($datalimits->department); ?>"></span>
                                    </div>
                                </li>
                                
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.nroom')); ?></span>
                                    <span><input id="room" type="text" name="room" placeholder="<?php echo e(trans('messages.nroom')); ?>" value="<?php echo e($datalimits->room); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.nads')); ?></span>
                                    <span><input id="ads" type="text" name="ads" placeholder="<?php echo e(trans('messages.nads')); ?>" value="<?php echo e($datalimits->ads); ?>"></span>
                                    </div>
                                </li>
                                <li><div class="fblock">
                                    <span><?php echo e(trans('messages.ntokenperday')); ?></span>
                                    <span><input id="tokenperday" type="text" name="tokenperday" placeholder="<?php echo e(trans('messages.ntokenperday')); ?>" value="<?php echo e($datalimits->tokenperday); ?>"></span>
                                    </div>
                                </li>
                                </ul>
                            <div class="submitlimitbtn">
                            <button class="btn waves-effect waves-light" type="submit">
                                            <?php echo e(trans('messages.update')); ?><i class="mdi-action-swap-vert left"></i>
                                        </button>
                            </div>

                            </div>



                </div>   <!----End-form-block-------> 
            </form>


                         </div>
                <!-------------------------------->          
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