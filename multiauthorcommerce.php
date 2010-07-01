<?php
/*
Plugin Name: Wordpress Multiple Author Ad management
Plugin URI: http://www.ravall.com/2010/06/28/wordpress-multiple-user-ad-management-plugin/
Description: On ad-enabled blogs with multiple authors, this plugin allows users to display ads or donate money through paypal on their own posts. This plugin will provide an incentive for approved users to post quality content.
Version: 1.0.1
Author: Manthan Raval
Author URI: http://www.ravall.com
License: GPL2
*/

function mu_admin() {
  include('adminpanel.php');
}

function administrative_options() {  
   add_menu_page("MU Ad management", "MU Ad management", 2, "MU Ad management", "mu_admin");  
}  

add_action('admin_menu', 'administrative_options');  

function remove_expired($user,$MDH) {
   $expire_time = get_usermeta($user,'expiry_time');
   $type = get_usermeta($user,'customexpired');
   
   if ($MDH == "Hours") {
      $currentime = date('y:m:d:H');
   }
   else {
      $currentime = date('y:m:d');
   }
   if ($currentime > $expire_time) { 
	  update_usermeta($user, 'preference',"Disable");
   }
}


function mu_sidebar($userid=1) {

if($userid == "") {
  $userid = 1;
}

 $preference = get_usermeta($userid,'preference');
 $error = "<h4><center> Whoops, the user has not properly setup the ad management system! Although I see a configuration in the database, the settings are blank. </center></h4>";
 
 if ($preference == "Paypal") {
    $paypal = get_usermeta($userid,'paypal');
    if ($paypal!="") {
	  echo 
	  '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
         <input type="hidden" name="cmd" value="_donations" />
         <input type="hidden" name="business" value="'.$paypal.'" />
         <input type="hidden" name="lc" value="US" />
         <input type="hidden" name="item_name" value="Site Author donation" />
         <input type="hidden" name="no_note" value="0" />
         <input type="hidden" name="currency_code" value="USD" />
         <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest" />
         <input type="image" src="/wp-content/plugins/wordpress-multiple-user-ad-management/paypal.png" name="submit" alt="PayPal - The safer, easier way to pay online!" />
         <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" />
       </form>';
	}
	else {
	   echo $error;
	}
 }
 elseif ($preference == "Custom") {
    $custom = get_usermeta($userid,'custom');
	$customlink = get_usermeta($userid,'customlink');
	$customexpire = get_usermeta($userid,'customexpire');
	$expiretiming = get_usermeta($userid,'customexpired');
	  if ($custom != "") {
	    if($customexpire != "") {
	      remove_expired($userid,$expiretiming);
	    }
	    echo '<a href="'.$customlink.'"><img src="'.$custom.'" alt="If you are seeing this, your Custom URL is not pointing to the correct image!" /></a>';
	  }  
	else {
	  echo $error;
	  
	}
  }
 elseif ($preference == "Disable") {
    echo "<h4><center> The user has decided that they do not need to be rewarded for their hard work on this site. The advertising system has been disabled...</center></h4>";
  }
 elseif ($preference == "Code") {
   echo get_usermeta($userid,'code');
 }
 else {
   echo $error;
  }
  
 }

 


?>
