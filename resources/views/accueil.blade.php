<!DOCTYPE html>
<html lang="en">

<head>
    <!--
    ETML
    Auteur      : Saska Petrovic
    Date        : 16.05.23
    Description : Page d'accueil qui affiche la dernière recette ajoutée ainsi qu'une recette aléatoire réalisable en moins de 30min

    -->
    <title>Accueil</title>
</head>
<!--inclure le header dans la page d'accueil -->
@include('header')

<body>
    <div class="container mx-auto px-5 text-3xl mt-10 pb-5 border-dashed border-b-2 border-indigo-200 ">
        En ce moment
    </div>
    <div class="container mx-auto px-5 text-xl mt-10 pb-5 ">
        Dernière recette ajoutée
    </div>
    <!--Dernière recette ajoutée dans la base de données-->
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-0 py-16 md:flex-row flex-col items-center">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded" alt="recette" id="AccImgSize" 
                    src='{{"/img/".$lastRecipe -> recImageLien }}'>
            </div>
            <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex 
            flex-col md:items-start md:text-left items-center text-center">

                <h2 class="title-font mb-4 font-medium text-gray-500">
                    {{ $lastRecipe->categorie }}
                </h2>

                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-800">
                    {{ $lastRecipe-> recTitre}}
                </h1>

                <p class="mb-8 title-font font-medium text-gray-500"><!--stack overflow-->
                    Ajoutée le : {{ date("Y-m-d", strtotime($lastRecipe->created_at))}} à {{ date("H:i:s", strtotime($lastRecipe->created_at))}}
                </p>

                <div class="flex justify-center">
                    <a href="{{ url('/description',['id' => $lastRecipe->idRecette]) }}" 
                    class=" inline-flex items-center mt-3 text-indigo-400">En savoir plus
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" 
                            stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" 
                            viewBox="0 0 24 24">
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
     <!-- Recette aléatoire réalisable en 30 min -->
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-16 md:flex-row flex-col items-center">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded" alt="recette" id="AccImgSize" src='{{"/img/".$randomRecipe -> recImageLien }}'>
            </div>
            <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                <h2 class="title-font mb-4 font-medium text-gray-500">{{ $randomRecipe->categorie }}</h2>
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-800">{{ $randomRecipe-> recTitre}}</h1>
                <p class="mb-2 title-font font-medium text-gray-500">Ajoutée le : {{ date("Y-m-d", strtotime($randomRecipe->created_at))}} à {{ date("H:i:s", strtotime($randomRecipe->created_at))}}</p><!--stack overflow-->
                <p class="mb-8 title-font font-medium text-gray-500">Temps : {{$randomRecipe->recTemps}}</p>
                <div class="flex justify-center">
                    <a href="{{ url('/description',['id' => $randomRecipe->idRecette]) }}" class=" inline-flex items-center mt-3 text-indigo-400">En savoir plus
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