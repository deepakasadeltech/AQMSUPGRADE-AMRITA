<?php $__env->startSection('title', trans('messages.display.display')); ?>

<?php $__env->startSection('content'); ?>
<input type="text" name="audio_id" id="audio_id" value="<?php echo $audio_call_id; ?>" />
<input type="text" name="audio_last_id" id="audio_last_id" value="<?php echo $last_id; ?>" />
	<!-- display start -->
	<div id="callarea1">

	<div class="dipbox" id="add_dynamic_slider">
	<div class="slider">
    <ul class="slides">
    
     <?php if($data) {?>   
     
	<?php
	foreach($data as $d1)
	{
    ?>
	<li>
<?php	
		foreach($d1 as $d2){
	?>
      
	  <div class="boxrow2" class="caption right-align">
       <!------------first-row-logo-time------------->  
       <div class="row rowbg" style="margin-bottom:0px;">
       <div class="col s8" style="padding:0px;"> 
       <div style="display:none;" class="cstring"><?php echo e(substr($settings->name, 0, 44)); ?></div>     
               <div class="queuelogo displaylogo">
               <span><img src="<?php echo e(url('public/logo')); ?>/<?php echo e($settings->logo); ?>" alt="logo"></span> <span><strong class="first"></strong> <strong class="second"></strong> <strong class="third"></strong></span>
                </div>
            </div>

       <div class="col s4" style="padding:0px;">
       <h1 class="display3heading"> 
            <span class="displaytime displaytime2"><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span> <span class="timestamp"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM'; echo $timestamp = date('h:i:s ').$a; ?> </span> </span> </h1>
        </div>     
       </div> 
       <!------second-row---------->
        <div class="row" style="margin-bottom:0px;">
       <!---------------->     
        <div class="col s2" style="padding:10px 5px 10px 10px;">

        <div class="doctordetaildisplaybox">
          <div class="doctorpbox">  
     <?php if($d2[0]['doctor_photo'] !== NULL): ?><img src="<?php echo e(url('public/doctorimg')); ?>/<?php echo e($d2[0]['doctor_photo']); ?>" alt="User Photo"> 
     <?php else: ?> <img src="<?php echo e(url('public/doctorimg')); ?>/avatar.jpg" alt="Default Image" > <?php endif; ?>
        </div>

         <h1><?php  echo substr($d2[0]['doctor_name'], 0, 20); ?> </h1>
         <h3>( <?php  echo substr($d2[0]['doctor_profile'], 0, 20); ?> )</h3>
         <h2><?php  echo substr($d2[0]['sub_dep'], 0, 11); ?> </h2>
         <h2><?php  echo substr($d2[0]['counter'], 0, 11); ?> </h2>
        
        </div>    
        </div>
        <!------------>
        <!---------start-adv-img-----> 
        <div class="col s6" style="padding:10px 0px 10px 5px;">
    <div class="advertisedisplay">
    <?php if($d2[0]['ads_img'] !== NULL): ?><img src="<?php echo e(url('public/adsimg')); ?>/<?php echo e($d2[0]['ads_img']); ?>" alt="User Photo"> 
     <?php else: ?> <img src="<?php echo e(url('public/adsimg')); ?>/avatar.jpg" alt="Default Image" > <?php endif; ?>
    </div>
        </div>
   
       <!------End-adv-img---------->

        <!------------->
        <div class="col s4" style="padding:0 5px;">
		<table>
		<thead>
		<tr>
        
		<th><span class="spth"><?php echo e(trans('messages.display.dtoken')); ?></span></th>
		<th><span class="spth"><?php echo e(trans('messages.display.roomnumber')); ?></span></th>
		</tr>
		</thead>
		<tbody>

		<?php
		foreach($d2 as $d3) {
            $blinking = '';
            if($d3['view_status'] == 1) { 
            $blinking = 'patcurrentstatus';
            }else{
            $blinking = 'patcurrentstatusb';
            }
		?>
		<tr>
		<td id=""><?php echo '<span class="sptd">'.'<span class="'.$blinking.'"></span>'.$d3['call_number'].'</span>'; ?></td>
		<td id=""><span class="sptd"><?php echo $d3['counter']; ?></span></td>
		</tr>
		<?php } ?>
		</tbody>
        </table>
        </div>
        <!---------->
        </div>
<!----------------------------->
        
		</div>
	<?php
	} 
	?>
	</li>
	<?php
	}
?> <?php }
else{?>
     <li> <div class="datetimeglobal_time" style="background:url(<?php echo e(url('public/displaysetting')); ?>/<?php echo e($displaysetting->bgimg); ?>) no-repeat center; background-size:cover;"><span><?php echo e($displaysetting->textup); ?></span><span><?php echo e($displaysetting->textdown); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span> <span class="gtime"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('h'); $a = $h >= 12 ? 'PM' : 'AM';
             echo $timestamp = date('h:i:s ').$a; ?> </span></div></li>

     <li><div class="datetimeglobal_time">
     <video autoplay loop muted="">
              <source src="<?php echo e(url('public/displaysetting')); ?>/<?php echo e($displaysetting->video); ?>" type="video/webm">
              <source src="<?php echo e(url('public/displaysetting')); ?>/<?php echo e($displaysetting->video); ?>" type="video/mp4">
            </video>

     </div></li>
                          
<?php } ?>
	  </ul>
      <div>

<!------------------------------------------->
    
    <div class="infobox"><span class="esiclogo"><img src="<?php echo e(url('public/logo')); ?>/<?php echo e($settings->logo); ?>" ></span>
    <div id="notitext" class="notitext"> <marquee> <?php echo e($settings->notification); ?> </marquee> </div> <span class="mylogo">Powered By :<strong> ASADEL TECHNOLOGIES (P) LTD</strong></span></div>
    
