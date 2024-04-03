<?php
// session_start();
// /**DEFINISCO VARIABILI PER CONNESSIONE */

// define('SERVER','localhost');
// define('DATABASE','webportfolio');
// define('UTENTEDB','root');
// define('PASSWORD','');

$indirizzoDb = "localhost";
$db = "webportfolio";
$utenteDb = "root";
$passwordDb = "";


/**CONNESSIONE MYSQL PDO */
try{
    $conn = new PDO(
        "mysql:host=$indirizzoDb;dbname=$db",
        $utenteDb, $passwordDb
    );
    $conn->setAttribute(PDO::ATTR_TIMEOUT, 3600);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,);
}
catch(PDOException $e){
    echo "<br><br>Errore di connessione PDO: " . $e->getMessage();
    die();
}

class PDODatabaseConnection {
    public $conn;

    private function __construct($indirizzoDb, $db, $utenteDb, $passwordDb) {
        $dsn = "mysql:host=$indirizzoDb;dbname=$db";
        $this->conn = new PDO($dsn, $utenteDb, $passwordDb);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function connect() {
        // La connessione è già gestita nel costruttore
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    // Implementa altri metodi comuni a PDO
}

