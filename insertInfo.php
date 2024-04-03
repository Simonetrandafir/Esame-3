<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'php/connessione.php';

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cognome = filter_input(INPUT_POST, 'cognome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lavoro = filter_input(INPUT_POST, 'lavoro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descrizione = filter_input(INPUT_POST, 'descrizione', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Gestione dell'immagine
    $immaginePath = 'immagini/';  // Cartella dove salvare le immagini
    $immagineName = $_FILES['img']['name'];
    $immagineTmp = $_FILES['img']['tmp_name'];
    $immaginePathCompleto = $immaginePath . $immagineName;

    move_uploaded_file($immagineTmp, $immaginePathCompleto);

    // // Genera l'hash della password
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try{
        $conn->begintransaction(); //inizo transazione
        // Inserimento dei dati nella tabella appropriata
        $queryInserimento = "INSERT INTO accessi (nome,cognome,lavoro,email,telefono,
                            descrizione,username,password,immagine)
                             VALUES (:nome,:cognome,:lavoro,:email,:telefono,:descrizione,:username,:password,:immagine)
                             ON DUPLICATE KEY UPDATE nome = :nome, cognome = :cognome,
                             lavoro = :lavoro, telefono = :telefono, descrizione = :descrizione,
                             username = :username, password = :password, immagine = :immagine";
        
        $query = $conn->prepare($queryInserimento);
        $query->bindParam(':nome', $nome, PDO::PARAM_STR);
        $query->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $query->bindParam(':lavoro', $lavoro, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $query->bindParam(':descrizione', $descrizione, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
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

}

