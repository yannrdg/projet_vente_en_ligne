// Variable bouttons
const buttons = document.querySelectorAll('main>button');

//Initialisation avec les sections non-apparentes sur la page
document.getElementById('modif').style.display = "none";
document.getElementById('annuler').style.display = "none";

//Affichage des différentes sections lorsque l'on appuie sur un boutton
buttons.forEach(function (button) {
   button.addEventListener('click', () => {
      // Gestion des boutons et leurs conséquences 
      switch (button.id) {
         case "modifierInfos":
            document.getElementById('modif').style.display = "block";
            document.getElementById("annuler").style.display = "block";
            document.getElementById('infos').style.display = "none";
            document.getElementById("modifierInfos").style.display = "none";
            break;
         case "annuler":
            document.getElementById('infos').style.display = "block";
            document.getElementById("modifierInfos").style.display = "block";
            document.getElementById('modif').style.display = "none";
            document.getElementById("annuler").style.display = "none";
            break;
      }
   });
});