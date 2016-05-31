<?php 
$_CONFIG['host'] = "127.0.0.1"; 
$_CONFIG['user'] = ""; 
$_CONFIG['pass'] = ""; 
$_CONFIG['dbname'] = ""; 

$_CONFIG['table_sessioni'] = "sessioni"; 
$_CONFIG['table_utenti'] = "utenti"; 

$_CONFIG['expire'] = 3600 * 24; 
$_CONFIG['regexpire'] = 24; //in ore 

$_CONFIG['check_table'] = array( 
    "username" => "check_username", 
    "password" => "check_global", 
    "name" => "check_global", 
    "surname" => "check_global", 
    "indirizzo" => "check_global", 
    "telefono" => "check_global", 
    "mail" => "check_global", 
        "citta" => "check_global", 
        "cap" => "check_global", 
        "giorno" => "check_global", 
        "mese" => "check_global", 
        "anno" => "check_global", 
        "img" => "check_global" 
);

function check_username($value){ 
    global $_CONFIG; 
     
    $value = trim($value); 
    if($value == "") 
        return "Il campo non può essere lasciato vuoto"; 
    $query = mysqli_query($GLOBALS["___mysqli_ston"], " 
    SELECT id 
    FROM ".$_CONFIG['table_utenti']." 
    WHERE username='".$value."'"); 
    if(mysqli_num_rows($query) != 0) 
        return "Nome utente già utilizzato"; 
     
    return true; 
} 

function check_global($value){ 
    global $_CONFIG; 
     
    $value = trim($value); 
    if($value == "") 
        return "Il campo non può essere lasciato vuoto"; 
     
    return true; 
} 


//-------------- 
define('AUTH_LOGGED', 99); 
define('AUTH_NOT_LOGGED', 100); 

define('AUTH_USE_COOKIE', 101); 
define('AUTH_USE_LINK', 103); 
define('AUTH_INVALID_PARAMS', 104); 
define('AUTH_LOGEDD_IN', 105); 
define('AUTH_FAILED', 106); 

define('REG_ERRORS', 107); 
define('REG_SUCCESS', 108); 
define('REG_FAILED', 109); 

$GLOBALS["___mysqli_ston"] = mysqli_connect($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Impossibile stabilire una connessione'); 
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>