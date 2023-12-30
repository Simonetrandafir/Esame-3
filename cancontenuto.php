<?php
// cancontenuto.php

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancContenuto'])) {
        // Connessione al database
        require_once ("php/connessione.php");
        
        // Cicla attraverso le variabili POST per individuare le checkbox selezionate
        foreach ($_POST as $key => $value) {
            // Verifica se la variabile POST inizia con "cancCont-"
            if (substr($key, 0, 9) == "cancCont-") {
                // Estrae l'ID dalla chiave
                $idContenuto = substr($key, 9);
                
                // Prepara la query di cancellazione
                $query = "DELETE FROM contenuti WHERE idImmagine = :idImmagine";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':idImmagine', $idContenuto, PDO::PARAM_INT);
                
                // Esegue la query
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                    die("Errore nella cancellazione del contenuto: " . $e->getMessage());
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


