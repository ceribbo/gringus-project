<?php 
function reg_register($data){ 
    //registro l'utente 
    global $_CONFIG; 
     
    $id = reg_get_unique_id(); 
    mysqli_query($GLOBALS["___mysqli_ston"], " 
    INSERT INTO ".$_CONFIG['table_utenti']." 
    (username, name, surname, password, giorno, mese, anno, mail, telefono, indirizzo, citta, cap, temp, regdate, uid) 
    VALUES 
    ('".$data['username']."','".$data['name']."','".$data['surname']."', 
    MD5('".$data['password']."'),'".$data['giorno']."','".$data['mese']."','".$data['anno']."', 
        '".$data['mail']."','".$data['telefono']."', 
        '".$data['indirizzo']."','".$data['citta']."','".$data['cap']."', 
    '1', '".time()."','".$id."')"); 
     
    //Decommentate la riga seguente per testare lo script in locale 
    echo "<a href=\"http://localhost/confirm.php?id=".$id."\">Conferma</a>"; 
    if(((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res)){ 
        return reg_send_confirmation_mail($data['mail'], "test@localhost", $id); 
    }else return REG_FAILED; 
} 

function reg_send_confirmation_mail($to, $from, $id){ 
    //invio la mail di conferma 
     
    $msg = "Per confermare l'avvenuta registrazione, clicckate il link seguente: 
    http://localhost/confirm.php?id=".$id." 
    "; 
    return (mail($to, "Conferma la registrazione", $msg, "From: ".$from)) ? REG_SUCCESS : REG_FAILED; 
} 

function reg_clean_expired(){ 
    global $_CONFIG; 
     
    $query = mysqli_query($GLOBALS["___mysqli_ston"], " 
    DELETE FROM ".$_CONFIG['table_utenti']." 
    WHERE (regdate + ".($_CONFIG['regexpire'] * 60 * 60).") <= ".time()." and temp='1'"); 
} 

function reg_get_unique_id(){ 
    //restituisce un ID univoco per gestire la registrazione 
    list($usec, $sec) = explode(' ', microtime()); 
    mt_srand((float) $sec + ((float) $usec * 100000)); 
    return md5(uniqid(mt_rand(), true)); 
} 

function reg_check_data(&$data){ 
    global $_CONFIG; 
     
    $errors = array(); 
     
    foreach($data as $field_name => $value){ 
        $func = $_CONFIG['check_table'][$field_name]; 
        if(!is_null($func)){ 
            $ret = $func($value); 
            if($ret !== true) 
                $errors[] = array($field_name, $ret); 
        } 
    } 
     
    return count($errors) > 0 ? $errors : true; 
} 

function reg_confirm($id){ 
    global $_CONFIG; 
     
    $query = mysqli_query($GLOBALS["___mysqli_ston"], " 
    UPDATE ".$_CONFIG['table_utenti']." 
    SET temp='0' 
    WHERE uid='".$id."'"); 
     
    return (mysqli_affected_rows($GLOBALS["___mysqli_ston"]) != 0) ? REG_SUCCESS : REG_FAILED; 
} 
?>