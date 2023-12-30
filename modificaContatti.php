<?php
// modificaContatti.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se è stato premuto il pulsante di conferma per gli ACCESSI
    if (isset($_POST['cancAccessi'])){
        require_once ("php/connessione.php");
        foreach ($_POST as $key => $value) {
            echo "Key: $key, Value: $value<br>";
            // Verifica se la variabile POST inizia con "canc-"
            if (substr($key, 0, 5) == "canc-") {
                // Estrae l'ID utente dalla chiave
                $idCanc = substr($key, 5);

                // Prepara la query di cancellazione
                $queryCanc = "DELETE FROM accessi WHERE id = :id";
                $stmtCanc = $conn->prepare($queryCanc);
                $stmtCanc->bindParam(':id', $idCanc, PDO::PARAM_INT);

                // Esegue la query di cancellazione
                try {
                    $stmtCanc->execute();
                    echo "Cancellazione avvenuta con successo per l'accesso con ID: $idCanc<br>";
                } catch (PDOException $e) {
                    die("Errore nella cancellazione del accesso: " . $e->getMessage());
                }
                // Chiudi la connessione al database
                $conn = null;

                // Puoi aggiungere reindirizzamenti o messaggi di successo qui
                header("Location: back.php");
                exit();
            }
        }
    }
    // Verifica se è stato premuto il pulsante di conferma per i CONTATTI
    elseif (isset($_POST['completato']) || isset($_POST['completato1'])) {
        require_once ("php/connessione.php");

        // Cicla attraverso le variabili POST per individuare le checkbox selezionate
        foreach ($_POST as $key => $value) {
            echo "Key: $key, Value: $value<br>";
            // Verifica se la variabile POST inizia con "canc-"
            if (substr($key, 0, 5) == "canc-") {
                // Estrae l'ID utente dalla chiave
                $idUtenteCanc = substr($key, 5);

                // Prepara la query di cancellazione
                $queryCanc = "DELETE FROM contatti WHERE idUtente = :idUtente";
                $stmtCanc = $conn->prepare($queryCanc);
                $stmtCanc->bindParam(':idUtente', $idUtenteCanc, PDO::PARAM_INT);

                // Esegue la query di cancellazione
                try {
                    $stmtCanc->execute();
                    echo "Cancellazione avvenuta con successo per l'utente con ID: $idUtenteCanc<br>";
                } catch (PDOException $e) {
                    die("Errore nella cancellazione del contatto: " . $e->getMessage());
                }
            }

            // Verifica se la variabile POST inizia con "comp-"
            elseif (substr($key, 0, 5) == "comp-") {
                // Estrae l'ID utente dalla chiave
                $idUtenteComp = substr($key, 5);

                // Prepara la query di aggiornamento della colonna completato
                $queryComp = "UPDATE contatti SET completato = 1 WHERE idUtente = :idUtente";
                $stmtComp = $conn->prepare($queryComp);
                $stmtComp->bindParam(':idUtente', $idUtenteComp, PDO::PARAM_INT);

                // Esegue la query di aggiornamento
                try {
                    $stmtComp->execute();
                    echo "Aggiornamento completato avvenuto con successo per l'utente con ID: $idUtenteComp<br>";
                } catch (PDOException $e) {
                    die("Errore nell'aggiornamento dello stato completato: " . $e->getMessage());
                }
            }
            // Verifica se la variabile POST inizia con "uncomp-"
            elseif (substr($key, 0, 7) == "uncomp-") {
                // Estrae l'ID utente dalla chiave
                $idUtenteunComp = substr($key, 7);

                // Prepara la query di aggiornamento della colonna completato
                $queryunComp = "UPDATE contatti SET completato = 0 WHERE idUtente = :idUtente";
                $stmtunComp = $conn->prepare($queryunComp);
                $stmtunComp->bindParam(':idUtente', $idUtenteunComp, PDO::PARAM_INT);

                // Esegue la query di aggiornamento
                try {
                    $stmtunComp->execute();
                    echo "Aggiornamento completato avvenuto con successo per l'utente con ID: $idUtenteunComp<br>";
                } catch (PDOException $e) {
                    die("Errore nell'aggiornamento dello stato completato: " . $e->getMessage());
                }
            }
        }

        // Chiudi la connessione al database
        $conn = null;

        // Puoi aggiungere reindirizzamenti o messaggi di successo qui
        header("Location: back.php");
        exit();
    }else{
        exit();
    }
}else{
    exit();
}

