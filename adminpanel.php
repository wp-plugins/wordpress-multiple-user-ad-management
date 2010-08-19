<!-- Javascript for graph -->
  <script type="text/javascript" src="<?php echo WP_PLUGIN_URL?>/wordpress-multiple-user-ad-management/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo WP_PLUGIN_URL?>/wordpress-multiple-user-ad-management/js/jqBarGraph.js"></script>

<!-- Javascript for collapsable Divs -->
 <script type="text/javascript" src="<?php echo WP_PLUGIN_URL?>/wordpress-multiple-user-ad-management/js/slider/expand.js"></script>
 <script type="text/javascript">
          $(function() {
               $("div.expand").toggler();    
               $("#wrap").expandAll({trigger: "div.expand", ref: "div.demo", localLinks: "p.top a"});
             });
  </script>
  
<style type="text/css">
 #wrap a { 
   text-decoration: none;
   font-size: 13px;
   color: #000;
   margin-bottom: 15px;
   }
 .div {
   background: #f0f0f0; 
   width: 525px; 
   padding: 10px;
   margin-bottom: 8px;
 }
 
 /*Sliding Menu Div */
.expand a {
  display:block;
  padding: 4px;
  width: 534px;
  color: #000;
  font-size: 14px;
  margin-bottom: 10px;
}

.expand a:link, .expand a:visited {
  border-width:1px;
  background-image:url(../images/arrow-down.gif);
  background-repeat:no-repeat;
  background-position:98% 50%;
  border: 1px dotted #ccc; 
}


.expand a.open:link, .expand a.open:visited {
  background: url(../images/arrow-up.gif) no-repeat 98% 50%;
}
</style>

