<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les réalisations Montay Menuiserie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<?php require_once("server/bdd.php");
$pieces = $conn->query("SELECT * FROM piece_prestation ORDER BY id ASC");

?>
<body>
    <header class="header-area">  
        
        <?php include("navbar.php"); ?>
        <div class="intro-galerie-area">        
        <div class="container" style="position: relative; height: 100%; display: flex; flex-flow: column; align-items: center; text-align: center; justify-content: center;">
            <div class="back-menu"><a href=".">
                <img src="assets/montay.png" style="width: 30px;" alt="">
                Accueil
            </a></div>
            <h1>Mes réalisations</h1>
        </div>
        </div>
    </header>


    <div class="container">
        <center>
        <div class="wrapper">
            <div class="chevron"><img src="assets/montay.png" id="left" alt=""></div>
            <ul class="tabs-box"> 
                <li class="tab active">Tout voir</li>
                <?php foreach ($pieces as $piece) { ?>
                <li class="tab" data-category="<?php echo $piece["id"] ?>"><?php echo $piece["nom"]; ?></li>
                <?php } ?>
            </ul>
            <div class="chevron"><img src="assets/montay.png" id="right" alt=""></div>
        </div>
        </center>

        <h2 class="realisation-titre"></h2>

        <div id="prestations-grid" class="grid-container"></div>

    </div>

