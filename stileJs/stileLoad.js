document.addEventListener("DOMContentLoaded", function() {
    // Mostra la pagina di caricamento
    let loader = document.getElementById("loader");
    let content = document.getElementById("content");
  
    // Funzione per controllare il caricamento delle immagini
    function checkImagesLoaded() {
      let images = document.querySelectorAll("img");
      for (let i = 0; i < images.length; i++) {
        if (!images[i].complete) {
          return false;
        }
      }
      return true;
    }
  
    // Funzione per controllare il caricamento di altri tipi di risorse
    function checkOtherResourcesLoaded() {
      // Aggiungi qui il codice per controllare il caricamento di fogli di stile e script
      // Restituisci false se non sono completamente caricati
      // Altrimenti, restituisci true
      return true; // Esempio semplice
    }
  
    // Funzione per controllare il caricamento completo
    function checkAllResourcesLoaded() {
      return checkImagesLoaded() && checkOtherResourcesLoaded();
    }
  
    // Nascondi la pagina di caricamento solo quando tutte le risorse sono caricate
    function hideLoader() {
      loader.style.display = "none";
      content.style.display = "block";
    }
  
    // Verifica il caricamento completo delle risorse ogni 100 ms
    let interval = setInterval(function() {
      if (checkAllResourcesLoaded()) {
        clearInterval(interval);
        hideLoader();
      }
    }, 100);
  });