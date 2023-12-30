let checkMenu = document.getElementById('checkNav');
    let nav = document.getElementById('nav');
    let iconMenu = document.getElementById('icon-menu');
    let closeMenu = document.getElementById('close-menu');

    document.addEventListener("DOMContentLoaded", function() {
        let logoElements = document.getElementById('logoNav');
        let logoTxtElements = document.getElementById('logoTxt');
        function enterLogo() {
            logoElements.style.opacity = "1";
            logoElements.style.animation = "tracking-in-expand 0.7s cubic-bezier(0.215, 0.610, 0.355, 1.000) both";
        }
        function enterLogoTxt() {
            logoTxtElements.style.opacity = "1";
            
            logoTxtElements.style.animation = "tracking-in-expand 0.7s cubic-bezier(0.215, 0.610, 0.355, 1.000) both";
        }
        setTimeout(enterLogoTxt, 600);
        setTimeout(enterLogo, 600);
    });


    if (window.innerWidth > 760){
            nav.style.transform = 'translateY(0%)';
    }else if (window.innerWidth < 760) {
        //PER IL MENU BURGER
        checkMenu.addEventListener('click', function(){
            // Se la checkbox è selezionata
            if (checkMenu.checked) {
                mostraMenu();
            } else {
                nascondiMenu();
            }
        });
    }
    function mostraMenu(){
        //
        nav.style.transform = 'translateY(0%)';
        iconMenu.style.display = 'none';
        closeMenu.style.display = 'block';
    };
    function nascondiMenu(){
        //
        nav.style.transform = 'translateY(-300%)';
        iconMenu.style.display = 'block';
        closeMenu.style.display = 'none';
    };