<?php 

$_AUTH = array( 
    "TRANSICTION METHOD" => AUTH_USE_COOKIE 
); 

function auth_set_option($opt_name, $opt_value){ 
    global $_AUTH; 
     
    $_AUTH[$opt_name] = $opt_value; 
} 

function auth_get_option($opt_name){ 
    global $_AUTH; 
     
    return is_null($_AUTH[$opt_name]) 
        ? NULL 
        : $_AUTH[$opt_name]; 
} 

function auth_clean_expired(){ 
    global $_CONFIG; 
     
    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT creation_date FROM ".$_CONFIG['table_sessioni']." WHERE uid='".auth_get_uid()."'"); 
    if($result){ 
        $data = mysqli_fetch_array($result); 
        if($data['creation_date']){ 
            if($data['creation_date'] + $_CONFIG['expire'] <= time()){ 
                switch(auth_get_option("TRANSICTION METHOD")){ 
                    case AUTH_USE_COOKIE: 
                        setcookie('uid'); 
                    break; 
                    case AUTH_USE_LINK: 
                        global $_GET; 
                        $_GET['uid'] = NULL; 
                    break; 
                } 
            } 
        } 
    } 
     
    mysqli_query($GLOBALS["___mysqli_ston"], " 
    DELETE FROM ".$_CONFIG['table_sessioni']." 
    WHERE creation_date + ".$_CONFIG['expire']." <= ".time() 
    ); 
} 

function auth_get_uid(){ 
     
    $uid = NULL; 

    switch(auth_get_option("TRANSICTION METHOD")){ 
        case AUTH_USE_COOKIE: 
            global $_COOKIE; 
            $uid = $_COOKIE['uid']; 
        break; 
        case AUTH_USE_LINK: 
            global $_GET; 
            $uid = $_GET['uid']; 
        break; 
    } 

    return $uid ? $uid : NULL; 
} 

function auth_get_status(){ 
    global $_CONFIG; 

    auth_clean_expired(); 
    $uid = auth_get_uid(); 
    if(is_null($uid)) 
        return array(100, NULL); 
     
    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT U.name as name, U.surname as surname, 
        U.username as username    FROM ".$_CONFIG['table_sessioni']." S,".$_CONFIG['table_utenti']." U 
    WHERE S.user_id = U.id and S.uid = '".$uid."'"); 
     
    if(mysqli_num_rows($result) != 1) 
        return array(100, NULL); 
    else{ 
        $user_data = mysqli_fetch_assoc($result); 
        return array(99, array_merge($user_data, array('uid' => $uid))); 
    } 
} 

function auth_login($uname, $passw){ 
    global $_CONFIG; 

    $result = mysqli_query($GLOBALS["___mysqli_ston"], " 
    SELECT * 
    FROM ".$_CONFIG['table_utenti']." 
    WHERE username='".$uname."' and password=".$passw." and temp = '0'" 
    ); 
    if(mysqli_num_rows($result) != 1){ 
        return array(AUTH_INVALID_PARAMS, NULL); 
    }else{ 
        $data = mysqli_fetch_array($result); 
        return array(AUTH_LOGEDD_IN, $data); 
    } 
} 

function auth_generate_uid(){ 

    list($usec, $sec) = explode(' ', microtime()); 
    mt_srand((float) $sec + ((float) $usec * 100000)); 
    return md5(uniqid(mt_rand(), true)); 
} 

function auth_register_session($udata){ 
    global $_CONFIG; 
     
    $uid = auth_generate_uid(); 
     
    mysqli_query($GLOBALS["___mysqli_ston"], " 
    INSERT INTO ".$_CONFIG['table_sessioni']." 
    (uid, user_id, creation_date) 
    VALUES 
    ('".$uid."', '".$udata['id']."', ".time().") 
    " 
    ); 
    if(!((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res)){ 
        return array(AUTH_LOGEDD_IN, $uid); 
    }else{ 
        return array(AUTH_FAILED, NULL); 
    } 
} 

function auth_logout(){ 
    global $_CONFIG; 

    $uid = auth_get_uid(); 
     
    if(is_null($uid)){ 
        return false; 
    }else{ 
        mysqli_query($GLOBALS["___mysqli_ston"], " 
        DELETE FROM ".$_CONFIG['table_sessioni']." 
        WHERE uid = '".$uid."'" 
        ); 
        return true; 
    } 
} 

?> 