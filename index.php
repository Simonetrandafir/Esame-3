<?php

session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
session_unset();
session_destroy();

}
require_once 'php/connessione.php';
// Recupera le informazioni del portfolio dal database
$queryPortfolio = $conn->prepare("SELECT * FROM contenuti WHERE tipo='Portfolio'");
$queryPortfolio->execute();
$portfolioItems = $queryPortfolio->fetchAll(PDO::FETCH_ASSOC);

// Recupera le informazioni delle skills dal database
$querySkills = $conn->prepare("SELECT * FROM contenuti WHERE tipo='Skills'");
$querySkills->execute();
$skills = $querySkills->fetchAll(PDO::FETCH_ASSOC);

// Recupera le informazioni dei servizi dal database
$queryServizi = $conn->prepare("SELECT * FROM contenuti WHERE tipo='Servizi'");
$queryServizi->execute();
$servizi = $queryServizi->fetchAll(PDO::FETCH_ASSOC);

// Recupera le informazioni dei servizi dal database
$queryEsami = $conn->prepare("SELECT * FROM contenuti WHERE tipo='Esami'");
$queryEsami->execute();
$esami = $queryEsami->fetchAll(PDO::FETCH_ASSOC);

//Info
$queryInfo = "SELECT * FROM accessi WHERE nome IS NOT NULL AND email IS NOT NULL
    AND cognome IS NOT NULL";
// Esegui la query
$resultInfo = $conn->query($queryInfo);