<div id="wrap" style="width:600px;">
   
   <?php
    //You may edit the code within this php section to make administrative changes to the script.
	$maximagewidth = 250;
	$maximageheight = 250;
   ?>
   
   <?php 
     global $current_user;
	 get_currentuserinfo();
	?>
	
	<?php function graph ($user) {
	 
	 $impressions = get_usermeta($user,'adimpressions');
	 $clicks = get_usermeta($user,'adclicks');
	   if ($impressions ==  '') {
	    $impressions = 0;
	   }   
	   
	   if ($clicks == '') {
	    $clicks = 0;
	   }
	 echo "
      <div id='graph'></div>
       <script>
          stats = new Array(
              [$clicks,''],
		      [$impressions,'']);

          $(\"#graph\").jqBarGraph({
	          data: stats,
	          colors: ['#abaaaa','#989797'],
	          width: 500,
	          height: 100,
	          color: '#ffffff',
	          barSpace: 10,
	          type: 'simple',
	          postfix: '',
	          title: '' }); 
        </script>";	
	  }
	?>
	
	<?php
	
     function isValidURL($url) {
     
	  if ($url != "") {
      
      if (!ereg("^https?://",$url)) {
         $result = 0;
      } else {
         if (@fopen($url,"r")) {
			$result = 1;
        } else {
            $result = 2;
        }
     }
     } else {
       $result = 3;
     }
	 return $result;
   }
	?>
	
	<?php
	function isValidemail($email) {
	   // checks proper syntax
       if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
         return true;
		 }
	   else {
	     return false;
	   } 
	}
	?>
	
	<?php
	function validate_custom($image,$maximagewidth1,$maximageheight1) {
	  if(isValidURL($image) == 1 && $image != "")  {
	     list($width, $height, $type, $attr) = getimagesize($image);
	     if (is_numeric($width) && is_numeric($height)) {
		   if ($width <= $maximagewidth1 && $height <= $maximageheight1) {
		    $valide = 1;
			}
		   else{
		    $valide = 4; 
			}
		 }
		 else {
		  $valide = 4;
		 }
	  }
	  elseif ($image =="") {
		$valide = 4;
	  }
	  else {
	    $valide = 4;
	  }
	  return $valide;
	 }
	?>
	
	<?php
	 function expiry_time($campaign,$type) {
	   if($type == "Months") { 
	     return date('y:m:d', strtotime("+$campaign months")); 
		 }
	   if($type == "Days") {
		 return date('y:m:d', strtotime("+$campaign days"));
	   }
	   if($type == "Hours") {
	      return date('y:m:d:H', strtotime("+$campaign Hours"));	  
	   }
	 }
	 ?>
	 	
	<?php
     if($_POST['mu_hidden'] == 'Y') {
       echo '<div style="border: 1px dotted #000; width: 525px; padding: 10px; margin-top: 8px; margin-bottom: 8px;">';	 
       //Form data updated here   
	   if($_POST['paypal'] != ""){
	      $paypal = strip_tags($_POST['paypal']);
	      if (isValidemail($paypal)) {
             update_usermeta($current_user->ID, 'paypal', $paypal);  
		     echo "Paypal Email Address has been entered into the system. <br />";
		  }
		  else {
		     echo "<b>Paypal Email Address is not correct. Please enter a valid email</b><br />"; 
		  }
	   }
		
        if (validate_custom($_POST['custom'],$maximagewidth,$maximageheight) == 1 ) {
 		  echo "The URL pointing to your custom image is valid and updated <br /> ";
		     $custom = strip_tags($_POST['custom']);  
             update_usermeta($current_user->ID, 'custom', $custom); 
		}
		elseif (validate_custom($_POST['custom'],$maximagewidth,$maximageheight) != 1 && $_POST['custom'] != "") {
		    echo "<b>There is a problem with the URL pointing to your custom image.</b><br />";
		}
		
		if (isValidURL($_POST['customlink']) == 1) {
		  echo 'The target URL that your custom image points to has been updated. <br />';
		  $customlink = strip_tags($_POST['customlink']);  
          update_usermeta($current_user->ID, 'customlink', $customlink); 
		}
		elseif (isValidURL($_POST['customlink']) != 1 && $_POST['customlink'] != "") {
		   echo "<b>There is a problem with your custom advertisement link.</b> <br />";
		}
		
		if(is_numeric($_POST['customexpire']) && $_POST['customexpire'] != "") {
		  if ( $_POST['customexpire'] <= 365 ) {
		    $customexpire = strip_tags($_POST['customexpire']);
		    update_usermeta($current_user->ID, 'customexpire', $customexpire);  
			echo "The expiry time of custom advertising campaign has been updated. <br />";
			
		      if (  $_POST['customexpired'] != "") {
			     echo '</font><font color="green"> ~~~>The custom Campaign has been set to: '.$_POST['customexpired'].'</font>';
				 $customexpired = strip_tags($_POST['customexpired']);
		         update_usermeta($current_user->ID, 'customexpired', $customexpired); 
			  }
			  else {
			     echo '</font><font color="green"> Custom campaign will be set to months by default since no choice has been made.</font>';
			     $customexpired = "Months";
		         update_usermeta($current_user->ID, 'customexpired', $customexpired); 
			 }
			   $exp_time = expiry_time($customexpire,$customexpired);
		       update_usermeta($current_user->ID, 'expiry_time', $exp_time);
			 
		  }
		  else {
		     echo "<b>The value entered for the length of advertising campaign should be less than 365</b> <br />";  
		  } 
		}
	   elseif($_POST['customexpire'] != "")  {
		  echo "<b>The value entered for the length of advertising campaign should be numeric!</b> <br />";
		}
		
		if ($_POST['preference'] != "") {
		    $preferences = $_POST['preference'];
		    update_usermeta($current_user->ID, 'preference', $preferences);  
		    echo "Your ad preferences have been updated.";
		}
		
		if ($_POST['submit'] == "Request approval") {
		     $path = WP_PLUGIN_URL;
			 $admin_email = get_settings('admin_email');
		     
			 $mail = "<p>User <b>".$current_user->user_nicename." (".$current_user->user_email.")</b> is requesting activation of the code feature in the MultiUser Ad system Script.</p>";
		     $mail .= "<br/>If you are confident that this user is trustable, please click on the link below to enable access to the code feature. The user will be able to input his own PHP and HTML code into the website. 
			          This feature can be misused to direct SQL injection or deface the site. To revoke access in the future, go to your wordpress database -> user_meta and remove the key 'approval'.";
			 $mail .= "<br /><br />Click on the following link to activate access: <a href=".$path."/wordpress-multiple-user-ad-management/verify.php?pkey=".$current_user->user_pass."&id=".$current_user->ID.">".$path."/wordpress-multiple-user-ad-management/verify.php?pkey=".$current_user->user_pass."&id=".$current_user->ID."</a>";
			 
			 $headers = "From: $admin_email\r\n"; 
			 $headers .= "MIME-Version: 1.0\r\n";
             $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			 $mail_sent = @mail( $admin_email,"User Requesting Code field Approval", $mail, $headers );
			 echo $mail_sent ? "Mail has been sent to the administrator." : "Mail failed to the administrator. This is probably due to incorrect SMTP settings.";
			 if ($mail_sent) {   update_usermeta($current_user->ID, 'approval', 2); };
			 
		 }
		elseif ($_POST['submit'] == "Update code settings") {
		  $code = $_POST['code'];
	      update_usermeta($current_user->ID, 'code', $code);  
		  echo "Code settings have been updated for this account.";
		}
	
	  if($_POST['submit'] == "Clear Statistics") {
		  update_usermeta($current_user->ID, 'adclicks',0);
		  update_usermeta($current_user->ID, 'adimpressions',0);
		  echo "Statistics have been cleared.";
		}
		
	  if($_POST['submit'] == "Update text link settings") {
	      $texttitle =  strip_tags($_POST['texttitle']);
	      update_usermeta($current_user->ID, 'texttitle', $texttitle);
	      echo 'The text link title has been updated. <br />';
		  if (isValidURL($_POST['textlink']) == 1) {
		    echo 'The target URL that your text link points to has been updated. <br />';
		    $textlink = strip_tags($_POST['textlink']); 
            update_usermeta($current_user->ID, 'textlink', $textlink); 
		}
		else {
		   echo "<b>There is a problem with the url of your text link.</b> <br />";
		} 
	  }
	  echo '</div>';		
	}
		   
    ?>  
    
	
	<?php
	
	       $paypal = get_usermeta($current_user->ID ,'paypal');
		   $preference = get_usermeta($current_user->ID ,'preference');
		   $custom = get_usermeta($current_user->ID ,'custom');
		   $customlink = get_usermeta($current_user->ID ,'customlink');
           $customexpire = get_usermeta($current_user->ID ,'customexpire');
		   $customexpired =  get_usermeta($current_user->ID ,'customexpired');   
		   $approval = get_usermeta($current_user->ID ,'approval');  
		   $code = get_usermeta($current_user->ID ,'code');
		   $textlink = get_usermeta($current_user->ID ,'textlink');
		   $texttitle = get_usermeta($current_user->ID ,'texttitle');
		   $default = get_usermeta(1,'default');
	?>
	
	
  <?php echo "<h3>Wordpress Multi-User ad management Plugin</h3>"; ?>
   
  <p> 
   Are you currently an author on this blog? If so, every post you have submitted has the potential to earn revenue. Simply fill in the fields 
   below to activate <b>your</b> ads on <b>your</b> posts! 
  </p>
  
  <p>
   <?php
    if ($current_user->ID == $default) {
      echo "You are the <font color='green'>default</font> user and thus, your ads will be displayed <strong>100%</strong> of the time on your posts";
    }
    else{
      $probability = 100-get_usermeta(1 ,'ratio');
      echo "The probability of your ads getting displayed on your posts is <strong>".$probability."% </strong>";
    }
   ?>
  
  </p>
	
    <div style="background: #f0f0f0; padding: 12px; width: 522px;">
     <h3>Clicks Vs. Impressions Graph</h3>
      <div style="margin-bottom: 15px;">
         The graph below depicts the number of clicks and impressions your advertisements have received.
         <strong>Click count is only enabled for custom image and text link type advertisements</strong>. The number of 
         impressions your advertisements receive will still be tracked regardless of the advertisement type. <font color="red">The 
         statistics will clear when you press the clear now button</font>
      </div>
      <div style=" border-left: 1px solid #707070; border-bottom: 1px solid #707070; width: 520px;">
        <?php graph($current_user->ID); ?> 
      </div>
     </div>
   
   <form name="inputform3" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
       <input type="hidden" name="mu_hidden" value="Y">
	   <input type="submit" name="submit" value="Clear Statistics" style="margin-bottom: 8px; margin-top: 8px;" />
	</form>
 
  <div class="demo">
	
   <h3>Current Advertisement Settings for your account</h3>
	
   <div class="expand">Advertisement Type 1: Custom Image Advertisement (Click Tracking <font color="green">Enabled</font>)</div>
   <div class="collapse">
     <form name="inputform2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	   <input type="hidden" name="mu_hidden" value="Y">
	   <div class="div">	  
	     <p>
	      <label>
	       Custom Advertisement (http://www.yourhost.com/image.png) (<?php echo $maximagewidth.' X '.$maximageheight;?> max):
	      </label> 
	      <input type="text" name="custom" value="<?php echo $custom; ?>" size="50">
	     </p>
	     <p>
	      <label>
	        Custom Advertisement links to (http://www.targeturl.com):
	      </label>
	      <input type="text" name="customlink" value="<?php echo $customlink; ?>" size="50">
	     </p> 
		 <p>
		   <label>
		     Length of Advertising Campaign:
		   </label>
		  
		   <input type="text" name="customexpire" value="<?php echo $customexpire; ?>" size="3">  
		   <input type="radio" name="customexpired" value="Hours" <?php if($customexpired == "Hours") { echo "Checked";}?> />  Hours
		   <input type="radio" name="customexpired" value="Days" <?php if($customexpired == "Days") { echo "Checked";}?> /> Days
		   <input type="radio" name="customexpired" value="Months" <?php if($customexpired == "Months") { echo "Checked";}?> /> Months
		   
		   <p>
		     If you do not wish to set an expiration date, leave the fields below blank or enter a value of zero.
		     Otherwise, ensure the value input into the field above is less than or equal to 365
		   </p>
	     </p> 
	     <div style="width: 100%;">	 
	      <p>
	        <center>
	          <?php 
	            if ($custom != "") { 
	               echo '<img src="'.$custom.'" alt="If you are seeing this, your Custom URL is not pointing to the correct image!" />'; }
	          ?>
	        </center>
	     </div>
	   </div>  
	   <input type="submit" name="submit" value="Update custom ad settings" style="margin-bottom: 8px" />
     </form>	
    </div>
  
  
   <div class="expand">Advertisement Type 2: Simple text link (Click Tracking <font color="green">Enabled</font>)</div>
   <div class="collapse">
     <form name="inputform4" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
         <input type="hidden" name="mu_hidden" value="Y">
	     <div class="div">
	        <p>
	          <label>
	            Text link title (My Text Link):
	          </label>
	          <br />
	          <input type="text" name="texttitle" value="<?php echo $texttitle; ?>" size="50" />
	        </p>
	        <p>
	          <label>
	            Url of textlink (http://www.targeturl.com):
	          </label>
	          <br />
	          <input type="text" name="textlink" value="<?php echo $textlink; ?>" size="50">
	        </p>
	    </div>
	    <input type="submit" name="submit" value="Update text link settings" style="margin-bottom: 8px;" />
    </form>
   </div>
  
  <div class="expand">Advertisement Type 3: Paypal Donations Button (Click Tracking <font color="red">Disabled</font>)</div>
  <div class="collapse">
   <form name="inputform" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <input type="hidden" name="mu_hidden" value="Y" />  
	  <div class="div">
	     <p>
	       <label>
	          Email Associated to your paypal for donations (example@yourhost.com):
	       </label>
	       <input type="text" name="paypal" value="<?php echo $paypal; ?>" size="50" />
	     </p>
	  </div>
	  <input type="submit" name="submit" value="Update paypal settings" style="margin-bottom: 8px;" />
   </form>
  </div>
  
  <div class="expand">Advertisement Type 4: Adsense Code (Click Tracking <font color="red">Disabled</font>)</div>
  <div class="collapse">
      <form name="inputform2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	  <input type="hidden" name="mu_hidden" value="Y">
	  <div class="div">	  
	     <p>
	      <label>
	        Your own Code (For items such as Adsense):
	      </label>
	     </p>
	     <textarea rows="10" cols="59" name="code" <?php if($approval == "" || $approval != 1) { echo 'style="background: #eaeaea;" disabled';}?>>
	       <?php print $code;?>
	     </textarea>
		 <p>
		   <i> 
		       In order to activate this feature, you must be approved by the administrator. Approval is needed as, this feature passes 
		       unsanitized code to the MySql database.
		   </i>
		 </p>
	 </div>  
	    <?php 
	     if($approval == "") {
	       echo '<input type="submit" name="submit" value="Request approval" />';}
	       elseif($approval == 1) {echo '<input type="submit" name="submit" value="Update code settings" />';} 
	       else { echo '<input type="submit" name="submit" value="Pending approval" disabled style="background:#eaeaea "/>';}
	    ?>
  </form>
 </div>	
    

  <form name="inputform2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="mu_hidden" value="Y">
	   <p>
	     <label>Which setting do you prefer?</label> 
	     <input type="radio" name="preference" value="Paypal" <?php if($preference == "Paypal") { echo "Checked";}?> /> Paypal
	     <input type="radio" name="preference" value="Custom" <?php if($preference == "Custom") { echo "Checked";}?> /> Custom Image Ads
	     <input type="radio" name="preference" value="Code"  <?php if($preference == "Code") { echo "Checked";} if($approval == "" || $approval != 1) {echo "disabled";}?> /> Code
	     <input type="radio" name="preference" value="Textlink"  <?php if($preference == "Textlink") { echo "Checked";}?> /> Textlink
		 <input type="radio" name="preference" value="Disable" <?php if($preference == "Disable") { echo "Checked";}?> /> Disable
	     <br />
	     <input type="submit" name="submit" value="Update Preference settings" style="margin-top:8px;" />
	   </p>
	</form>
	
 </div>	
</div>

   