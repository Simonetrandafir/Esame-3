<?php
require_once 'connessione.php' ;
//Info
$queryInfo = "SELECT * FROM accessi WHERE nome IS NOT NULL AND email IS NOT NULL
    AND cognome IS NOT NULL";
// Esegui la query
$resultInfo = $conn->query($queryInfo);
?>

<footer>
    <div id="txtFoot">
        <p>2023 @ Copyright Trandafir Web</p>
        <div id="logoFoot">
            <img src="immagini/logoSimone.svg" alt="logo Trandafir web" width="50" height="50" title="Trandafir Web"/>
        </div>
    </div>

    <?php require_once "_privacyCoockie.php"; ?>

    <div id="linkFoot">
        <?php
        while ($info = $resultInfo->fetch(PDO::FETCH_ASSOC)) {
        ?>

        <a href="mailto:<?php echo $info['email'];?>" target="" id="email_foot">
            <img src="immagini/mail.svg" alt="logo mail" title="Email" />
            <!--email-->
        </a>
        <a href="tel:<?php echo $info['telefono'];?>" target="" id="tel_foot">
            <img src="immagini/call.svg" alt="logo call" title="Telefono" />
           <!-- telefono-->
        </a>
        <a href="https://it.linkedin.com/in/simone-trandafir-ui-ux-designer" target="_blank" id="linkedin_foot">
            <img src="immagini/linkedin.svg" alt="logo linkedin" title="LinkedIn" />
            <!-- linkedin-->
        </a>
        <a href="https://github.com/Simonetrandafir" target="_blank" id="git_foot">
            <img src="immagini/gitlogo.svg" alt="GitHub logo" title="GitHub Logo"  />
            <!--github-->
        </a>
    </div>
    <?php
        }
    ?>
</footer>

