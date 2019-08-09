<?php $__env->startSection('title', trans('messages.mainapp.menu.counter')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.ads')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.ads')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <a class="btn-floating waves-effect waves-light tooltipped" href="<?php echo e(route('ads.create')); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.add')); ?> <?php echo e(trans('messages.mainapp.menu.ads')); ?>"><i class="mdi-content-add left"></i></a>
                    <div class="divider" style="margin:15px 0 10px 0"></div>
                    <table id="ads-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.adname')); ?></th>
                                <th><?php echo e(trans('messages.mainapp.menu.ads')); ?> <?php echo e(trans('messages.adimg')); ?></th>
                                <th style="width:63px"><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($ad->name); ?></td>
                                    <td><span class="uphoto"><?php if($ad->adimg !== NULL): ?><img src="<?php echo e(url('public/adsimg')); ?>/<?php echo e($ad->adimg); ?>" alt="User Photo"> 
     <?php else: ?> <img src="<?php echo e(url('public/adsimg')); ?>/avatar.jpg" alt="Default Image" > <?php endif; ?></td>
                                    <td>
                                        <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="<?php echo e(route('ads.edit', ['ads' => $ad->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.edit')); ?>"><i class="mdi-editor-mode-edit"></i></a>
                                        <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="<?php echo e(route('ads.destroy', ['ads' => $ad->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.delete')); ?>" method="DELETE"><i class="mdi-action-delete"></i></a>
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
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    <script>
        $(function() {
            $('#ads-table').DataTable({
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