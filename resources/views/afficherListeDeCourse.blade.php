<!DOCTYPE html>
<html lang="en">

<head>

    <!--
ETML
Auteur      : Saska Petrovic
Date        : 17.05.23
Description : Page de recette qui affiche toutes les recettes de la base de données

-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Afficher la liste de course</title>
    <link rel="icon" href="{{'/img/logoSite.png'}}" type="image/icon type">
</head>
<!--inclure le header dans la page d'accueil -->
@include('header')

<body>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex w-full mb-20">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">Toutes les listes de courses</h1>
                    <div class="h-1 w-20 bg-indigo-200 rounded"></div>
                </div>
            </div>

            <form action="{{ route('afficherListeDeCourse') }}" method="get">
                @csrf

                <div class="flex flex-wrap -m-4">
                    @if ($groceryList->isEmpty())
                    <p>{{ $message }}</p>
                    @else
                    <!--afficher les listes des courses-->
                    @foreach ($groceryList as $list)
                    <div class="xl:w-1/4 md:w-1/2 p-4">
                        <div class="bg-gray-100 p-6 rounded-lg" id="RecipeCard">
                            <h3 class="text-xl font-medium tracking-widest text-gray-700 title-font">Liste de courses du </h3>
                            <h3 class="text-xl font-medium tracking-widest text-gray-700 title-font pb-3 border-dashed border-b-2 border-indigo-200">{{ $list->lisDate }}</h3>

                            <h2 class="text-xl font-medium tracking-widest text-gray-700 title-font pt-2 pb-6">{{ $list->recTitre }}</h2>
                            <h2 class="text-s font-medium tracking-widest text-gray-500 title-font">
                                <ul class="text-s tracking-widest">
                                    @foreach(explode(", ", $list->ingredients) as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                    @endforeach
                                </ul>
                            </h2>
                        </div>
                    </div>

                    @endforeach
                    @endif
                </div>
            </form>

        </div>
    </section>

</body>
<!--inclure le footer dans la page de recette  -->
@include('footer')

</html>