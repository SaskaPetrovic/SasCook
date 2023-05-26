<!DOCTYPE html>
<html lang="en">

<head>
    <!--
    ETML
    Auteur      : Saska Petrovic
    Date        : 25.05.23
    Description : Page de formulaire permettant à l'utilisateur de générer une liste de course

    -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Générer une liste de course</title>
    <link rel="icon" href="{{'/img/logoSite.png'}}" type="image/icon type">
</head>

<!--inclure le header dans la page de formulaire de liste de course -->
@include('header')

<body>

    <section class="text-gray-600 body-font">

        <div class="container px-5 py-24 mx-auto flex flex-col">
            <a href="{{ url('/recette') }}"><button id="defaultBtn" type="submit" class="inline-flex text-black border-0 mr-2 mt-5 py-2 px-5 focus:outline-none rounded text-lg">Retour</button></a>
            <div class="lg:w-3/4 mx-auto p-5 border-2 border-gray-200 rounded-lg">
                <h2 class="font-medium title-font mt-3 mb-3 text-gray-800 text-2xl">{{ $listIngredients->recTitre }}</h2>
                <div class="flex flex-col sm:flex-row mt-5">
                    <div class="sm:w-2/3 text-left sm:pr-8 sm:py-8">

                        <form action="{{ route('formListeDeCourse', ['id' => $listIngredients->idRecette]) }}" method="POST">
                            @csrf
                            <div class="flex flex-col sm:flex-row mt-6">
                                <img alt="content" class="object-cover object-center w-full h-[32rem]	" id="desImgSize" src='{{"/img/fork.png" }}'>
                                <!--chatGpt utilisé pour que la valeur du nombre de personne choisi soit conservé-->
                                <input type="number" name="servingsList" min="1" max="30" value="{{ old('servings', $numPeople) }}" class="form-control w-16 h-12 ml-4 text-gray-500 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none ">
                                <button type="submit" class="inline-flex text-black ml-3  p-2  bg-gray-100 focus:outline-none rounded text-md">Mettre à jour</button>
                            </div>
                        </form>

                        <div class="flex flex-col mb-7 text-left">
                            <h2 class="font-medium title-font mt-8 text-gray-600 text-lg">INGREDIENTS</h2>
                        </div>

                        <form action="{{ route('formListeDeCourse', ['id' => $listIngredients->idRecette]) }}" method="POST">
                            <ul class="text-s tracking-widest ">
                                @foreach($ingredients as $ingredient)
                                <li>
                                    <div class="flex items-center mb-7 w-full">
                                        <span class="font-medium">{{ $ingredient->ingNom }} {{ $ingredient->utiQuantite }} {{ $ingredient->utiUniteDeMesure }}</span>
                                        <textarea name="formIngredientQuantity" placeholder="ex : 100" class="ml-auto h-12 bg-gray-100 rounded border bg-opacity-50 border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:bg-transparent focus:border-indigo-500 text-base outline-none text-gray-600 px-2 leading-1 transition-colors duration-200 ease-in-out" required></textarea>
                                        {{ $ingredient->utiUniteDeMesure }}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <a href="{{ url('/calculateUpdatedQuantities', ['id' => $listIngredients->idRecette]) }}"><button id="defaultBtn" type="submit" class="inline-flex border-0 mr-2 mt-4 py-2  px-5 focus:outline-none rounded text-lg">Mettre à jour</button></a>
                        </form>

                        <h3 class="text-left font-medium title-font mt-16 mb-1 text-gray-600 text-md">Voulez-vous mettre à jour votre liste de course ? </h3>



                    </div>
                    <div class="sm:w-1/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                        <h2 class="font-medium title-font mt-4 mb-5 text-gray-600 text-lg">Liste de course</h2>
                        <p class="font-medium title-font mt-8 mb-8 text-gray-600 text-lg">INGREDIENTS</p>
                        <ul class="text-s tracking-widest">
                           
                        </ul>


                        <a href=""><button id="defaultBtn" type="submit" class="inline-flex border-0 mr-2 mt-4 py-2  px-5 focus:outline-none rounded text-lg">Sauvegarder</button></a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</body>
<!--inclure le footer dans la page de recette  -->
@include('footer')

</html>