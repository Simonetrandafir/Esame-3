<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('php/connessione.php');

    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $titolo = filter_input(INPUT_POST, 'titolo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descrizione = filter_input(INPUT_POST, 'descrizione', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    

    // Gestione dell'immagine
    $immaginePath = 'immagini/';  // Cartella dove salvare le immagini
    $immagineName = $_FILES['img']['name'];
    $immagineTmp = $_FILES['img']['tmp_name'];
    $immaginePathCompleto = $immaginePath . $immagineName;

    move_uploaded_file($immagineTmp, $immaginePathCompleto);

    try{
        $conn->begintransaction(); //inizo transazione
        // Inserimento dei dati nella tabella appropriata
        $queryInserimento = "INSERT INTO contenuti (tipo, titolo, link, descrizione, immagine)
                             VALUES (:tipo, :titolo, :link, :descrizione, :immagine)
                             ON DUPLICATE KEY UPDATE
                             tipo = :tipo, link = :link, descrizione = :descrizione";
        
        $query = $conn->prepare($queryInserimento);
        $query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $query->bindParam(':titolo', $titolo, PDO::PARAM_STR);
        $query->bindParam(':link', $link, PDO::PARAM_STR);
        $query->bindParam(':descrizione', $descrizione, PDO::PARAM_STR);
        $query->bindParam(':immagine', $immaginePathCompleto, PDO::PARAM_STR);
    
        $query->execute();
    
        $conn->commit(); //fine transazione
        // Chiudi la connessione al database
        $conn = null;
        header("Location: back.php");
        exit();
    } catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }

}else{
    exit();
}

