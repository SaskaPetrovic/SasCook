<!DOCTYPE html>
<html lang="en">

<head>
    <!--
    ETML
    Auteur      : Saska Petrovic
    Date        : 16.05.23
    Description : Page de description qui affiche la recette que l'utilisateur à choisi de cliquer, ajustement des quantités en fonction du nombre de personne possible

    -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Description</title>
    <link rel="icon" href="{{'/img/logoSite.png'}}" type="image/icon type">
</head>

<!--inclure le header dans la page de description -->
@include('header')

<body>
   
    <section class="text-gray-600 body-font">
        
        <div class="container px-5 py-24 mx-auto flex flex-col">
        <a href="{{ url('/recette') }}"><button id="defaultBtn" type="submit" class="inline-flex text-black border-0 mr-2 mt-5 py-2 px-5 focus:outline-none rounded text-lg">Retour</button></a>
            <div class="lg:w-3/5 mx-auto p-5 border-2 border-gray-200 rounded-lg">
                
                <h2 class="font-medium title-font mt-3 mb-3 text-gray-800 text-2xl">{{ $infoRecipies->recTitre }}</h2>
                <h2 class="font-medium title-font mt-1 mb-6 text-gray-500 text-lg">{{ $infoRecipies->categorie }}</h2>
                                
                <div class="rounded-md overflow-hidden">
                    <img alt="content" class="object-cover object-center w-full h-[32rem]" src='{{"/img/".$infoRecipies -> recImageLien }}'>
                </div>
                <div class="flex flex-col sm:flex-row mt-10">
                    <div class="sm:w-1/3 text-center sm:pr-8 sm:py-8">

                        <div class="flex flex-col sm:flex-row ">
                            <img alt="content" class="object-cover object-center w-full h-[32rem]	" id="desImgSize" src='{{"/img/clock.png" }}'>
                            <!--trouvé sur stack overflow afin de séparer la date et l'heure-->
                            <h2 class="font-medium title-font mt-4 mb-5 text-gray-600 text-lg ml-4">{{ date("H:i:s", strtotime($infoRecipies->recTemps))  }}</h2>
                        </div>

                        <form action="{{ route('description', ['id' => $infoRecipies->idRecette]) }}" method="POST">
                            @csrf
                            <div class="flex flex-col sm:flex-row mt-6">
                                <img alt="content" class="object-cover object-center w-full h-[32rem]	" id="desImgSize" src='{{"/img/fork.png" }}'>
                                <!--chatGpt utilisé pour que la valeur du nombre de personne choisi soit conservé-->
                                <input type="number" name="servings" min="1" max="30" value="{{ old('servings', $numPeople) }}" class="form-control w-16 h-12 ml-4 text-gray-500 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none ">
                                <button type="submit" class="inline-flex text-black ml-3  p-2  bg-gray-100 focus:outline-none rounded text-md">Mettre à jour</button>
                            </div>
                        </form>

                        <div class="flex flex-col mb-7 text-left  ">
                            <h2 class="font-medium title-font mt-8 text-gray-600 text-lg">INGREDIENTS</h2>
                        </div>

                        <ul class="text-s font-medium tracking-widest text-gray-500 text-left">
                            @foreach($ingredients as $ingredient)
                            <li>{{ $ingredient->ingNom }} {{ $ingredient->utiQuantite }} {{ $ingredient->utiUniteDeMesure }} </li>
                            @endforeach
                        </ul>
                       
                        
                    </div>
                    <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                        <h2 class="font-medium title-font mt-4 mb-5 text-gray-600 text-lg">PREPARATION</h2>
                        <p class=" text-lg mb-4 text-justify leading-loose	">{{ $infoRecipies->recPreparation }} </p>
                    </div>
                </div>
                <h3 class="font-medium title-font mt-10 mb-1 text-gray-600 text-md">Voulez-vous générer une liste de course ? </h3>
                <a href="{{ url('/listeDeCourse', ['id' => $infoRecipies->idRecette]) }}"><button id="defaultBtn" type="submit" class="inline-flex border-0 mr-2 mt-4 py-2  px-5 focus:outline-none rounded text-lg">Générer</button></a>
            </div>
        </div>
    </section>
</body>
<!--inclure le footer dans la page de recette  -->
@include('footer')

</html>