// Seleziona l'elemento che vuoi far apparire durante lo scroll
let serviziElement = document.getElementById('servizi');



document.addEventListener("DOMContentLoaded", function() {

    let btnCloseContatto = document.getElementById('btnCloseContatto');
    let btnContatto = document.getElementById('btnContatto');

    btnContatto.addEventListener("click", function(){
        // Funzione per aprire la finestra di login
        function openModal() {
            document.getElementById("formResponse").style.visibility = "visible";
        }

        openModal();
        btnCloseContatto.style.display="flex";
        btnContatto.style.display="none";
    });
    btnCloseContatto.addEventListener("click", function(){
        // Funzione per chiudere la finestra di login
        function closeModal() {
            document.getElementById("formResponse").style.visibility = "hidden";
        }
        closeModal();
        btnCloseContatto.style.display="none";
        btnContatto.style.display="flex";
    });

 /////ENTRATA CONTENUTI///////////////////////////////////////////////////////////////////////////
    // Seleziona gli elementi che vuoi far apparire durante lo scroll
    let servizioElements = document.querySelectorAll('.servizio');
    let titoloElements = document.querySelectorAll('.titolo');
    let imgServElements = document.querySelectorAll('.imgServ');
    window.onscroll = function() {

        function checkVisibility() {
            // Verifica la visibilità degli elementi e applica le classi CSS se necessario
            servizioElements.forEach(function(element) {
                if (!isElementVisible(element)) {
                    element.classList.add('fade-in-left');
                    element.classList.remove('fade-out-left');
                }else if (window.scrollY === 0) {
                    element.classList.add('fade-in-left');
                    element.classList.remove('fade-out-left');
                }else{
                element.classList.remove('fade-in-left');
                element.classList.add('fade-out-left');
                }
            });
        
            titoloElements.forEach(function(element) {
                if (!isElementVisible(element)) {
                element.classList.add('fade-in-top');
                element.classList.remove('fade-out-top');
                }else if (window.scrollY === 0) {
                    element.classList.add('fade-in-top');
                    element.classList.remove('fade-out-top');
                }else{
                element.classList.remove('fade-in-top');
                element.classList.add('fade-out-top');
                }
            });
        
            imgServElements.forEach(function(element) {
                if (!isElementVisible(element)) {
                    element.classList.add('fade-in-top');
                    element.classList.remove('fade-out-top');
                }else if (window.scrollY === 0) {
                    element.classList.add('fade-in-top');
                    element.classList.remove('fade-out-top');
                }else{
                    element.classList.remove('fade-in-top');
                    element.classList.add('fade-out-top');
                }
            });

            let portElements = document.querySelectorAll('.card');
            portElements.forEach(function(element) {
                if (!isElementVisible(element)) {
                    element.classList.add('fade-in-port');
                    element.classList.remove('fade-out-port');
                }else if (window.scrollY === 0) {
                    element.classList.add('fade-in-port');
                    element.classList.remove('fade-out-port');
                }else{
                    element.classList.remove('fade-in-port');
                    element.classList.add('fade-out-port');
                }
            });
        };

        function isElementVisible(element) {
            let rect = element.getBoundingClientRect();
            let windowHeight = window.innerHeight || document.documentElement.clientHeight;
            return rect.top <= windowHeight * 0.9; // Puoi regolare questo valore in base alle tue esigenze
        };
        // Controlla la visibilità all'inizio per gestire eventuali elementi già visibili
        checkVisibility();
        // Aggiungi un listener per l'evento scroll
        window.addEventListener('scroll', checkVisibility);

    };


        
    //primi contenuti
    const txtVideo = document.getElementById("txtVideo");
    const infoBox = document.getElementById("infoBox");
    const skills = document.getElementById("skills");
    // Funzione per far entrare il contenuto
  function enterInfo() {
    infoBox.style.transform = "translateX(0)";
    txtVideo.style.transform = "translateY(0)";
  };
  function enterSkill() {
    skills.style.opacity = "1";
  };

  // Chiamare la funzione per far entrare il contenuto dopo un breve ritardo
  setTimeout(enterInfo, 600); // 600 millisecondi (0.6 secondi) di ritardo
  setTimeout(enterSkill, 1500); // 1500 millisecondi (1.5 secondi) di ritardo

 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //CAROSELLO PORTFOLIO
    const carousel = document.getElementById("portfolioContent");
    const scrollSinistra = document.getElementById("scroll_sinistra");
    const scrollDestra = document.getElementById("scroll_destra");

    // Numero di card da scorrere
    const numCard = document.querySelectorAll(".card").length;

    // Larghezza di ogni card
    const larghezzaCard = 260;

    // Inizializza l'indice corrente
    let indiceCorrente = 0;

    // Aggiungi le clonazioni all'inizio e alla fine del carosello
    const cloniInizio = Array.from(document.querySelectorAll(".card")).map(card => card.cloneNode(true));
    const cloniFine = Array.from(document.querySelectorAll(".card")).map(card => card.cloneNode(true));

    carousel.prepend(...cloniFine);
    carousel.append(...cloniInizio);

    // Aggiorna la posizione del carosello in base all'indice corrente
    function updateCarousel() {
        const nuovaPosizione = -indiceCorrente * larghezzaCard;
        carousel.style.transition = "transform 0.5s ease-in-out";
        carousel.style.transform = `translateX(${nuovaPosizione}px)`;
    };

    // Gestisci clic su pulsante di scorrimento a sinistra
    scrollSinistra.addEventListener("click", function() {
        if (indiceCorrente > 0) {
            indiceCorrente--;
        } else {
            // Se si è alla fine, scorri al primo clone
            indiceCorrente = numCard - 1;
            carousel.style.transition = "none";
            carousel.style.transform = `translateX(${-numCard * larghezzaCard}px)`;
        };
        updateCarousel();
    });

    // Gestisci clic su pulsante di scorrimento a destra
    scrollDestra.addEventListener("click", function() {
        if (indiceCorrente < numCard * 2 - 1) {
            indiceCorrente++;
        } else {
            // Se si è alla fine, scorri al primo clone
            indiceCorrente = numCard;
            carousel.style.transition = "none";
            carousel.style.transform = "translateX(0)";
        };
        updateCarousel();
    });

    // Inizializza il carosello
    updateCarousel();
});
