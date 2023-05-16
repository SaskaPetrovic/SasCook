<!--
ETML
Auteur      : Saska Petrovic
Date        : 16.05.2023
Description : dropdown du header
-->

<script>
  // Récupérer le bouton dropdown
var dropdown = document.querySelector('.dropdown-btn');
// Récupérer le contenu du dropdown
var dropdownContent = dropdown.nextElementSibling;

// Ajouter un événement de clic sur le bouton dropdown
dropdown.addEventListener('click', function() {
  toggleDropdown();
});

// Ajouter un écouteur d'événement sur le document
document.addEventListener('click', function(event) {
  // Vérifier si l'événement a été déclenché en dehors du dropdown
  if (!dropdown.contains(event.target) && !dropdownContent.contains(event.target)) {
    // Cacher le contenu du dropdown
    dropdownContent.style.display = 'none';
  }
});

// Fonction pour afficher/cacher le dropdown
function toggleDropdown() {
  // Vérifier si le contenu du dropdown est déjà affiché ou non
  if (dropdownContent.style.display === 'block') {
    // Cacher le contenu du dropdown
    dropdownContent.style.display = 'none';
  } else {
    // Afficher le contenu du dropdown
    dropdownContent.style.display = 'block';
  }
};

</script>
