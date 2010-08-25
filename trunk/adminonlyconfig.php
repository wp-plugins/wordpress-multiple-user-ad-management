<div id="wrap" style="width:700px;">
 <?php echo "<h3>Multiple Author Ad management Administrative settings </h3>"; ?>
 
 <?php 

  if ($_POST['submit'] != "") {
  
    if($_POST['ratio'] <= 100 && is_numeric($_POST['ratio'])) {
	 $ratior = $_POST['ratio'];
     update_usermeta(1, 'ratio' ,$ratior);
	}
	else {
	 echo "There is a problem with the input you entered for the ratio field! (Should be <= 100) & numeric <br/>";
	}
	
	switch ($_POST['capabilities'] ) {
	  case 1:
	    update_usermeta(1, 'capabilities' ,'delete_posts');
	    break;
	  case 2:
	    update_usermeta(1, 'capabilities' ,'delete_published_posts');
	     break;
	  case 3:
	    update_usermeta(1, 'capabilities' ,'read_private_pages');
	     break;
	  case 4:
	    update_usermeta(1, 'capabilities' ,'edit_dashboard');
	     break;
	}
	
	if($_POST['default'] != "" && is_numeric($_POST['default'])) {
	 $default = $_POST['default'];
     update_usermeta(1, 'default' ,$default);
	}
	else {
	  echo "The default userid should be numeric <br/>";
	}
	
   if($_POST['removeads'] != "") {
	 $removeads = $_POST['removeads'];
     update_usermeta(1, 'removeads' ,$removeads);
	}
   
   if(isset($_POST['legacy'])) {
      $legacy = $_POST['legacy'];
      update_usermeta(1,'mu_legacy',$legacy);
    }
   
  }
  
 ?>
 
 <?php
    $ratio =  get_usermeta(1 ,'ratio');   
    if ($ratio == "") {
	 $ratio = 0;
	}
	
	$capabilities = get_usermeta(1,'capabilities');
	
	$default = get_usermeta(1,'default');
	  if ($default == "") {
	    $default = 1;
	  }
	
	$removeads = get_usermeta(1, 'removeads');
	$legacy = get_usermeta(1,'mu_legacy');
 ?>

 
 <form name="inputform" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
   <p>
     <label><b>Numerical advertisement rotation ratio:  </b> </label><input type="text" name="ratio" value="<?php echo $ratio;?>" size="3" >%
	  <br />
      For example, a value of 50 into this field means that your advertisements will be displayed 50% of the time on other author's posts.
	  The default value is 0, meaning that the author's ads will be displayed 100% of the time.
   </p>
   
   <p>
     <label><b>Ad management available to:  </b> </label>
     <select name="capabilities" size="1">
        <option value="1" <?php if($capabilities == 'delete_posts') {echo 'selected="select"';} ?> >Contributors and above</option>
        <option value="2" <?php if($capabilities == 'delete_published_posts') {echo 'selected="select"';} ?> >Authors and above</option>
        <option value="3" <?php if($capabilities == 'read_private_pages') {echo 'selected="select"';} ?>>Editors and above</option>
        <option value="4" <?php if($capabilities == 'edit_dashboard') {echo 'selected="select"';} ?>>Administrators and above</option>
     </select>
	  <br />
      The ad management settings will only be displayed to users who meet the minimum role requirement. For example, if the 'Authors and 
      above' option is chosen, contributors will not be able to access the ad management panel.
   </p>
   
    <p style="border: 1px solid; background: #fff; padding: 5px;">
      <label><b>Enable Legacy Mode:</b> </label>
      <input type="radio" name="legacy" value="Yes" <?php if($legacy == "Yes") { echo "Checked";}?> /> Yes
	  <input type="radio" name="legacy" value="" <?php if($legacy == "") { echo "Checked";}?> /> No	
	  <br />
	  If users are unable to view the ad management settings from the navigation bar, you may need to enable legacy 
	  mode. Instead of using Wordpress capabilities, the plugin will make use of Wordpress Roles (ex. Subscribers = 1, Administrators = 
	  10).
    </p>
    
    <p>
     <label><b>Default advertisement user id:  </b> </label><input type="text" name="default" value="<?php echo $default;?>" size="3" maxlength="8" >
	  <br />
      Entering a userid in the field above will set it as the default. This means that on pages where no author is present (main page), or pages 
      where the author may not have properly configured ad management settings, advertisements from the default account will be displayed. If you 
      unsure, leave the value in this field as 1. This corresponds to the original Wordpress Administrator account.
   </p>
   
    <p>
     <label><b>Disable advertisements for logged in users:</b> </label>
       <input type="radio" name="removeads" value="Yes" <?php if($removeads == "Yes") { echo "Checked";}?> /> Yes
	   <input type="radio" name="removeads" value="No" <?php if($removeads == "No" || $removeads == "") { echo "Checked";}?> /> No
	  <br />
      Offer regular visitors to your site an incentive to register. If yes is selected, users that are logged in will not see advertisements on 
      the site.
   </p>
       
   <input type="submit" name="submit" value="Update Administrative settings"  />
 </form>
 
 
 <!-- No love for the developer? =( -->
 <div style="margin-top: 40px; padding: 10px; border: 1px solid #ccc; background: #e6e6e6; height: 55px;">
  
   <form action="https://www.paypal.com/cgi-bin/webscr" method="post" >
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="JCJNDNRVPLGUN">
      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="float:left;">
      <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    <p>
      Liked the plugin? If you wish, you can help me out with my university expenses by donating even as little as $1 through PayPal. 
      Support is much appreciated =)
    </p>
 </div>
 
 </div>
 
