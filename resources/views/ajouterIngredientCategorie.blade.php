<script>
    //ajouter les catégories
        var nbCategories = 1;
        var categories = @json($categories); //chatGPT

        function ajouterCategorie() {
            // Permet d'ajouter un champ catégorie
            nbCategories++;

            var divCategorie = document.createElement("div");
            divCategorie.className = 'flex items-center mb-4';
            divCategorie.id = 'categorie' + nbCategories;

            var label = document.createElement("label");
            label.className = 'w-1/4';
            label.textContent = '';

            var button = document.createElement("button");
            button.type = 'button';
            button.textContent = 'Supprimer';
            button.className = 'bg-red-500 w-auto hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2';
            button.addEventListener('click', function() {
                divCategorie.remove();
            });

            label.appendChild(button);
            divCategorie.appendChild(label);

            var divSelect = document.createElement("div");
            divSelect.className = 'w-3/4';

            var select = document.createElement("select");
            select.name = 'categories[]';
            select.className = 'form-select w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200';

            categories.forEach(function(categorie) {
                var option = document.createElement("option");
                option.value = categorie.idCategorie;
                option.textContent = categorie.catNom;
                select.appendChild(option);
            });

            divSelect.appendChild(select);
            divCategorie.appendChild(divSelect);

            document.getElementById("categories").appendChild(divCategorie);
        }
    </script>

    <script>
        //ajouter les ingrédients
        var nbIngredients = 1;
        var ingredients = @json($ingredients); //chatGPT

        function ajouterIngredient() {
            nbIngredients++;

            var divIngredient = document.createElement("div");
            divIngredient.className = 'flex items-center mb-4';
            divIngredient.id = 'ingredient' + nbIngredients;

            var divButton = document.createElement("div");
            divButton.className = 'w-1/4';

            var removeButton = document.createElement("button");
            removeButton.type = 'button';
            removeButton.textContent = 'Supprimer';
            removeButton.className = 'bg-red-500 w-auto hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2 removeButton';
            removeButton.addEventListener('click', function() {
                divIngredient.remove();
            });

            divButton.appendChild(removeButton);
            divIngredient.appendChild(divButton);

            var divSelect = document.createElement("div");
            divSelect.className = 'w-3/4 flex';

            var select = document.createElement("select");
            select.name = 'ingredients[]';
            select.className = 'form-select w-3/4 px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200';

            ingredients.forEach(function(ingredient) {
                var option = document.createElement("option");
                option.value = ingredient.idIngredient;
                option.textContent = ingredient.ingNom;
                select.appendChild(option);
            });

            var inputQuantite = document.createElement("input");
            inputQuantite.type = 'text';
            inputQuantite.name = 'utiQuantite[]';
            inputQuantite.placeholder = 'Quantité';
            inputQuantite.className = 'w-1/4 px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200';

            divSelect.appendChild(select);
            divSelect.appendChild(inputQuantite);
            divIngredient.appendChild(divSelect);

            document.getElementById("ingredients").appendChild(divIngredient);
        }

    </script>