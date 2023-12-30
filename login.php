<?php


session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    header("Location: back.php");
    exit();
?>




<?php
}else {


?>


<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width" initial scale="1.0">
        <link rel="stylesheet" type="text/css" href="stile/stile.min.css">
        <link rel="stylesheet" type="text/css" href="">
        <script src="stileJs/stileLog.js" defer></script>
        <script src="stileJs/stileLoad.js"></script>
        <title>Simone Trandafir - Log in</title>
    </head>
    <body id="log">
        <div id="loader">
        <?php require_once "php/_load.php"; ?>
        </div>
        <div id="content">
            <?php require_once "php/_navbar.php"; ?>
            <main>
                <div id="logArea">
                    <h1>Area riservata</h1>
                    <p>Se sei un utente che vuole contattarmi o visionare il mio web portfolio,
                    clicca <a href="index.php#contattoBox">qui</a>.<br/>
                    Questa pagina è solo per gli amministratori, grazie dell'attenzione.
                    </p>
                </div>
                <form action="autorizzalog.php" method="post" id="formLog" autocomplete="on">
                    <fieldset id="formLogSet">
                        <legend style="display: none;"></legend>
                        <h2>Log In</h2>
                        
                        <?php
                        if(isset($_GET['error'])) { ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                        <?php } ?>
                        
                        <label for="email" class="label">Email*:
                            <input type="text" name="email" id="email" class="login"
                            value="<?php if (isset($_GET['email'])) echo (htmlspecialchars($_GET['email']))?>"
                            autocomplete="on" maxlength="45" required>
                        </label>
                        <label for="username" class="label">Username*:
                            <input type="text" name="username" id="username" class="login"
                            autocomplete="on" required maxlength="30"
                            value="<?php if (isset($_GET['username'])) echo (htmlspecialchars($_GET['username']))?>">
                        </label>
                        <label for="password" class="label">Password*:
                            <input type="password" name="password" id="password" class="login" maxlength="45" required>
                            <label for="showPass" class="showPass">
                                <input type="checkbox" id="showPass">
                                <img src="immagini/show.svg" alt="showPassword" id="show">
                                <img src="immagini/hide.svg" alt="hidePassword" id="hide">
                            </label>
                        </label>
                        <label for="btnLog">
                            <input type="submit" name="btnLog" id="btnLog">
                        </label>
                    </fieldset>
                </form>
            </main>
            <?php require_once "php/_footer.php"; ?>
        </div>
    </body>
    </html>
    

<?php
}
    
