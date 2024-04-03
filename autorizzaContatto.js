document.addEventListener('DOMContentLoaded', function () {
    const Contatto = document.getElementById('formContatto');

    Contatto.addEventListener('submit', function (event) {
        event.preventDefault();
        validaForm();
    });

    function validaForm() {
        const servizio = document.getElementById('servizioUtente').value;
        const nome = document.getElementById('nomeUtente').value.trim();
        const cognome = document.getElementById('cognomeUtente').value.trim();
        const azienda = document.getElementById('aziendaUtente').value;
        const email = document.getElementById('emailUtente').value.trim();
        const tel = document.getElementById('telUtente').value.trim();
        const commento = document.getElementById('commentoUtente').value.replace(/\s/g, '-');
        const autorizzoDati = document.getElementById('checkDatiUtente').checked ? 1 : 0;

        // Rimuovi tutte le classi 'allerta' prima di iniziare la validazione
        document.querySelectorAll('.allerta').forEach(element => element.classList.remove('allerta'));

        // Rimuovi messaggio errore
        const erroreMsg = document.getElementById('txtErrore');
        if (erroreMsg) erroreMsg.remove();
        // Rimuovi il messaggio di grazie
        const removeGrazie = document.getElementById('txtGrazie');
        if (removeGrazie) removeGrazie.remove();

        // Rimuovi il messaggio di successo
        const removeSuccesso = document.getElementById('txtSuccess');
        if (removeSuccesso) removeSuccesso.remove();

        const contErrore = document.getElementById('contErrore');
        const newErrore = document.createElement('p');
        newErrore.id = 'txtErrore';
        contErrore.appendChild(newErrore);

        const msgErrore = document.getElementById('txtErrore');

        if (nome === '' || cognome === '' || email === '' || autorizzoDati === 0) {
            msgErrore.textContent = 'Tutti i campi obbligatori devono essere completati!';
            msgErrore.classList.add('error');

            // Rimuovi il messaggio di successo
            const removeSuccesso = document.getElementById('txtSuccess');
            if (removeSuccesso) removeSuccesso.remove();

            // Aggiungi la classe 'allerta' solo ai campi vuoti
            ['nomeUtente', 'cognomeUtente', 'emailUtente'].forEach(field => {
                if (document.getElementById(field).value === '') document.getElementById(field).classList.add('allerta');
            });

            if (autorizzoDati === 0) document.getElementById('richiesto').classList.add('allerta');
        } else if (nome.length > 35 || cognome.length > 35 || azienda.length > 50 || email.length > 50 ||
            tel.length > 10 || commento.length > 360) {
            msgErrore.textContent = 'I campi non devono superare la lunghezza richiesta';
            msgErrore.classList.add('error');

            // Rimuovi il messaggio di successo
            const removeSuccesso = document.getElementById('txtSuccess');
            if (removeSuccesso) removeSuccesso.remove();

            // Aggiungi la classe 'allerta' solo ai campi che superano la lunghezza
            ['nomeUtente', 'cognomeUtente', 'aziendaUtente', 'emailUtente', 'telUtente', 'commentoUtente'].forEach(field => {
                if (document.getElementById(field).value.length > (field === 'telUtente' ? 10 : (field === 'commentoUtente' ? 360 : 35))) {
                    document.getElementById(field).classList.add('allerta');
                }
            });
        } else if (!/^[0-9 -]+$/.test(tel) && tel !==''|| !/^[a-zA-Z]+$/.test(nome) || !/^[a-zA-Z]+$/.test(cognome) ||
            !/^[^\d][\w.%+-]+(\.[\w]+)*@\w+([\.-]\w+)*\.\w{2,4}$/.test(email) ||
            !/^[a-zA-Z0-9,:.\- ]+$/.test(azienda) &&  azienda !== ''|| !/^[a-zA-Z0-9.,:;?!%+\- ]+$/.test(commento) && commento !== '') {
            msgErrore.textContent = 'I campi contengono valori non accettati';
            msgErrore.classList.add('error');

            // Rimuovi il messaggio di successo
            const removeSuccesso = document.getElementById('txtSuccess');
            if (removeSuccesso) removeSuccesso.remove();

            // Aggiungi la classe 'allerta' solo ai campi con valori non accettati
            if (!/^[a-zA-Z ]+$/.test(nome)) document.getElementById('nomeUtente').classList.add('allerta');
            if (!/^[a-zA-Z ]+$/.test(cognome)) document.getElementById('cognomeUtente').classList.add('allerta');
            if (!/^[a-zA-Z0-9,:.\- ]+$/.test(azienda) && azienda !== '') document.getElementById('aziendaUtente').classList.add('allerta');
            if (!/^[^\d][\w.%+-]+(\.[\w]+)*@\w+([\.-]\w+)*\.\w{2,4}$/.test(email)) document.getElementById('emailUtente').classList.add('allerta');
            if (!/^[0-9 -]+$/.test(tel) && tel !== '') document.getElementById('telUtente').classList.add('allerta');
            if (!/^[a-zA-Z0-9.,:;?!%+\- ]+$/.test(commento) && commento !== '') document.getElementById('commentoUtente').classList.add('allerta');
        } else {
            // Rimuovi l'elemento di errore e tutte le classi 'allerta'
            msgErrore.removeAttribute('class', 'error');
            msgErrore.textContent = '';

            // Rimuovi l'elemento 'txtErrore'
            const removeElemento = document.getElementById('txtErrore');
            if (removeElemento) removeElemento.remove();

            document.querySelectorAll('.allerta').forEach(element => element.classList.remove('allerta'));

            // Messaggio grazie
            const contGrazie = document.getElementById('msgGrazie');
            const newGrazie = document.createElement('div');
            newGrazie.id = 'txtGrazie';
            contGrazie.appendChild(newGrazie);

            const msgGrazie = document.getElementById('txtGrazie');
            msgGrazie.innerHTML = '<h2>Grazie per avermi contattato</h2>';

            const formResponse = document.getElementById('formResponse');
            // Ottieni la larghezza attuale della finestra
            let larghezzaFinestra = window.innerWidth;

            // Verifica se la larghezza è inferiore a 430 pixel
            if (larghezzaFinestra < 430) {
                formResponse.style.display="flex";
            } else {
                formResponse.style.display="grid";
                formResponse.style.padding="1% 6%";
                
            }
            
            // Messaggio di successo

            const contSuccesso = document.getElementById('success');
            contSuccesso.style.display="flex";
            const newSuccesso = document.createElement('div');
            newSuccesso.id = 'txtSuccess';
            contSuccesso.appendChild(newSuccesso);
            
            const msgSuccess = document.getElementById('txtSuccess');
            msgSuccess.innerHTML = '<h2>Riepilogo Dati:</h2>';

            // Aggiungi un riepilogo dei dati inviati
            msgSuccess.innerHTML += '<li><strong>Servizio:</strong><p> ' + servizio + '</p></li>';
            msgSuccess.innerHTML += '<li><strong>Nome:</strong><p> ' + nome + '</p></li>';
            msgSuccess.innerHTML += '<li><strong>Cognome:</strong><p> ' + cognome + '</p></li>';
            msgSuccess.innerHTML += '<li><strong>Azienda:</strong><p> ' + azienda + '</p></li>';
            msgSuccess.innerHTML += '<li><strong>Email:</strong><p> ' + email + '</p></li>';
            msgSuccess.innerHTML += '<li><strong>Telefono:</strong><p> ' + tel + '</p></li>';
            msgSuccess.innerHTML += '<li><strong>Commento:</strong><p> ' + commento + '</p></li>';

            const checkDatiUtenteValue = autorizzoDati ? '1' : '0';
            // Invia i dati al file PHP per l'inserimento nel server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/contatto.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('&servizioUtente=' + encodeURIComponent(servizio) + '&nomeUtente=' + encodeURIComponent(nome) +
                '&cognomeUtente=' + encodeURIComponent(cognome) + '&aziendaUtente=' + encodeURIComponent(azienda) +
                '&emailUtente=' + encodeURIComponent(email) + '&telUtente=' + encodeURIComponent(tel) +
                '&commentoUtente=' + encodeURIComponent(commento) + '&checkDatiUtente=' + checkDatiUtenteValue);
        }
    }
});
