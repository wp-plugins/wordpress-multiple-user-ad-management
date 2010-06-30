<?php
// Include Wordpress 
$path = $_SERVER['DOCUMENT_ROOT'];
define('WP_USE_THEMES', false);
require("$path/wp-load.php");

get_header();
?>

<?php 
 $id = $_GET["id"];
 $key = $_GET["pkey"];
 $user_info = get_userdata($id);

 if( $_GET["pkey"] == $user_info->user_pass){
    update_usermeta($user_info->ID, 'approval', 1);
	echo "<p><h3>The user has been sucessfully approved and should now be able to access the code input.</h3></p>
          <p>If you accidently clicked on this link, please go to your MYSQL database, go to the user_meta field and delete the approval key for user id: $id</p>";
  }
 else {
    echo "The information contained in the link does not match the user information. Request to approve was denied";
 }
 
get_footer();
 ?>
	