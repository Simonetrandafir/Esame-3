document.addEventListener('DOMContentLoaded', function() {
    let showPassCheckbox = document.getElementById('showPass');
    let passwordInput = document.getElementById('password');
    let showPass = document.getElementById('show');
    let hidePass = document.getElementById('hide');


    //PER MOSTRARE E NASCONDERE LA PASSWORD
    showPassCheckbox.addEventListener('click', function() {
        // Se la checkbox è selezionata, mostra la password, altrimenti nascondila
        if (showPassCheckbox.checked) {
            mostraPassword();
        } else {
            nascondiPassword();
        }
    });

    // Funzione per mostrare la password
    function mostraPassword() {
        // Cambia l'attributo "type" dell'elemento dell'input da "password" a "text"
        passwordInput.type = 'text';
        showPass.style.display ='none';
        hidePass.style.display = 'block';

    }

    // Funzione per nascondere la password
    function nascondiPassword() {
        // Cambia l'attributo "type" dell'elemento dell'input da "text" a "password"
        passwordInput.type = 'password';
        showPass.style.display ='block';
        hidePass.style.display = 'none';
    }
});