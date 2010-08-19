
<div id="wrap" style="width:600px;">
   <?php echo "<h3>Wordpress Multi-User ad management Plugin</h3>"; ?>
   
  <p> Are you currently an author on this blog? If so, every post you have submitted has the potential to earn revenue. Simply fill in the fields below to activate <b>your</b> ads on <b>your</b> posts! </p>
  <p> This probability of your ads getting displayed on your posts is <strong><?php echo 100-get_usermeta(1 ,'ratio')."%"; ?> </strong>
   
   <?php
    //You may edit the code within this php section to make administrative changes to the script.
	$maximagewidth = 152;
	$maximageheight = 172;
   ?>
   
   <?php 
     global $current_user;
	 get_currentuserinfo();
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
			     echo '</font><font color="green"> Custom campaign will be set to months by default since no choice has been made.</font><font color="red">';
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
			          This feature can be misused to direct SQL injection or deface the site. To revoke acess in the future, go to your wordpress database -> user_meta and remove the key 'approval'.";
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
		
	}
		echo '</div>';	   
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
	?>
	

   <form name="inputform" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <input type="hidden" name="mu_hidden" value="Y">
	  <h3>Current Advertisement Settings for your account</h3>
	  
	  <div style="background: #daf7ad; width: 525px; padding: 10px; margin-top: 8px; margin-bottom: 8px;">
	     <p><label>Email Associated to your paypal (example@yourhost.com):</label><input type="text" name="paypal" value="<?php echo $paypal; ?>" size="70"></p>
	  </div>
	  <input type="submit" name="submit" value="Update paypal settings" />
    </form>
	
	<form name="inputform2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	 <input type="hidden" name="mu_hidden" value="Y">
	  <div style="background: #efecc9; width: 525px; padding: 10px; margin-top: 8px; margin-bottom: 8px;">	  
	     <p><label>Custom Advertisement (http://www.yourhost.com/image.png) (<?php echo $maximagewidth.' X '.$maximageheight;?> max):</label><input type="text" name="custom" value="<?php echo $custom; ?>" size="70"></p>
	     <p><label>Custom Advertisement links to (http://www.targeturl.com):</label><input type="text" name="customlink" value="<?php echo $customlink; ?>" size="70"></p> 
		 <p>
		    <label>Length of Advertising Campaign (Numerical value less than 365):</label><br /> <input type="text" name="customexpire" value="<?php echo $customexpire; ?>" size="3">  
			 <input type="radio" name="customexpired" value="Hours" <?php if($customexpired == "Hours") { echo "Checked";}?> />  Hours
			 <input type="radio" name="customexpired" value="Days" <?php if($customexpired == "Days") { echo "Checked";}?> /> Days
			 <input type="radio" name="customexpired" value="Months" <?php if($customexpired == "Months") { echo "Checked";}?> /> Months
	     </p> 
	   <div style="width: 100%; background: #faf8e0;">	 
	      <p><center><?php if ($custom != "") { echo '<img src="'.$custom.'" alt="If you are seeing this, your Custom URL is not pointing to the correct image!" />'; }?></center>
	   </div>
	 </div>  
	    <input type="submit" name="submit" value="Update custom ad settings" />
  </form>	
  
  <form name="inputform2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	 <input type="hidden" name="mu_hidden" value="Y">
	  <div style="background: #efecc9; width: 525px; padding: 10px; margin-top: 8px; margin-bottom: 8px;">	  
	     <p><label>Your own Code (For items such as adsense):</label></p>
	     <textarea rows="10" cols="69" name="code" <?php if($approval == "" || $approval != 1) { echo 'style="background: #eaeaea;" disabled';}?>><?php print $code;?></textarea>
		 <p><i> In order to activate this feature, you must be approved by the administrator. Approval is needed as, this feature passes unsanitized code to the MySql database.</i></p>
	 </div>  
	    <?php if($approval == "") { echo '<input type="submit" name="submit" value="Request approval" />';} elseif($approval == 1) {echo '<input type="submit" name="submit" value="Update code settings" />';} else { echo '<input type="submit" name="submit" value="Pending approval" disabled style="background:#eaeaea "/>';}?>
  </form>	

  <form name="inputform2" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="mu_hidden" value="Y">
	   <p><label>Which setting do you prefer?</label> 
	        <input type="radio" name="preference" value="Paypal" <?php if($preference == "Paypal") { echo "Checked";}?> /> Paypal
	        <input type="radio" name="preference" value="Custom" <?php if($preference == "Custom") { echo "Checked";}?> /> Custom
			<input type="radio" name="preference" value="Code"  <?php if($preference == "Code") { echo "Checked";} if($approval == "" || $approval != 1) {echo "disabled";}?> /> Code
			<input type="radio" name="preference" value="Disable" <?php if($preference == "Disable") { echo "Checked";}?> /> Disable
	   <br /><input type="submit" name="submit" value="Update Preference settings" style="margin-top:8px;" />
	</form>
	
</div>
   