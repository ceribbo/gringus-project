
<?php
if ($status == AUTH_LOGGED) {
    echo '<script languaguage="javascript"> 
                    <!-- 
                    window.location = "index.php";  
                    //--> 
                    </script>';
}
$log = $_GET['log'];
?>
<html>
    <head>
        <title>Modulo di Registrazione</title>
        <?php include("style/head.php"); ?>
    </head>
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container">
                <form action="register.php" method="post">
                    <div align="center">

                        <table border="0" width="500">
                            <tr>
                                <td>Username:</td>
                                <td><input type="text" name="username" value="Username" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Nome:</td>
                                <td><input type="text" name="name" value="Nome" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Cognome:</td>
                                <td><input type="text" name="surname" value="Cognome" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Data di nascita:</td>
                                <td>Giorno <input type="text" name="giorno" value="gg" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" size=2 required>
                                    Mese <input type="text"  name="mese" value="mm" onfocus="if (this.value == this.defaultValue)
                                                this.value = ''" size=2 required>
                                    Anno <input type="text" name="anno"  value="aa" onfocus="if (this.value == this.defaultValue)
                                                this.value = ''" size=4 required></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td><input type="password" name="password" required></td>
                            </tr>
                            <tr>
                                <td>Mail:</td>
                                <td><input type="text" name="mail" value="esempio@esempio.it" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Telefono:</td>
                                <td><input type="text" name="telefono" value="123456789" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Indirizzo:</td>
                                <td><input type="text" name="indirizzo" value="Indirizzo" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Citta:</td>
                                <td><input type="text" name="citta" value="città" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td>Cap:</td>
                                <td><input type="text" name="cap" size=5 value="00100" onfocus="if (this.value == this.defaultValue)
                                            this.value = ''" required></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><input type="submit" name="action" value="Registrati"></td>
                            </tr>
                        </table>
                </form>
            </div>
        </div>
    </div>
    <div id="foot">
        <div class="footer">
            <?php include("style/footer.php"); ?>
        </div>
    </div>

</body>
</html>