?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width" initial scale="1.0">
        <link rel="stylesheet" type="text/css" href="">
        <link rel="stylesheet" type="text/css" href="stile/stile.min.css">
        <title>Simone Trandafir</title>
        <script src="autorizzaContatto.js" defer></script>
        <script src="stileJs/stileLoad.js"></script>
        <script src="stileJs/stileIndex.js" defer></script>
        <?php require_once "php/_bannerPolicy.php"; ?>
    </head>
    <body>
        <div id="loader">
        <?php require_once "php/_load.php"; ?>
        </div>
        <div id="content">
            <?php require_once "php/_navbar.php"; ?>
            <main>
                <div id="video_container">
                    <div id="txtVideo">
                        <?php
                        if(!empty($resultInfo)){
                            while ($info = $resultInfo->fetch(PDO::FETCH_ASSOC)) {
                                echo "<h2>{$info['nome']} {$info['cognome']}</h2>";
                                echo "<h3>{$info['lavoro']}</h3>";
                                ?>
                    </div>
                    <div id="video">
                        <video autoplay loop muted>
                            <source src="immagini/green_ink.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
                <div id="infoBox">
                    <div id="imgInfo">
                        <img src="<?php echo $info['immagine']; ?>" alt="img" width="200" height="250"/>
                    </div>
                    <div id="txtInfo">
                        <h2>Info</h2>
                        <div class="box">
                            <?php
                            echo "<p>{$info['descrizione']}</p>"
                            ?>
                        </div>
                    </div>
                    <?php }
                        }
                    ?>
                </div>
                <div id="skills">
                    <h2>Skills</h2>
                    <div class="box">
                        <?php
                        foreach ($skills as $skill) {
                            if (empty($skill['immagine']) || empty($skill['titolo'])) {
                                break; // Interrompe il ciclo se manca l'immagine o il titolo
                            }
                
                            $immagine_skill = $skill['immagine'];
                            $titolo_skill = $skill['titolo'];
                        ?>
                            <div class="skill">
                                <img src="<?php echo $immagine_skill; ?>" alt="img" />
                                <div class="titolo-skill">
                                    <h4><?php echo $titolo_skill; ?></h4>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="serviziBox">
                    <h1>Di cosa mi occupo ?</h1>
                    <div id="servizi">
                        <?php
                            foreach ($servizi as $servizio) {
                                if (empty($servizio['immagine']) || empty($servizio['titolo'])
                                || empty($servizio['descrizione'])) {
                                    break; // Interrompe il ciclo se manca l'immagine o il titolo
                                }
                            
                                $immagine_serv = $servizio['immagine'];
                                $titolo_serv = $servizio['titolo'];
                                $descrizione_serv = $servizio['descrizione'];
                            ?>
                                <article class="servizio fade-in-left">
                                    <figure>
                                        <img src="<?php echo $immagine_serv; ?>" class="imgServ fade-in-top" alt="img"/>
                                        <figcaption class="titolo fade-in-top">
                                            <h4><?php echo $titolo_serv; ?></h4>
                                            <p><?php echo $descrizione_serv ?></p>
                                        </figcaption>
                                    </figure>
                                </article>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div id="portfolioBox">
                    <h1>Progetti</h1>
                    <div id="contentBox">
                        <button class="scroll" id="scroll_sinistra">
                        <img src="immagini/left-arrow.svg" alt="sinistra" width="30" height="60"/>
                        </button>
                        <div id="portfolioContent">
                            <?php 
                            foreach ($portfolioItems as $item):
                                if (empty($item['immagine']) || empty($item['titolo'])) {
                                    break; // Interrompe il ciclo se manca l'immagine o il titolo
                                }
                                ?>
                                <div class="card">
                                    <img src="<?= $item['immagine'] ?>" alt="<?= $item['titolo'] ?>" width="150" height="150">
                                    <h3 class="titolo"><?= $item['titolo'] ?></h3>
                                    <p class="descrizione"><?= $item['descrizione'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="scroll" id="scroll_destra">
                            <img src="immagini/right-arrow.svg" alt="destra" width="30" height="60"/>
                        </button>
                    </div>
                </div>
                <div id="esamiBox">
                    <h1>Esercitazioni</h1>
                    <div id="contenutoEsami">
                        <?php
                        foreach ($esami as $esame) {
                            if (empty($esame['immagine']) || empty($esame['titolo'])) {
                                break; // Interrompe il ciclo se manca l'immagine o il titolo
                            }
                
                            $immagine_esame = $esame['immagine'];
                            $titolo_esame = $esame['titolo'];
                            $txt_esame = $esame['descrizione']
                        ?>
                            <div class="cardEsame">
                                <div class="imgCard"><img src="<?php echo $immagine_esame; ?>" alt="img" /></div>
                                <div class="txtEsame">
                                    <h4><?php echo $titolo_esame; ?></h4>
                                    <p><?php echo $txt_esame ?></p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="contattoBox">
                    <h1>Compila il form per contattarmi ora.</h1>
                    <button id="btnContatto">Contattami</button>
                    <div id="formResponse">
                        <form action="" method="post" id="formContatto">
                            <fieldset id="form-setting">
                                <legend>Dati utente</legend>
                                <button id="btnCloseContatto">
                                    <img src="immagini/x.svg" alt="x" width="20px" height="30px"/>
                                </button>
                                <label for="servizioUtente" class="label">Servizio :
                                    <select name="servizioUtente" id="servizioUtente" class="input">
                                        <optgroup label="Servizi">
                                            <option value="consulenza-contatto">Contatto</option>
                                        </optgroup>
                                        <optgroup label="Consulenza">
                                            <option value="consulenza-Web">Consulenza Web</option>
                                            <option value="consulenza-Intranet">Consulenza Intranet</option>
                                            <option value="Analisi-codice">Analisi Codice</option>
                                        </optgroup>
                                        <optgroup label="Servizio">
                                            <option value="UI">UI designer</option>
                                            <option value="UX">UX designer</option>
                                            <option value="Full-stack-develope">Full Stack Develope</option>
                                        </optgroup>
                                    </select>
                                </label>
                                <div class="formBox">
                                    <label for="nomeUtente" class="label">Nome*:
                                        <input type="text" name="nomeUtente" id="nomeUtente"
                                        placeholder="Mario" value="" maxlength="35" />
                                    </label>
                                    <label for="cognomeUtente" class="label">Cognome*:
                                        <input type="text" name="cognomeUtente" id="cognomeUtente"
                                        placeholder="Rossi" value="" maxlength="35" />
                                    </label>
                                    <label for="aziendaUtente" class="label">Azienda:
                                        <input type="text" name="aziendaUtente" id="aziendaUtente"
                                        value="" maxlength="50" />
                                    </label>
                                    <label for="emailUtente" class="label">Email*:
                                        <input type="email" name="emailUtente" id="emailUtente"
                                        placeholder="mario.rossi@email.com" value="" maxlength="50" />
                                    </label>
                                    <label for="telUtente" class="label">Tel:
                                        <input type="tel" name="telUtente" id="telUtente"
                                        value="" maxlength="10" />
                                    </label>
                                    <label for="commentoUtente" class="labelArea">Lascia un commento o una richiesta:<br/>
                                        <textarea name="commentoUtente" placeholder="Ho bisogno di..."
                                        rows="4" cols="40" id="commentoUtente" maxlength="360" ></textarea>
                                    </label>
                                </div>
                                <label for="checkDatiUtente" id="richiesto" style="border: none;">
                                Autorizzo il trattamento dati personali*:
                                    <input type="checkbox" name="checkDatiUtente" id="checkDatiUtente"/>
                                </label>
                                <div class="btnForm">
                                    <label for="submit" class="label_button">
                                        <input type="submit" id="submit" name="submit" value="Invia"/>
                                    </label>
                                </div>
                                <div id="contErrore"></div>
                                <div id="msgGrazie"></div>
                            </fieldset>
                        </form>
                        <div id="success"></div>
                    </div>
                </div>
            </main>
            <?php require_once "php/_footer.php"; ?>
        </div>
    </body>
</html>

<?php

