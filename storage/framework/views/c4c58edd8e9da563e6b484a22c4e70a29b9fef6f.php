<?php $__env->startSection('title', trans('messages.mainapp.menu.reports.user_report')); ?>

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
                <span style="line-height:0;font-size:22px;font-weight:300"><?php echo e(trans('messages.reportdetails')); ?></span>
                    <div class="divider" style="margin:15px 0 10px 0"></div>
                    <div class="row">
                        <div class="input-field col s12 m5">
                            <label for="user" class="active"><?php echo e(trans('messages.call.user')); ?></label>
                            <select id="user" class="browser-default">
                                <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.call.user')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                    <option value="<?php echo e($cuser->id); ?>"><?php echo e($cuser->name); ?> -(<?php echo e($cuser->role_text); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </select>
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="sdate"><?php echo e(trans('messages.date')); ?></label>
                            <input id="sdate" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="edate"><?php echo e(trans('messages.date')); ?></label>
                            <input id="edate" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="input-field col s12 m1">
                            <button id="gobtn" class="btn waves-effect waves-light right disabled" onclick="gobtn()"><?php echo e(trans('messages.go')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-------------------------->
<div class="row">
            <div class="col s12">
                <div class="card-panel">
                <span style="line-height:0;font-size:22px;font-weight:300"><?php echo e(trans('messages.doctorreportdate')); ?></span>
                    <div class="divider" style="margin:15px 0 10px 0"></div>
                    <div class="row">
                        
                        <div class="input-field col s12 m3">
                            <label for="asdate"><?php echo e(trans('messages.date')); ?></label>
                            <input id="asdate" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="input-field col s12 m3">
                            <label for="aedate"><?php echo e(trans('messages.date')); ?></label>
                            <input id="aedate" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="input-field col s12 m1">
                            <button id="gobtns" class="btn waves-effect waves-light right disabled" onclick="gobtns()"><?php echo e(trans('messages.go')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-------------------------->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
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

 //-----------------------------------------------------             


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
//--------------------------
        $('#asdate, #aedate').change(function(event){
            var asdate = $('#asdate').val();
            var aedate = $('#aedate').val();

            action = '<?php echo e(url('reports/user')); ?>/'+asdate+'/'+aedate;

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
  //-----------------------------      
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>