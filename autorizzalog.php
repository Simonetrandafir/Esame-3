<?php

session_start();

require_once 'php/connessione.php';

//se il form di log in viene inviato
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {
	//recupero dati
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //se non vuoti controllo dati
    if (strlen($username) > 30) {
        header("Location: login.php?error= La lunghezza di Username deve essere massimo 30 caratteri");
        exit();
    }elseif (strlen($email) > 45){
        header("Location: login.php?error= La lunghezza di Email deve essere massimo 45 caratteri");
        exit();
    }elseif (strlen($password) > 45){
        header("Location: login.php?error= La lunghezza di Password deve essere massimo 45 caratteri");
        exit();
    }elseif (!preg_match('/^[a-zA-Z0-9.,?!]+$/', $username)
    || !preg_match('/^[^0-9][A-z0-9._%+-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $email)
    || !preg_match('/^[a-zA-Z0-9.,?!]+$/', $password)) {
        header("Location: login.php?error= Username o Email non validi&email=$email&username=$username");
        exit();
    //controllo dati se vuoti
	}elseif (empty($email)) {
		header("Location: login.php?error=Email obbligatoria");
        exit();
    }elseif(empty($username)){
        header("Location: login.php?error=Username obbligatorio&email=$email");
        exit();
	}elseif (empty($password)){
		header("Location: login.php?error=Password obbligatoria&email=$email&username=$username");
        exit();
    //se tutto apposto verifico se corrispondono ai dati server
	}else {
        //pulisco dati inseriti nel log in
        $emailClean = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $usernameClean = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $passwordClean = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

        //seleziono dati da tabella
		$stmt = $conn->prepare("SELECT * FROM accessi WHERE email=?");
        //eseguo
		$stmt->execute([$emailClean]);
        //limito dati a 1
		if ($stmt->rowCount() === 1) {
			$user = $stmt->fetch();
            //suddivido dati
			$user_id = $user['id'];
			$user_nome = $user['nome'];
			$user_email = $user['email'];
            $usernameDb = $user['username'];
			$user_password = $user['password'];
            //controllo dati
			if ($emailClean === $user_email) {
                if($usernameClean == $usernameDb){
                    //password verify per password salvate da hash
				    if ($passwordClean == $user_password) {
				    	$_SESSION['user_id'] = $user_id;
				    	$_SESSION['user_email'] = $user_email;
				    	$_SESSION['user_nome'] = $user_nome;
				    	header("Location: back.php");
                        exit();
				    }else {
				    	header("Location: login.php?error=Password errata&email=$email");
                        exit();
				    }
                }else{
                    header("Location: login.php?error=Username errato&email=$email");
                    exit();
                }
			}else {
				header("Location: login.php?error=Dati accesso errati&email=$email");
                exit();
			}
		}else {
			header("Location: login.php?error=Dati accesso errati&email=$email");
            exit();
		}
        
	}
}

