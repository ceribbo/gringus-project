<?php
include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if($status == AUTH_LOGGED & auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK){
	$link = "?uid=".$_GET['uid'];
}else	$link = '';
?>
<html>
	<head>
		<title>Login</title>
                <?php include("style/head.php");?>
	</head>
	<body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
             <div class="container">
                 
		<?php switch($status){
			case AUTH_LOGGED:
			?>
		<b>Sei loggato con il nome di <?=$user["name"];?> <a href="logout.php<?=$link?>">Logout</a></b>
			<?php
			break;
			case AUTH_NOT_LOGGED:
			?>
                
            
		<form action="login.php?page=<?= $_GET['page'] ?>" method="post">
			<table cellspacing="2">
				<tr>
					<td>Nome Utente:</td>
					<td><input type="text" name="uname"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="passw"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="action" value="login"></td>
				</tr>
                                <tr><td>
                                        <a href="https://accounts.google.com/o/oauth2/auth?client_id=737940042710-8e6uidepkeop672pc3615pgrni1nqgo1.apps.googleusercontent.com&redirect_uri=http://www.gringus.tk/login.php?codeGoogle=1&response_type=code&scope=https://www.googleapis.com/auth/plus.login">
                                        <img height="50" width="250" src="content/social/goole.png">
                                        </a>
                                        </td>
                                </tr>
			</table>
		</form>
		<?php
			break;
		}
		?>
	 </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php");?>
            </div>
        </div>

    </body>
</html>