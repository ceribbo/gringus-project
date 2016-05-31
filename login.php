<?php

include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if ($status == AUTH_NOT_LOGGED) {
    $uname = strtolower(trim($_POST['uname']));
    $password = strtolower(trim($_POST['passw']));

    if (($uname == "" or $password == "") or ( $_GET['code'] == "" && ($uname == "" or $password == ""))) {
        $status = AUTH_INVALID_PARAMS;
    }

    if ($uname != "") {
        $passw = "MD5('" . $password . "')";
    } else {
        if ($_GET['codeFacebook'] != "") {
            $code = "codeFacebook";
        } elseif ($_GET['codeGoogle'] != "") {
            $code = "codeGoogle";
        } else {
            $code = "codeTwitter";
        }
        $query = "SELECT username, password FROM utenti WHERE " . $code . " = '" . $_GET['code'] . "'";
        echo $query;
        $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
        if (!$result) {
            die("Impossibile reperire informazioni utente: " . mysqli_error());
        }
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $uname = $row['username'];
        $passw = $row['username'];
        echo $uname.$passw;
    }
    list($status, $user) = auth_login($uname, $passw);
    if (!is_null($user)) {
        list($status, $uid) = auth_register_session($user);
    }
}
echo '<meta charset="utf-8" />';

switch ($status) {
    case AUTH_LOGGED:

        header("Refresh: 0;URL=index.php");
        echo '<div align="center">Sei già connesso ... attendi il reindirizzamento</div>';
        break;
    case AUTH_INVALID_PARAMS:
        //LOGIN ERRATO
        header("Refresh: 2;URL=index.php");
        echo '<div align="center">Hai inserito dati non corretti ... attendi il reindirizzamento</div>';
        break;
    case AUTH_LOGEDD_IN:
        //CONNESSO
        switch (auth_get_option("TRANSICTION METHOD")) {
            case AUTH_USE_LINK:
                header("Refresh: 0;URL=account.php?page=" . $pagine);
                break;
            case AUTH_USE_COOKIE:
                header("Refresh: 0;URL=" . $_GET['page']);
                setcookie('uid', $uid, time() + 3600 * 365);
                break;
            case AUTH_USE_SESSION:
                header("Refresh: 0;URL=account.php");
                $_SESSION['uid'] = $uid;
                break;
        }
        echo '<div align="center">Ciao ' . $user['name'] . ' ... attendi il reindirizzamento</div>';
        break;
    case AUTH_FAILED:
        header("Refresh: 5;URL=index.php");
        echo '<div align="center">Fallimento durante il tentativo di connessione ... attendi il reindirizzamento</div>';
        break;
}
?>
