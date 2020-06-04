// Variable bouttons
const buttons = document.querySelectorAll('nav>button');


//Initialisation avec les sections non-apparente sur la page
document.getElementById('FormAjoutProduit').style.display = "none";

//Affichage des différentes sections lorsque l'on appuie sur un boutton
buttons.forEach(function (button) {
    button.addEventListener('click', () => {
       // Gestion des boutons et leurs conséquences 
       switch (button.id) {
          case "ajoutProduit":
              document.getElementById('FormAjoutProduit').style.display = "block";
              break;
            case "modificationProduit":
                document.getElementById('FormAjoutProduit').style.display = "none";
              break;
       }
    });
 });