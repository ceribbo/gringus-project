<?php
require_once("config.php");
require_once("auth.lib.php");

list($status, $user) = auth_get_status();
if($status == AUTH_LOGGED){
    include("menu/menu_true.php");
}else{
    include("menu/menu_false.php");
}
       

?>