<script>
  const tabsBox = document.querySelector(".tabs-box"),
  allTabs = tabsBox.querySelectorAll(".tab"),
  arrowchevrons = document.querySelectorAll(".chevron img");
  title = document.querySelector(".realisation-titre"),
  prestations = [];

  title.innerHTML = "Toutes les réalisations";

  // Sélectionnez l'élément où vous souhaitez afficher la grille
    const prestationsGrid = document.getElementById("prestations-grid");

    // Fonction pour créer la grille de prestations
    function createPrestationsGrid(prestations) {
        prestationsGrid.innerHTML = ""; // Efface le contenu actuel de la grille

        if(prestations.length>0){

            prestations.forEach((prestation) => {
                const prestationDiv = document.createElement("div");
                prestationDiv.classList.add("prestation-item");

                const dateAFormater = new Date(prestation.date);
                const date = dateAFormater.toLocaleDateString('fr-FR', { day: '2-digit', month: 'long', year: 'numeric' });

                prestationDiv.innerHTML = `
    <div class="grid-item" data-toggle="modal" data-target="#modal-prestation-${prestation.id}">
      <div class="image-prestation" style="background-image: url('${prestation.photo_1}');" alt="${prestation.titre}"></div>
      <p class="titre-prestation">${prestation.titre}</p>
    </div>

    <div class="modal fade" id="modal-prestation-${prestation.id}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!-- Contenu de la modal -->
          <div class="modal-body">
            <div class="modal-prestation-content">
              <!-- carousel -->
              <div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>
                <div class='carousel-inner'>
                  <div class='carousel-item active'>
                    <div class='img-size' style="background-image: url('${prestation.photo_1}');"></div>
                  </div>
                  ${prestation.photo_2 ? `
                  <div class='carousel-item'>
                    <div class='img-size' style="background-image: url('${prestation.photo_2}');"></div>
                  </div>
                  ` : ''}
                  ${prestation.photo_3 ? `
                  <div class='carousel-item'>
                    <div class='img-size' style="background-image: url('${prestation.photo_3}');"></div>
                  </div>
                  ` : ''}
                  ${prestation.photo_4 ? `
                  <div class='carousel-item'>
                    <div class='img-size' style="background-image: url('${prestation.photo_4}');"></div>
                  </div>
                  ` : ''}
                </div>
                ${prestation.photo_2 ? `
                <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>
                  <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                </a>
                <a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next' >
                  <span class='carousel-control-next-icon' aria-hidden='true'></span>
                </a>              
                ` : ''}
              </div>
              <div class="prestation-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h3>${prestation.titre}</h3>
                <b style="font-style: italic;">${date} • ${prestation.ville}</b><br><br>
                <p>${prestation.description}</p>              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

                prestationsGrid.appendChild(prestationDiv);

            });

        } else {
                const prestationDiv = document.createElement("div");

                prestationDiv.innerHTML = `
                <p style="height: 60vh;">Pas encore de réalisations disponible pour cette catégorie.</p>
                `;
                
                prestationsGrid.appendChild(prestationDiv);
        }
    }

    // Charge les données des prestations depuis le fichier PHP
    fetch("server/get-prestations.php")
    .then((response) => response.json())
    .then((data) => {
        // Appelle la fonction pour créer la grille de prestations avec les données récupérées
        prestations = data;
        createPrestationsGrid(data);
    })
    .catch((error) => {
        console.error("Erreur lors de la récupération des données : " + error);
    });

let isDragging = false;

const handlechevrons = (scrollVal) => {
  let maxScrollableWidth = tabsBox.scrollWidth - tabsBox.clientWidth;
  arrowchevrons[0].parentElement.style.display = scrollVal <= 0 ? "none" : "flex";
  arrowchevrons[1].parentElement.style.display =
    maxScrollableWidth - scrollVal <= 1 ? "none" : "flex";
};

arrowchevrons.forEach((chevron) => {
  chevron.addEventListener("click", () => {
    // if clicked chevron is left, reduce 350 from tabsBox scrollLeft else add
    let scrollWidth = (tabsBox.scrollLeft += chevron.id === "left" ? -120 : 120);
    handlechevrons(scrollWidth);
  });
});

allTabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const selectedCategory = tab.getAttribute("data-category");

    if(selectedCategory){    
        // Filtrer les prestations en fonction de la catégorie sélectionnée
        const prestationsFiltrees = prestations.filter((prestation) => {
        return prestation.categorie === selectedCategory;
        });
        
        // Appelle la fonction pour créer la grille de prestations avec les données triées
        createPrestationsGrid(prestationsFiltrees);
    } else {
        createPrestationsGrid(prestations);
    }

    if(tabsBox.querySelector(".active")){
        tabsBox.querySelector(".active").classList.remove("active");
    }
    tab.classList.add("active");
    if(tab.innerHTML == 'Tout voir'){
        title.innerHTML = 'Toutes les réalisations';
    } else {
        title.innerHTML = tab.innerHTML;
    }
  });
});

const dragging = (e) => {
  if (!isDragging) return;
  tabsBox.classList.add("dragging");
  tabsBox.scrollLeft -= e.movementX;
  handlechevrons(tabsBox.scrollLeft);
};

const dragStop = () => {
  isDragging = false;
  tabsBox.classList.remove("dragging");
};

tabsBox.addEventListener("mousedown", () => (isDragging = true));
tabsBox.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);

// Initialisation du carousel pour chaque modal
$('.modal').on('shown.bs.modal', function () {
  $(this).find('.carousel').carousel();
});


</script>

<style>
.wrapper {
  max-width: 1100px;
  padding: 15px;
  position: relative;
  overflow-x: hidden;
  border-radius: 13px;
}
.wrapper .chevron {
  position: absolute;
  top: 0;
  height: 100%;
  width: 120px;
  display: flex;
  align-items: center;
}
.chevron:first-child {
  left: 0;
  display: none;
  background: linear-gradient(90deg, #ffffff 50%, transparent);
}
.chevron:last-child {
  right: 0;
  justify-content: flex-end;
  background: linear-gradient(-90deg, #ffffff 50%, transparent);
}
.chevron img {
  width: 30px;
  height: 30px;
  cursor: pointer;
  font-size: 1.2rem;
  text-align: center;
  line-height: 30px;
  border-radius: 50%;
  color: #fff;
}
.chevron img:hover {
  color: #212121;
  background: #efedfb;
}
.chevron:first-child img {
  margin-left: 15px;
}
.chevron:last-child img {
  margin-right: 15px;
}
.wrapper .tabs-box {
  display: flex;
  gap: 12px;
  list-style: none;
  overflow-x: hidden;
  scroll-behavior: smooth;
  margin-bottom: 0;
}
.tabs-box.dragging {
  scroll-behavior: auto;
  cursor: grab;
}
.tabs-box .tab {
  cursor: pointer;
  font-size: 1rem;
  white-space: nowrap;
  background: white;
  padding: 5px 15px;
  border-radius: 30px;
  border: 1px solid #FF8D09;
  user-select: none;
}
.tabs-box .tab:hover {
  background: #fafafa;
}
.tabs-box.dragging .tab {
  user-select: none;
  pointer-events: none;
}
.tabs-box .tab.active {
  color: #fff;
  background: #FF8D09;
  border-color: transparent;
}

.realisation-titre {
    font-weight: bold;
    font-size: 22px;
    margin-top: 1rem;
}


.image-prestation {
  width: 280px; height: 280px; background-position: center; background-size: cover;
}

.titre-prestation {
  padding-top: 10px; width: 280px; text-align: center; margin-bottom: 0; padding-bottom: 0;
}

.grid-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  grid-gap: 1.8vw;
  max-width: 100%;
  margin: 0 auto;
}

.grid-item {
  flex: 0 1 calc(25% - 20px);
  margin-bottom: 20px;
  background-color: #fafafa;
  border: 1px solid #ddd;
  padding: 20px;
  min-height: 380px;
  box-sizing: border-box;
  text-align: center;
  cursor: pointer;
}


.carousel-inner {  
  background-color: #232323;  
  border-top-left-radius: 12px;
  border-bottom-left-radius: 12px;
  width: 600px;
}

.img-size{
  width: 600px;
  height: 600px;
  background-position: center; background-size: contain; background-repeat: no-repeat;
}

.modal-body {
  padding: 0;
}

.modal-content {
  border-radius: 12px;
  position: relative;
}

.modal-lg {  
  max-width: 1000px;  
}

.modal-prestation-content {
  display: flex;
  justify-content: space-between;
  flex-flow: row;
}

.prestation-content {
  background-color: white;
  width: 400px;
  border-top-right-radius: 12px;
  border-bottom-right-radius: 12px;
  padding: 40px 20px;
}

.close {
  border: none;
  width: 26px;
  height: 26px;
  border-radius: 100px;
  color: white;
  background-color: #505050;
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 10;
}

ul {
  padding-left: 0;
}


@media (max-width: 768px) {
  .grid-item {
    flex: 0 1 calc(100% - 20px);
    min-width: 300px;
    min-height: 340px;
    margin-right: 0;
    margin-bottom: 20px;
  }
  .image-prestation {
    min-width: 300px;
  }
  .titre-prestation {
    min-width: 300px;
  }

  .grid-container {
  padding: 0;
}

  
.modal-prestation-content {
  display: flex;
  justify-content: space-between;
  flex-flow: column;
}

.prestation-content {
  background-color: white;
  width: 100%;
  border-bottom-right-radius: 12px;
  border-bottom-left-radius: 12px;
  padding: 20px;
}

.carousel-inner {  
  background-color: #232323;  
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
  border-bottom-left-radius: 0;
  width: 100%;
}

.img-size{
  width: 100%;
  height: 60vh;
}

.modal-dialog {
  height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.close {
  width: 50px;
  height: 50px;
}

.close span {
  font-size: 35px;
}

}



@media (max-width: 500px) {
  .grid-item {
    flex: 0 1 calc(100% - 20px);
    min-width: 100%;
    min-height: 340px;
    margin-right: 0;
    margin-bottom: 20px;
  }
  .image-prestation {
    min-width: 100%;
  }
  .titre-prestation {
    min-width: 100%;
  }

  .grid-container {
    width: 100%;
    display: flex;
    justify-content: center;
  }
}

</style>


















  <script>
const navToggler = document.querySelector('.nav-toggler');
const navMenu = document.querySelector('.site-navbar ul');
const navLinks = document.querySelectorAll('.site-navbar a');

allEventListners();

function allEventListners() {
  navToggler.addEventListener('click', togglerClick);
  navLinks.forEach( elem => elem.addEventListener('click', navLinkClick));
}

function togglerClick() {
  navToggler.classList.toggle('toggler-open');
  navMenu.classList.toggle('open');
}

function navLinkClick() {
  if(navMenu.classList.contains('open')) {
    navToggler.click();
  }
}
  </script>

</body>
</html>