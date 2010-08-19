<?php
/*
Plugin Name: Wordpress Multiple Author Ad management
Plugin URI: http://www.ravall.com/2010/06/28/wordpress-multiple-user-ad-management-plugin/
Description: On ad-enabled blogs with multiple authors, this plugin allows users to display ads or donate money through paypal on their own posts. This plugin will provide an incentive for approved users to post quality content.
Version: 1.0.3
Author: Manthan Raval
Author URI: http://www.ravall.com
License: GPL2
*/

function mu_admin() {
  include('adminpanel.php');
}

function mu_admin_settings() {
  include('adminonlyconfig.php');
}

function administrative_options() {  
   $capabilities = get_usermeta(1,'capabilities');
   if ($capabilities == '') {
    $capabilities = "delete_published_posts";
   }
   add_menu_page("MU Ad management", "Ad Settings",$capabilities, "MU_Ad_management", "mu_admin");  
   add_submenu_page("MU_Ad_management", "Administrative_Management", "Admin settings",'manage_options', "Administrative_Management", "mu_admin_settings"); 
	
}  

//This function is used to record the number of impressions an ad recieves
function mu_impressions($user) {
  $impressions = get_usermeta($user,'adimpressions');
  $impressions++;
  update_usermeta($user, 'adimpressions',$impressions);


}

add_action('admin_menu', 'administrative_options');  

function probability($chance, $out_of = 100) {
    $random = mt_rand(1, $out_of);
    if ($random >= $chance) {
	  return 1;
	}
}

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

function userid() {
 if (get_usermeta(1,'default') == "") {
  return 1;
 }
 else {
  return get_usermeta(1,'default');
 }
}

//The main function. This is what you called from the sidebar. 
//If you are experiencing issues with user ads not showing up, test to see if $userid is getting any data!
//When the mu_sidebar function is called before the wordpress loop, $userid does not recieve any information and has a default value of 0!

function mu_sidebar($userid) {

$disableads = get_usermeta(1, 'removeads' ,$removeads);
if (is_user_logged_in() && $disableads == "Yes") {
  return 0;
}

if (probability(100-get_usermeta(1 ,'ratio')) || is_home() ) {
  $userid = userid();
}

 $clicktrack = WP_PLUGIN_URL.'/wordpress-multiple-user-ad-management/ads.php';
 $preference = get_usermeta($userid,'preference');
 
 if ($preference == "Disable" || $preference == "") {
   $userid = userid();
   $preference = get_usermeta($userid,'preference');  
 }
 
 print "<!-- Wordpress Ad Management Plugin by Ravall.com  --> \n"; 
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
         <input type="image" src="'.WP_PLUGIN_URL.'/wordpress-multiple-user-ad-management/paypal.png" name="submit" alt="PayPal - The safer, easier way to pay online!" />
         <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" />
       </form>';
        mu_impressions($userid);
	}
	else {
	   $error = 1; 
	}
 }
 elseif ($preference == "Custom") {
    $custom = get_usermeta($userid,'custom');
	$customexpire = get_usermeta($userid,'customexpire');
	$expiretiming = get_usermeta($userid,'customexpired');
	$customlink = get_usermeta($userid,'customlink');
	  if ($custom != "") {
	    if($customexpire != "") {
	      remove_expired($userid,$expiretiming);
	    }
	    echo '<a href="'.$customlink.'" OnClick="this.href=\''.$clicktrack.'?type=custom&user='.$userid.'\'"><img src="'.$custom.'" alt="If you are seeing this, your Custom URL is not pointing to the correct image!" /></a>';
	    mu_impressions($userid);
	  }  
	else {
	  $error = 1; 
	  
	}
  }
 elseif ($preference == "Code") {
   
   echo get_usermeta($userid,'code');
   mu_impressions($userid);
 }
 elseif ($preference == "Textlink"){
   $texttitle = get_usermeta($userid,'texttitle');
   $textlink = get_usermeta($userid,'textlink');
   echo '<a href="'.$textlink.'" OnClick="this.href=\''.$clicktrack.'?type=textlink&user='.$userid.'\'">'.$texttitle.'</a>';
   mu_impressions($userid);
 }
 else {
  $error = 1;
 }
  
  if($error == 1 && $userid != userid()) {
   //Yo dawg, we heard you like PHP so we put a mu_sidebar function inside your mu_sidebar function!
    echo "oh hell no";
    mu_sidebar($userid);
    
  }
  elseif ($error == 1) {
    echo "<h4> Error: The ad management script is not properly configured for this user </h4>";
  }
  
  
 }

 


?>
