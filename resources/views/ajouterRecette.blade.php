<!doctype html>
<html>

<head>

    <!--
ETML
Auteur: Saska Petrovic
Date: 29.05.2023
Description: Page d'ajout d'une recette
-->
    <title>ajouter une recette</title>
</head>

<body>
    <!--inclure le header-->
    @include('header')

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto flex flex-col">
            <a href="{{ url('/recette') }}"><button id="defaultBtn" type="submit" class="inline-flex text-black border-0 mr-2 mt-5 py-2 px-5 focus:outline-none rounded text-lg">Retour</button></a>
            <div class="lg:w-4/6 mx-auto p-5 border-2 border-gray-200 rounded-lg">

                <h2 class="font-medium title-font mt-3 mb-3 pb-3 text-gray-800 text-2xl border-dashed border-b-2 border-indigo-300">Ajouter une recette</h2>
                <!--formulaire d'ajout-->
                <form action="{{ route('ajouterRecette') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center mb-4">
                        <label for="fkUser" class="w-1/4 block text-gray-700 font-bold">Utilisateur :</label>
                        <div class="w-3/4">
                            <span class="w-full px-3 py-1 text-base leading-8 text-gray-700 ">
                                {{ auth()->user()->name }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <label for="recDateAjout" class="w-1/4 block text-gray-700 font-bold ">Date d'ajout :</label>
                        <div class="w-3/4">
                            <input type="datetime-local" name="recDateAjout" class=" w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200" required>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <label for="recTemps" class=" w-1/4 block text-gray-700 font-bold ">Temps de préparation :</label>
                        <div class="w-3/4">
                            <input type="time" name="recTemps" placeholder="Ex: 10" class=" w-full  px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200" required>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <label for="recNbDePersonne" class=" w-1/4  block text-gray-700 font-bold ">Nombre de personnes :</label>
                        <div class="w-3/4">
                            <input type="number" name="recNbDePersonne" class="w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200" placeholder="Ex: 5" required>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <label for="recTitre" class="w-1/4 block text-gray-700 font-bold">Titre :</label>
                        <div class="w-3/4">
                            <input type="text" name="recTitre" placeholder="titre de la recette" class=" w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200" required>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="categorie" id="categories">
                        <div class="flex items-center mb-4">
                            <label class="w-1/4">Catégories</label>
                            <div class="w-3/4">
                                <select name="categories[]" class="form-select w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200">
                                    @foreach($categories as $categorie)
                                    <option value="{{ $categorie->idCategorie }}">{{ $categorie->catNom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="ajouterCategorie()" 
                    class="bg-blue-500 hover:bg-blue-700 text-white
                     font-bold py-2 px-4 rounded mt-2" id="monBouton">Ajouter une catégorie
                    </button>

                    <hr class="my-4">
                    <div class="ingredient" id="ingredients">
                        <div class="flex items-center mb-4">
                            <label class="w-1/4">Ingrédients</label>
                            <div class="w-3/4">
                                <div class="relative flex">
                                    <select name="ingredients[]" class="form-select w-3/4 px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200">
                                        @foreach($ingredients as $index => $ingredient)
                                        <option value="{{ $ingredient->idIngredient }}" for="ingredient{{ $ingredient->idIngredient }}">{{ $ingredient->ingNom }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" required name="utiQuantite[]" placeholder="Quantité" 
                                    class="w-1/4 px-3 py-1 text-base leading-8 text-gray-700 transition-colors 
                                    duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300
                                     rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 
                                     focus:ring-purple-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="ajouterIngredient()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" id="monBouton">Ajouter un ingrédient</button>
                    <hr class="my-4">

                    <div class="flex items-center mb-4">
                        <label for="recPreparation" class="w-1/4 block text-gray-700 font-bold ">Préparation :</label>
                        <div class="w-3/4">
                            <textarea type="text" name="recPreparation" placeholder="Lorem ipsum dolor sit amet consectetur adipisicing elit. " class=" w-full px-3 py-1 text-base leading-8 text-gray-700 transition-colors duration-200 ease-in-out bg-gray-100 bg-opacity-50 border border-gray-300 rounded outline-none focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200" required></textarea>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <label for="recImageLien" class="w-1/4 block text-gray-700 font-bold ">Image :</label>
                        <div class="w-3/4">
                            <input type="file" name="recImageLien" id="recImageLien" class="py-2 px-3 mt-1  block w-full">
                        </div>
                    </div>

                    <button type="submit" class="inline-flex border-0 mr-2 mt-4 py-2 px-5 focus:outline-none rounded text-lg" id="defaultBtn">Validé</button>
                </form>
            </div>
        </div>
    </section>
    <!--inclue le script qui ajoute des espaces pour 
      les catégories et les ingrédients -->
    @include('ajouterIngredientCategorie')
</body>
<!--inclure le footer-->
@include('footer')

</html>