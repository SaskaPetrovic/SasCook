<!--
ETML
Auteur      : Saska Petrovic
Date        : 22.05.2023
Description : permet de faire apparaitre et disparaitre le modal des filtres par categories et ingredients
-->

<script>
  //permet d'afficher la petite fenetre qui s'ouvre et se ferme quand l'utilisateur appuie sur l'icône des filtres-->///
  const filterBtn = document.getElementById('filter-btn');
  const filterModal = document.getElementById('filter-modal');
  const filterForm = document.getElementById('filter-form');

  filterBtn.addEventListener('click', function() {
    if (filterModal.style.display === 'block') {
      filterModal.style.display = 'none';
    } else {
      filterModal.style.display = 'block';
    }
  });

  filterForm.addEventListener('submit', function(event) {
    event.preventDefault();
    filterModal.style.display = 'none';
    filterForm.submit();
  });
</script>