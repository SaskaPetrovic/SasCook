<!DOCTYPE html>
<html lang="en">

<head>
    <!--
ETML
Auteur      : Saska Petrovic
Date        : 16.05.23
Description : Page d'accueil qui affiche la dernière recette ajoutée ainsi qu'une recette aléatoire réalisable en moins de 30min

Version 1.0
Date        : 16.05.23
Auteur      : Saska Petrovic
Description : Dernière recette affichée


-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Accueil</title>
</head>
<!--inclure le header dans la page d'accueil -->
@include('header')

<body>
    <div class="container mx-auto px-5 text-3xl mt-10 pb-5 border-dashed border-b-2 border-indigo-200 ">
        En ce moment
    </div>
    <div class="container mx-auto px-5 text-xl mt-10 pb-5  ">
        Dernière recette ajoutée
    </div>
    <!--Dernière recette ajoutée dans la base de données-->
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-center">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded" alt="recette" id="AccImgSize" src='{{"/img/".$lastRecipe -> recImage }}'>
            </div>
            <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                <h2 class="title-font mb-4 font-medium text-gray-900">{{ $lastRecipe->categorie }}</h2>
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">{{ $lastRecipe-> recTitre}}</h1>
                <p class="mb-8 leading-relaxed text-justify">Ajoutée le : {{$lastRecipe->recDate}}</p>
                <div class="flex justify-center">
                    <a href="{{ url('/descriptionRecette') }}" class="text-indigo-500 inline-flex items-center mt-3">En savoir plus
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-5 text-xl	mt-10 ">
        Recette réalisable en moins de 30 min
    </div>
    <!-- Recette aléatoire réalisable en 30 min, bientot implémentée-->
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-center">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded"alt="recette" id="AccImgSize" src='{{"/img/".$randomRecipe -> recImage }}'>
            </div>
            <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                <h2 class="title-font mb-4 font-medium text-gray-900">{{ $randomRecipe->categorie }}</h2>
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">{{ $randomRecipe-> recTitre}}</h1>
                <p class="mb-2 leading-relaxed text-justify">Ajoutée le : {{$randomRecipe->recDate}}</p>
                <p class="mb-8 leading-relaxed text-justify">Temps : {{$randomRecipe->recTemps}}</p>
                <div class="flex justify-center">
                    <a href="{{ url('/descriptionRecette') }}" class="text-indigo-500 inline-flex items-center mt-3">En savoir plus
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>
<!--inclure le footer dans la page d'accueil -->
@include('footer')

</html>