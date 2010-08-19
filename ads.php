<?php
ob_start();
define('WP_USE_THEMES', false);
require("../../../wp-load.php");

$type = $_GET['type'];
$user = $_GET['user'];
$clicks = get_usermeta($user,'adclicks');
$clicks++;
update_usermeta($user, 'adclicks',$clicks);

switch ($type) {
  case "custom": 
    $customlink = get_usermeta($user,'customlink');
    header("Location: $customlink");
    break;
  case "textlink":
    $textlink = get_usermeta($user,'textlink');
    header("Location: $textlink");
    break;
 }
ob_end_flush();
?>
