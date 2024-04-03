<?php

require_once 'connessione.php';

    $servizioUtente = filter_input(INPUT_POST, "servizioUtente", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nomeUtente = filter_input(INPUT_POST, "nomeUtente", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cognomeUtente = filter_input(INPUT_POST, "cognomeUtente", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $aziendaUtente = filter_input(INPUT_POST, "aziendaUtente", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $emailUtente = filter_input(INPUT_POST, "emailUtente", FILTER_SANITIZE_EMAIL);
    $telUtente = filter_input(INPUT_POST, "telUtente", FILTER_SANITIZE_NUMBER_INT);
    $commentoUtente = filter_input(INPUT_POST, "commentoUtente", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $checkDatiUtente = isset($_POST["checkDatiUtente"]) && $_POST["checkDatiUtente"] === '1';
    
    if (strlen($nomeUtente) > 35 || strlen($cognomeUtente) > 35 || strlen($aziendaUtente) > 50
    || strlen($emailUtente) > 50 || strlen($telUtente) > 10 || strlen($commentoUtente) > 360
    || !preg_match('/^[a-zA-Z]+$/', $nomeUtente) || !preg_match('/^[a-zA-Z]+$/', $cognomeUtente)
    || !preg_match('/^[a-zA-Z.,:0-9 - ]+$/', $aziendaUtente) || !preg_match('/^[0-9]+$/', $telUtente)
    || !preg_match('/^[^0-9][A-z0-9._%+-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $emailUtente)
    || !preg_match('/^[a-zA-Z0-9.,:;?!%+- ]+$/', $commentoUtente)) {
        exit();
    }

        try {
            $conn->begintransaction(); //inizo transazione
            //INSERISCO CONTATTO
            $sql="INSERT INTO contatti (servizioUtente,nomeUtente,cognomeUtente,
            aziendaUtente,emailUtente,telefonoUtente,commentoUtente,checkDatiUtente)
                VALUES (:servizioUtente,:nomeUtente,:cognomeUtente,:aziendaUtente,
                :emailUtente,:telefonoUtente,:commentoUtente,:checkDatiUtente)
                ON DUPLICATE KEY UPDATE
                servizioUtente = :servizioUtente,
                nomeUtente = :nomeUtente,
                cognomeUtente = :cognomeUtente,
                aziendaUtente = :aziendaUtente,
                telefonoUtente = :telefonoUtente,
                commentoUtente = :commentoUtente,
                checkDatiUtente = :checkDatiUtente";
            $query=$conn->prepare($sql);

            $query->bindParam(':servizioUtente', $servizioUtente, PDO::PARAM_STR);
            $query->bindParam(':nomeUtente',$nomeUtente, PDO::PARAM_STR);
            $query->bindParam(':cognomeUtente',$cognomeUtente, PDO::PARAM_STR);
            $query->bindParam(':aziendaUtente', $aziendaUtente, PDO::PARAM_STR);
            $query->bindParam(':emailUtente', $emailUtente, PDO::PARAM_STR);
            $query->bindParam(':telefonoUtente', $telUtente, PDO::PARAM_STR);
            $query->bindParam(':commentoUtente', $commentoUtente, PDO::PARAM_STR);
            $query->bindParam(':checkDatiUtente', $checkDatiUtente, PDO::PARAM_BOOL);

            $query->execute();

            $conn->commit(); //fine transazione

            // Chiudi la connessione al database
            $conn = null;
            exit();

        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
        }