<!----------------------------------------------->
	
	</div>
	</div>
    <!--display end --->


    <!-------------Notification----------------->
    <div style="display:none;" class="option">
		<label for="voice">Voice</label>
		<select name="voice" id="voice">
        <option selected value="<?php echo e($settings->language->display); ?>"><?php echo e($settings->language->display); ?></option>
        </select>
	</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script type="text/javascript" src="<?php echo e(asset('assets/js/voice.min.js')); ?>"></script>
    <script>
        $(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });

        (function($){
            $.extend({
                playSound: function(){
                  return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".mp3' /><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
                }
            });
        })(jQuery);


 //-------------start-google-voice----------------
 var voiceSelect = document.getElementById('voice');
function loadVoices() {
var voices = speechSynthesis.getVoices();
voices.forEach(function(voice, i) {
var option = document.createElement('option');
 
		option.value = voice.name;
		option.innerHTML = voice.name;
		voiceSelect.appendChild(option);
	});
}
loadVoices();

// Chrome loads voices asynchronously.
window.speechSynthesis.onvoiceschanged = function(e) {
  loadVoices();
};

function speak(text) {
	var msg = new SpeechSynthesisUtterance();
	msg.text = text;
	msg.volume = 8;
	msg.rate = 0.9;
	msg.pitch = 1;
   if (voiceSelect.value) {
		msg.voice = speechSynthesis.getVoices().filter(function(voice) { return voice.name == voiceSelect.value; })[0];
	}
	window.speechSynthesis.speak(msg);
}
 //--------------end-google-voice-------------------       

        function checkcall() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(url('assets/files/display2')); ?>",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    if (curr!=s[0].call_id) {
						
                        /*$("#callarea").fadeOut(function(){
                            $('#num0').html(s[0].number);
                            $("#cou0").html(s[0].counter);
                            $('#num1').html(s[1].number);
                            $("#cou1").html(s[1].counter);
                            $('#num2').html(s[2].number);
                            $("#cou2").html(s[2].counter);
                            $('#num3').html(s[3].number);
                            $("#cou3").html(s[3].counter);
                        });
                        $("#callarea").fadeIn();
						*/
						$('#add_dynamic_slider').html(s[1].html);
						$('.slider').slider({ 
							indicators: false,
							height : 800, // default - height : 400
							interval: 8000 // default - interval: 6000
						});
						if (curr!=0) {							
                            var bleep = new Audio();
                            bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
                            bleep.play();

                            window.setTimeout(function() {
                                msg1 = '<?php echo trans('messages.display.token'); ?> '+s[0].call_number+' <?php echo trans('messages.display.please'); ?> <?php echo trans('messages.display.proceed_to'); ?> '+s[0].counter+'<?php echo trans('messages.display.room'); ?>';
                                //responsiveVoice.speak(msg1, "<?php echo e($settings->language->display); ?>", {rate: 0.85});
                                speak(msg1);
                            }, 800);
                        }
                        curr = s[0].call_id;
						
                    }/*else{
                      //autocall();
                      $('#add_dynamic_slider').html(s[1].html);
						$('.slider').slider({ 
							indicators: false,
							height : 800, // default - height : 400
							interval: 8000 // default - interval: 6000
						});
                    }*/
                }
            });
        }

        window.setInterval(function() {			
            checkcall();
            $("body").addClass('loaded');
			
        }, 4000);

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(url('assets/files/display2')); ?>",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    curr = s[0].call_id;
                }
            });
            checkcall();

       
        });

        window.setInterval(function() {			
          autocall();
			
        }, 8000);

        function autocall()
        {
          var data = 'audio_id='+$('#audio_id').val()+'&audio_last_id='+$('#audio_last_id').val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('auto_call')); ?>",
                data:data,
                cache:false,
               // dataType:'json',
				        success: function(resultData) {
                  rs = resultData.split("@");
                  if(rs[0] == 'PLAY')
                  {
                    $('#audio_id').val(rs[3]);
                    $('#audio_last_id').val(rs[4]);
                    var bleep = new Audio();
                    bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
                    bleep.play();
                    //rs[1] = "P 100"; //call_number
                    //rs[2] = "Room No 344"; //counter
                    //console.log();
                    window.setTimeout(function() {
                    msg1 = '<?php echo trans('messages.display.token'); ?> '+rs[1]+' <?php echo trans('messages.display.please'); ?> <?php echo trans('messages.display.proceed_to'); ?> '+rs[2]+'<?php echo trans('messages.display.room'); ?>';
                    //responsiveVoice.speak(msg1, "<?php echo e($settings->language->display); ?>", {rate: 0.85});
                    speak(msg1);
                    }, 800);
                  }else{
                    $('#audio_id').val(rs[3]);
                    $('#audio_last_id').val(rs[4]);
                  }
                  
               
										
                }
            });
        }
		
//---------------tiripura-only------------------------------------
   $(document).ready(function(){
       var word = $('.cstring').text();
       var first = word.slice(0, 7);
       var second = word.slice(8, 15);
       var third = word.slice(15, 44);
       $('.first').text(first);
       $('.second').text(second);
       $('.third').text(third);
      //alert(first);
   })
 //---------------------------------------------------- 

 function requestFullScreen(element) {
    // Supports most browsers and their versions.
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
        
    }
}

var elem = document.body; // Make the body go full screen.
requestFullScreen(elem);

		
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainappqueue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>