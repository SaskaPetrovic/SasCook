<!--
ETML
Auteur      : Saska Petrovic
Date        : 16.05.2023
Description : dropdown du header
-->

<script>
  // Récupère le bouton dropdown
var dropdown = document.querySelector('.dropdown-btn');
// Récupère le contenu du dropdown
var dropdownContent = dropdown.nextElementSibling;

// Ajoute un événement de clic sur le bouton dropdown
dropdown.addEventListener('click', function() {
  toggleDropdown();
});

// Ajoute un écouteur d'événement sur le document
document.addEventListener('click', function(event) {
  // Vérifie si l'événement a été déclenché en dehors du dropdown
  if (!dropdown.contains(event.target) && !dropdownContent.contains(event.target)) {
    // Cache le contenu du dropdown
    dropdownContent.style.display = 'none';
  }
});

// Fonction pour afficher/cacher le dropdown
function toggleDropdown() {
  // Vérifie si le contenu du dropdown est déjà affiché ou non
  if (dropdownContent.style.display === 'block') {
    // Cache le contenu du dropdown
    dropdownContent.style.display = 'none';
  } else {
    // Affiche le contenu du dropdown
    dropdownContent.style.display = 'block';
  }
};

</script>
