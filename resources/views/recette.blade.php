<!DOCTYPE html>
<html lang="en">

<head>
    <!--
ETML
Auteur      : Saska Petrovic
Date        : 17.05.23
Description : Page de recette qui affiche toutes les recettes de la base de données ainsi que les filtres textuels et pour les catégories et les ingrédients
-->  
    <title>Recettes de SasCook</title>
</head>
<!--inclue le header dans la page d'accueil -->
@include('header')

<body>
    <section class="text-gray-600 body-font">
        <!----------------------------------------------FORMULAIRE RECHERCHE---------------------------------------------------->
        <form method="GET" action="{{ route('recette') }}">
            <section class="text-gray-600 body-font">
                <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center" id="rechercheSpace">
                    <div class="lg:flex-grow md:w-1/2 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                        <div class="flex w-full md:justify-center justify-center items-end">
                            <div class="relative mr-4 md:w-full lg:w-full xl:w-1/2 w-2/4">
                                <input placeholder="Rechercher des recettes..." type="text" name="query" class="w-full bg-gray-100 rounded borderbg-opacity-50 border-gray-300 focus:ring-2 focus:ring-indigo-200  focus:bg-transparent focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8  transition-colors duration-200 ease-in-out">
                            </div>
                            <button type="submit" class="inline-flex  border-0 py-2 px-6  focus:outline-none rounded text-lg" id="defaultBtn">Rechercher
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </form>

        <!--affiche les recettes de la recherche-->
        @if (!$allRecipiesUpdate->count() > 0)

        @foreach ($allRecipiesUpdate as $recette)
        {{ $recette->titre }}
        @endforeach

        @endif
        <!------------------------------------------------- FORMULAIRE CATEGORIE / INGREDIENT --------------------------------------------->
        <form method="GET" action="{{ route('recette') }}">
            <div id="imgFilter">
                <img class="object-cover object-center w-7 h-8" id="filter-btn" src='{{"/img/filtre.png" }}'>
            </div>
            <div id="filter-modal">
                <!-- Checkbox pour les CATEGORIES -->
                <div class="form-group" id="space-inside-modal">
                    <label for="categories" id="titleFilter">Catégories :</label>
                    <div id="flexFilter">
                        @foreach ($categories as $categorie)
                        <div class="form-check form-check-inline" id="verticalSpaceCheckbox">
                            <input class="form-check-input" type="checkbox" id="categorie{{ $categorie->idCategorie }}" 
                                name="categories[]" value="{{ $categorie->idCategorie }}">
                            <label class="form-check-label" for="categorie{{ $categorie->idCategorie }}" 
                                id="space-checkbox">{{ $categorie->catNom }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Checkbox pour les INGREDIENTS -->
                <div class="form-group" id="space-inside-modal">
                    <label for="ingredients" id="titleFilter">Ingredients :</label>
                    <div id="flexFilter">
                        @foreach ($ingredients as $ingredient)
                        <div class="form-check form-check-inline" id="verticalSpaceCheckbox">
                            <input class="form-check-input" type="checkbox" id="ingredient{{ $ingredient->idIngredient }}" 
                            name="ingredients[]" value="{{ $ingredient->idIngredient }}">
                            <label class="form-check-label" for="ingredient{{ $ingredient->idIngredient }}" 
                            id="space-checkbox">{{ $ingredient->ingNom }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <button id="defaultBtn" type="submit" class="inline-flex  border-0 mb-2 ml-7 py-1 px-5 
                        focus:outline-none rounded text-lg">Filtrer
                </button>
            </div>
        </form>




        <!---------------------------------------------- AFFICHER TOUTES LES RECETTES --------------------------------------------->
        <div class="container px-5 py-24 mx-auto">
            <div class="flex w-full mb-20">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">Toutes les recettes</h1>
                    <div class="h-1 w-20 bg-indigo-200 rounded"></div>
                </div>
            </div>
            <div class="flex flex-wrap -m-4">
                @foreach ($allRecipiesUpdate as $recette)
                <div class="xl:w-1/3 md:w-1/2 p-4">
                    <div class="bg-gray-100 p-6 rounded-lg" id="RecipeCard">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" alt="recette" id="AccImgSize" src='{{"/img/".$recette -> recImageLien }}'>
                        <h2 class="text-s font-medium tracking-widest text-gray-400 title-font">
                            @foreach(explode(" ", $recette->categorie) as $categorie)
                            {{ $categorie }}
                            @endforeach
                        </h2>

                        <h2 class="text-lg text-gray-900 font-medium title-font mt-4 mb-4">
                            {{ $recette->recTitre }}
                        </h2>

                        <a href="{{ url('/description',['id' => $recette->idRecette]) }}" class=" inline-flex items-center mt-3  text-indigo-400 ">En savoir plus
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
            <!--Message si aucune recette n'a été trouvé pour la barre de recherches-->
            @if(!empty($messageSearch))
            <div id="AccMessage">{{ $messageSearch }}</div>
            @endif
        </div>
    </section>
    <!--inclue le script qui permet l'ouverture et 
        la fermeture des filtres dans la page de recette -->
    @include('filtreModal')
</body>
<!--inclue le footer dans la page de recette  -->
@include('footer')

</html>