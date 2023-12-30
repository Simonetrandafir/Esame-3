<?php
session_start();
//se dati non settati esco
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) {
header("Location: login.php");
exit();
?>


<?php

}else {
//altrimenti visualizzo
require_once('php/connessione.php');

// Query per ottenere i dati dalla tabella "contatti"
$queryContatti = "SELECT * FROM contatti WHERE nomeUtente IS NOT NULL AND emailUtente IS NOT NULL
    AND cognomeUtente IS NOT NULL AND idUtente IS NOT NULL AND completato=0";
// Esegui la query
$resultContatti = $conn->query($queryContatti);

$queryCompleti = "SELECT * FROM contatti WHERE nomeUtente IS NOT NULL AND emailUtente IS NOT NULL
    AND cognomeUtente IS NOT NULL AND idUtente IS NOT NULL AND completato=1";
// Esegui la query
$complContatti = $conn->query($queryCompleti);

//Info
$queryInfo = "SELECT * FROM accessi WHERE nome IS NOT NULL AND email IS NOT NULL
    AND cognome IS NOT NULL";
// Esegui la query
$resultInfo = $conn->query($queryInfo);

// Funzione per ottenere i contenuti di un determinato tipo
function getContenutiByTipo($tipo) {
    global $conn;
    $query = "SELECT * FROM contenuti WHERE tipo = :tipo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Array con i tipi di contenuto
$tipiContenuto = array('Skills', 'Portfolio', 'Servizi','Esami');
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width" initial-scale="1.0">
        <title>Admin Design</title>
        <link href="" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="">
        <link rel="stylesheet" type="text/css" href="stile/stile.min.css">
        <script src="stileJs/stileLoad.js"></script>
        <script src="stileJs/stileBack.js" defer></script>
    </head>
    <body>
        <div id="loader">
        <?php require_once "php/_load.php"; ?>
        </div>
        <div id="content">
            <?php require_once "php/_navbar.php"; ?>
            <main id="back">
                <div class="account">
                    <img src="immagini/user.jpg" alt="profilo" id="profilo">
                    <h1 id="txtbenvenuto">Benvenuto <?=$_SESSION['user_nome']?></h1>
                    <button class="btn">
                        <a href="logout.php" class="btnLogout">Log out</a>
                    </button>
                </div>
                <h2>Contatti non completati</h2>
                <form method="post" action="modificaContatti.php" id="formtabella">
                    <div class="tableBox">
                        <div id="tabellaContatti">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Servizio</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Azienda</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Commento</th>
                                        <th>Autorizza dati</th>
                                        <th>Completato</th>
                                        <th>Cmd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    // Mostra i dati dalla tabella "contatti"
                                    while ($row = $resultContatti->fetch(PDO::FETCH_ASSOC)) {
                                        $buttonCheck= "<input type='checkbox' class='completa'
                                        name='comp-{$row['idUtente']}' id='comp-{$row['idUtente']}' />";
                                        $buttonCanc= "<input type='checkbox' class='cancella'
                                        name='canc-{$row['idUtente']}' id='canc-{$row['idUtente']}' />";
                                        echo "<tr>";
                                        echo "<td><p>{$row['idUtente']}</p></td>";
                                        echo "<td><p>{$row['servizioUtente']}</p></td>";
                                        echo "<td><p>{$row['nomeUtente']}</p></td>";
                                        echo "<td><p>{$row['cognomeUtente']}</p></td>";
                                        echo "<td><p>{$row['aziendaUtente']}</p></td>";
                                        echo "<td><p>{$row['emailUtente']}</p></td>";
                                        echo "<td><p>{$row['telefonoUtente']}</p></td>";
                                        echo "<td class='commentoView'><p>{$row['commentoUtente']}</p></td>";
                                        echo "<td><p>{$row['checkDatiUtente']}</p></td>";
                                        echo "<td><p>{$row['completato']}</p></td>";
                                        echo "<td><label for='comp-{$row['idUtente']}'
                                            class='container'>Compl$buttonCheck</label>
                                            <label for='canc-{$row['idUtente']}'
                                        class='container'>Canc$buttonCanc</label></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="cmd">
                        <input type="submit" id="completato" name="completato" value="Conferma">
                        <input type="reset" id="cancella" value="Reset">
                    </div>
                </form>
                <h2>Contatti completati</h2>
                <form method="post" action="modificaContatti.php" id="formCompleti">
                    <div class="tableBox">
                        <div id="complContatti">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Servizio</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Azienda</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Commento</th>
                                        <th>Autorizza dati</th>
                                        <th>Completato</th>
                                        <th>Cmd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    // Mostra i dati dalla tabella "contatti"
                                    while ($row = $complContatti->fetch(PDO::FETCH_ASSOC)) {
                                        $buttonUncheck= "<input type='checkbox' class='completa' name='uncomp-{$row['idUtente']}' id='uncomp-{$row['idUtente']}' />";
                                        $buttonCanc= "<input type='checkbox' class='cancella' name='canc-{$row['idUtente']}' id='canc-{$row['idUtente']}' />";
                                        echo "<tr>";
                                        echo "<td><p>{$row['idUtente']}</p></td>";
                                        echo "<td><p>{$row['servizioUtente']}</p></td>";
                                        echo "<td><p>{$row['nomeUtente']}</p></td>";
                                        echo "<td><p>{$row['cognomeUtente']}</p></td>";
                                        echo "<td><p>{$row['aziendaUtente']}</p></td>";
                                        echo "<td><p>{$row['emailUtente']}</p></td>";
                                        echo "<td><p>{$row['telefonoUtente']}</p></td>";
                                        echo "<td class='commentoView'><p>{$row['commentoUtente']}</p></td>";
                                        echo "<td><p>{$row['checkDatiUtente']}</p></td>";
                                        echo "<td><p>{$row['completato']}</p></td>";
                                        echo "<td><label for='uncomp-{$row['idUtente']}'
                                        class='container'>UnCompl$buttonUncheck</label>
                                        <label for='canc-{$row['idUtente']}'
                                        class='container'>Canc$buttonCanc</label></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="cmd">
                        <input type="submit" id="completato1" name="completato1" value="Conferma">
                        <input type="reset" id="cancella1" value="Reset">
                    </div>
                </form>
                <h2>Aggiungi o Cambia contenuti</h2>
                <div id="insertInfo">
                    <form action="insertInfo.php" method="post" id="formInsert" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Info</legend>
                            <input type="hidden" name="tipo" value="info">
                            <label for="nome" class="label" id="nomecont">
                                Nome*:
                                <input type="text" name="nome" id="nome" class="input" required>
                            </label>
                            <label for="cognome" class="label" id="cognomecont">
                                Cognome*:
                                <input type="text" name="cognome" id="cognome" class="input">
                            </label>
                            <label for="lavoro" class="label" id="cognomecont">
                                Professione*:
                                <input type="text" name="lavoro" id="lavoro" class="input">
                            </label>
                            <label for="email" class="label" id="cognomecont">
                                Email*:
                                <input type="text" name="email" id="email" class="input" autocomplete="on">
                            </label>
                            <label for="telefono" class="label" id="cognomecont">
                                Telefono*:
                                <input type="text" name="telefono" id="telefono" class="input">
                            </label>
                            <label for="username" class="label" id="usernamecont">
                                Username*:
                                <input type="text" name="username" alt="username" id="username" class="input"
                                autocomplete="on" required>
                            </label>
                            <label for="password" class="label" id="passwordcont">
                                Password*:
                                <input type="password" name="password" alt="password" class="input" id="password" required>
                                <label for="showPass" class="showPass">
                                    <input type="checkbox" id="showPass">
                                    <img src="immagini/show.svg" alt="showPassword" id="show">
                                    <img src="immagini/hide.svg" alt="hidePassword" id="hide">
                                </label>
                            </label>
                            <label for="descrizione" class="label" id="descrizionecont">
                                Descrizione:
                                <textarea id="descrizione" name="descrizione" class="area"></textarea>
                            </label>
                            <label for="imgProfilo" class="label" id="imgProfilocont">
                                Immagine:
                                <input type="file" name="img" alt="imgProfilo"
                                id="imgProfilo" accept=".jpg, .jpeg, .png, .gif, .svg">
                            </label>
                            <div id="successInfo"></div>
                        </fieldset>
                        <div class="btnForm">
                            <label for="submitInfo" class="label_button">
                                <input type="submit" id="submitInfo"  value="Inserisci"/>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="insertBox">
                    <?php
                        // Funzione per generare form e tabella dinamicamente
                        function generaFormETabella($tipo) {
                            // Ottieni i contenuti in base al tipo
                            $contenuti = getContenutiByTipo($tipo);
                            // Mostra solo se ci sono contenuti per il tipo corrente
                        
                                
                                echo "<div class='boxContenuti'>";
                                    echo "<div id='insert$tipo'>";
                                        echo "<form action='insertDati.php' method='post'
                                        id='form$tipo' enctype='multipart/form-data'>";
                                            echo "<fieldset>";
                                            echo "<legend>$tipo</legend>";
                                            echo "<input type='hidden' name='tipo' value='$tipo'/>";
                                            echo "<label for='titolo$tipo' class='label'>Titolo*:";
                                                echo "<input type='text' id='titolo$tipo'
                                                class='input' name='titolo'/>";
                                            echo "</label>";
                                            echo "<label for='link$tipo' class='label'>Link:";
                                                echo "<input type='text' id='link$tipo'
                                                name='link' class='input'/>";
                                            echo "</label>";
                                            echo "<label for='text$tipo' class='label'>Descrizione*:";
                                                echo "<textarea id='text$tipo' class='area'
                                                name='descrizione'></textarea>";
                                            echo "</label>";
                                            echo "<label for='img$tipo' class='label'>Immagine*:";
                                                echo "<input type='file' name='img' id='img$tipo'
                                                    accept='.jpg, .jpeg, .png, .gif, .svg'/>";
                                            echo "</label>";
                                            echo "<div class='btnForm'>";
                                            echo "<label for='submit$tipo' class='label_button'>";
                                            echo "<input type='submit' id='submit$tipo' value='Inserisci'/>";
                                            echo "</label>";
                                            echo "</div>";
                                            echo "<div id='success$tipo'></div>";
                                            echo "</fieldset>";
                                        echo "</form>";
                                    echo "</div>";
                                echo "</div>";
                        }

                        foreach ($tipiContenuto as $tipo) {
                            generaFormETabella($tipo);
                        }
                    ?>

                </div>
                <h2>Rimuovi contenuto</h2>
                <form method="post" action="modificaContatti.php" id="formAccessi">
                    <div class="tableBox">
                        <div id="tabellaInfo">
                            <h2>Info - Accessi</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Lavoro</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Descrizione</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Immagine</th>
                                        <th>Cmd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    // Mostra i dati dalla tabella "contatti"
                                    while ($row = $resultInfo->fetch(PDO::FETCH_ASSOC)) {
                                        $buttonCanc= "<input type='checkbox' class='cancella' name='canc-{$row['id']}'
                                        id='canc-{$row['id']}' />";
                                        echo "<tr>";
                                        echo "<td><p>{$row['id']}</p></td>";
                                        echo "<td><p>{$row['nome']}</p></td>";
                                        echo "<td><p>{$row['cognome']}</p></td>";
                                        echo "<td><p>{$row['lavoro']}</p></td>";
                                        echo "<td><p>{$row['email']}</p></td>";
                                        echo "<td><p>{$row['telefono']}</p></td>";
                                        echo "<td class='commentoView'><p>{$row['descrizione']}</p></td>";
                                        echo "<td><p>{$row['username']}</p></td>";
                                        echo "<td><p>{$row['password']}</p></td>";
                                        echo "<td><img src='{$row['immagine']}' alt='img' width='30px' height='30px'></td>";
                                        echo "<td><label for='canc-{$row['id']}'
                                        class='container'>Canc$buttonCanc</label></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="cmd">
                        <input type="submit" id="cancAccessi" name="cancAccessi" value="Conferma">
                        <input type="reset" id="cancella2" value="Reset">
                    </div>
                </form>
                <form method="post" action="cancontenuto.php" id="formContenuto">
                    <div class="rimuoviBox">
                        <?php
                        // Loop per ogni tipo di contenuto
                        foreach ($tipiContenuto as $tipo) {
                            // Ottieni i contenuti del tipo corrente
                            $contenuti = getContenutiByTipo($tipo);
                        
                            // Mostra la tabella solo se ci sono contenuti per il tipo corrente
                            if (!empty($contenuti)) {
                                echo "<div class='contenitore'>";
                                echo "<table id='$tipo-tab' class='tabella'>";
                                echo "<h2>Tipo: $tipo</h2>";
                                echo "<thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo</th>
                                            <th>Titolo</th>
                                            <th>Link</th>
                                            <th>Descrizione</th>
                                            <th>Immagine</th>
                                            <th>Cmd</th>
                                        </tr>
                                    </thead>";
                                echo "<tbody>";
                            
                                // Loop attraverso i contenuti del tipo corrente
                                foreach ($contenuti as $contenuto) {
                                    $buttonCanc= "<input type='checkbox' class='cancella' name='cancCont-{$contenuto['idImmagine']}'
                                    id='cancCont-{$contenuto['idImmagine']}'/>";
                                    echo "<tr>";
                                    echo "<td><p>{$contenuto['idImmagine']}</p></td>";
                                    echo "<td><p>$tipo</p></td>";
                                    echo "<td><p>{$contenuto['titolo']}</p></td>";
                                    echo "<td><a href='{$contenuto['link']}'>{$contenuto['link']}</a></td>";
                                    echo "<td><p class='commentoView'>{$contenuto['descrizione']}</p></td>";
                                    echo "<td><img src='{$contenuto['immagine']}' alt='Immagine' width='40' height='40'></td>";
                                    echo "<td><label for='cancCont-{$contenuto['idImmagine']}'
                                    class='container'>Canc$buttonCanc</label></td>";
                                    echo "</tr>";
                                }
                            
                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="cmd">
                        <input type="submit" id="cancContenuto" name="cancContenuto" value="Conferma">
                        <input type="reset" id="reset" value="Reset">
                    </div>
                </form>
            </main>
            <?php require_once "php/_footer.php"; ?>
        </div>
    </body>
</html>

<?php
}
?>

