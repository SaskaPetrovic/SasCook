<?php
/**
 * ETML
 * Auteur      : Saska Petrovic
 * Date        : 16.05.2023
 * Description : Contrôleur permettant de gérer la bd_sascook
 */
namespace App\Http\Controllers;
use App\Models\t_categorie;
use App\Models\t_ingredient;
use App\Models\t_recette;
use App\Models\t_appartenir;
use App\Models\t_utiliser;
use App\Models\t_contenir;
use App\Models\t_generer;
use App\Models\t_listeDeCourse;
use App\Models\t_planifier;
use Illuminate\Http\Request;




class recipeController extends Controller
{

    //-------------------------- Accueil, afficher la dernière recette ajoutée sur le site -------------------------------------------//
    public function homeRecipe()
    {
    // Récupère les informations de la dernière recette ajoutée
    $lastRecipe = t_recette::select(
        't_recette.idRecette',
        't_recette.recTitre',
        't_recette.recImageLien',
        't_recette.created_at',
        t_categorie::raw('GROUP_CONCAT(t_categorie.catNom SEPARATOR ", ") as categorie')
    )
        ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.fkRecette')
        ->leftJoin('t_categorie', 't_appartenir.fkCategorie', '=', 't_categorie.idCategorie')
        ->orderBy('t_recette.created_at', 'desc')
        ->groupBy('t_recette.idRecette')
        ->first();


        //----------------------------------------- Accueil, afficher une recette aléatoire sur la page d'accueil -------------------------------------------//

        //---------- ChatGPT utilisé pour le sec_to_time --------------//
        // Récupère les informations de la recette et permet d'en afficher une aléatoirement
        $randomRecipe = t_recette::select(
            't_recette.idRecette',
            't_recette.recTitre',
            't_recette.recImageLien',
            't_recette.created_at',
            t_recette::raw("SEC_TO_TIME(TIME_TO_SEC(t_recette.recTemps)) AS recTemps"),
            t_categorie::raw('GROUP_CONCAT(t_categorie.catNom SEPARATOR ", ") as categorie')
        )
            ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.fkRecette')
            ->leftJoin('t_categorie', 't_appartenir.fkCategorie', '=', 't_categorie.idCategorie')
            ->where('t_recette.recTemps', '<=', '00:30:00')
            ->groupBy('t_recette.idRecette')
            ->inRandomOrder()
            ->limit(1)
            ->first();


        // Retourner la vue avec toutes les informations
        return view('accueil', [
            'lastRecipe' => $lastRecipe, 'randomRecipe' => $randomRecipe,
        ]);
    }

    //----------------------------------------- Recette, afficher toutes les recettes sur la page de recettes -------------------------------------------//
    public function allRecipies(Request $request)
    {
        $categories = t_categorie::all();
        $ingredients = t_ingredient::all();

        $selectedCategorie = $request->input('categories', []);
        $selectedIngredient = $request->input('ingredients', []);

        // Récupère les informations de la recette
        $allRecipies = t_recette::select(
            't_recette.idRecette',
            't_recette.recTitre',
            't_recette.recImageLien',
            t_categorie::raw('GROUP_CONCAT(DISTINCT t_categorie.catNom SEPARATOR ", ") as categorie'),
            t_ingredient::raw('GROUP_CONCAT(DISTINCT CONCAT_WS(" ", t_ingredient.ingNom, t_utiliser.utiQuantite, t_ingredient.ingUniteDeMesure) SEPARATOR ", ") as ingredients')
        )
            ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.fkRecette')
            ->leftJoin('t_categorie', 't_appartenir.fkCategorie', '=', 't_categorie.idCategorie')
            ->leftJoin('t_utiliser', 't_recette.idRecette', '=', 't_utiliser.fkRecette')
            ->leftJoin('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
            ->orderBy('t_recette.created_at', 'desc')
            ->groupBy('t_recette.idRecette');



        /*-----------------------------------filtre de catégorie et d'ingrédient----------------------------------------*/


        // Filtre par categorie si des categories sont sélectionnées
        if (!empty($selectedCategorie)) {
            $allRecipies->whereIn('t_categorie.idCategorie', $selectedCategorie);
        }

        // Filtre par ingredient si des ingredients sont sélectionnés
        if (!empty($selectedIngredient)) {
            $allRecipies->whereIn('t_ingredient.idIngredient', $selectedIngredient);
        }
        $allRecipiesUpdate = $allRecipies->get();

        // Si aucune recette n'est trouvé pour les catégories et ingredients sélectionnés alors un message s'affiche
        if ($allRecipiesUpdate->isEmpty()) {
            $messageFilter = "Aucune recette disponible";
        } else {
            $messageFilter = null;
        }

        //chatGpt m'a aidé pour afficher que les ingredients utilisés
        $usedIngredients = t_utiliser::distinct('idIngredient')->pluck('fkIngredient');
        $ingredients = t_ingredient::whereIn('idIngredient', $usedIngredients)->get();
        

        /*-----------------------------------filtre de recherche----------------------------------------*/

        // Récupère la requête de recherche
        $query = $request->input('query');

        // Vérifie si une recherche a été effectuée
        if ($query) {
            // Récupère les informations de la recette
            $searchRecipe = t_recette::select(
                't_recette.idRecette',
                't_recette.recTitre',
                't_recette.recImageLien',
                t_categorie::raw('GROUP_CONCAT(DISTINCT t_categorie.catNom SEPARATOR ",") as categorie'),
                t_ingredient::raw('GROUP_CONCAT(DISTINCT CONCAT_WS(" ", t_ingredient.ingNom, t_utiliser.utiQuantite, t_ingredient.ingUniteDeMesure) SEPARATOR ", ") as ingredients')
            )
                ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.fkRecette')
                ->leftJoin('t_categorie', 't_appartenir.fkCategorie', '=', 't_categorie.idCategorie')
                ->leftJoin('t_utiliser', 't_recette.idRecette', '=', 't_utiliser.fkRecette')
                ->leftJoin('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_recette.recTitre', 'like', "%$query%") // recherche de titre de recette contenant la requête
                ->orderBy('t_recette.created_at', 'desc')
                ->groupBy('t_recette.idRecette')
                ->get();

            // Vérifie si une recette correspond à la recherche sinon cela affiche un message
            if ($searchRecipe->isEmpty()) {
                $messageSearch = "Aucune recette n'a été trouvée pour votre recherche.";
            } else {
                $messageSearch = null;
            }

            return view('recette', [
                'allRecipiesUpdate' => $searchRecipe,
                'messageSearch' => $messageSearch,
                'categories' => $categories,
                'ingredients' => $ingredients,
            ]);
        }

        return view('recette', [
            'allRecipiesUpdate' => $allRecipiesUpdate,
            'messageSearch' => null,
            'messageFilter' => $messageFilter,
            'selectedCategorie' => $selectedCategorie,
            'selectedIngredient' => $selectedIngredient,
            'categories' => $categories,
            'ingredients' => $ingredients,
        ]);
    }


    /*-----------------------------------PAGE DE DESCRIPTION - description des recettes et mise à jour des ingrédients----------------------------------------*/

    public function descriptionRecipies($id, Request $request)
    {
        // Récupère les informations de la recette
        $infoRecipies = t_recette::select(
            't_recette.*',
            t_categorie::raw('GROUP_CONCAT(DISTINCT t_categorie.catNom SEPARATOR ", ") as categorie'),
            t_ingredient::raw('GROUP_CONCAT(DISTINCT CONCAT_WS(" ", t_utiliser.utiQuantite, t_ingredient.ingUniteDeMesure, t_ingredient.ingNom) SEPARATOR ", ") as ingredients')
        )
            ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.fkRecette')
            ->leftJoin('t_categorie', 't_appartenir.fkCategorie', '=', 't_categorie.idCategorie')
            ->leftJoin('t_utiliser', 't_recette.idRecette', '=', 't_utiliser.fkRecette')
            ->leftJoin('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
            ->where('t_recette.idRecette', '=', $id)
            ->groupBy('t_recette.idRecette')
            ->first();

        $numPeople = $infoRecipies->recNbDePersonne;


        // Vérifie si des modifications de quantités ont été faites dans la vue
        if ($request->has('servings')) {
            $numPeople = $request->input('servings');

            // Récupère les ingrédients associés à la recette
            $ingredients = t_utiliser::select('utiQuantite', 'ingUniteDeMesure', 'ingNom')
                ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_utiliser.fkRecette', $id)
                ->get();

            // Met à jour les quantités des ingrédients en fonction du nombre de personnes
            foreach ($ingredients as $ingredient) {
                $quantity = $ingredient->utiQuantite;

                $updatedQuantity = $quantity * $numPeople;

                $ingredient->utiQuantite = $updatedQuantity;
            }
        } else {
            // Pas de soumission de mise à jour de quantités donc cela utilise les quantités par défaut dans la base de donnée
            $ingredients = t_utiliser::select('utiQuantite', 'ingUniteDeMesure', 'ingNom')
                ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_utiliser.fkRecette', $id)
                ->get();
        }

        return view('description', [
            'infoRecipies' => $infoRecipies,
            'ingredients' => $ingredients,
            'numPeople' => $numPeople
        ]);
    }


    /*-----------------------------------PAGE DE FORMULAIRE - ----------------------------------------*/


    public function formListeDeCourse($id, Request $request)
    {

        $getIdRecipe = t_recette::select('idRecette', 'recTitre', 'recNbDePersonne')
            ->where('t_recette.idRecette', '=', $id)
            ->first();

        $numPeople = $getIdRecipe->recNbDePersonne;
        $calculateQuantities = [];

        if ($request->has('servingsList')) {
            $numPeople = $request->input('servingsList');

            $request->session()->put('numPeople', $numPeople);

            $ingredients = t_utiliser::select('utiQuantite', 'ingUniteDeMesure', 'ingNom')
                ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_utiliser.fkRecette', $id)
                ->get();


            foreach ($ingredients as $ingredient) {
                $quantity = $ingredient->utiQuantite;

                $updatedQuantity = $quantity * $numPeople;

                $ingredient->utiQuantite = $updatedQuantity;
            }
        } else {

            $ingredients = t_utiliser::select('utiQuantite', 'ingUniteDeMesure', 'ingNom')
                ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_utiliser.fkRecette', $id)
                ->get();
        }

        /*calcul */

            //vérifie qu'il y a le "formIngredientQuantity" dans la vue
        if ($request->has('formIngredientQuantity')) {
            $ingredientQuantities = $request->input('formIngredientQuantity');
            $getNumPeople = $request->session()->get('numPeople');

            $calculateQuantities = t_utiliser::select('utiQuantite', 'ingUniteDeMesure', 'ingNom')
                ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_utiliser.fkRecette', $id)
                ->get();

            foreach ($calculateQuantities as $index => $calculateQuantity) {
                $initialQuantity = $calculateQuantity->utiQuantite;

                $initialQuantity *= $getNumPeople;
                $enteredQuantity = $ingredientQuantities[$index];
                $updatedQuantity = $initialQuantity - $enteredQuantity;


                $updatedQuantity = max(0, $updatedQuantity);

                $calculateQuantity->updatedQuantity = $updatedQuantity;
            }
        } else {
            $calculateQuantities = t_utiliser::select('utiQuantite', 'ingUniteDeMesure', 'ingNom')
                ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_utiliser.fkRecette', $id)
                ->get();
        }

        return view('listeDeCourse', [
            'getIdRecipe' => $getIdRecipe,
            'ingredients' => $ingredients,
            'numPeople' => $numPeople,
            'calculateQuantities' => $calculateQuantities,
        ]);
    }

    /*--------------------------------------------------------------ajouter la liste de course dans la base de données--------------------------------*/

    public function addGroceryList(Request $request, $idRecette)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Vérifier que l'utilisateur est bien connecté
        if (!$user) {
            return redirect()->back();
        }

        // Vérifier que la recette existe
        $recette = t_recette::find($idRecette);
        if (!$recette) {
            return redirect()->back();
        }

        // Récupérer la date actuelle pour lisDate
        $lisDate = date('Y-m-d');

        // Créer une nouvelle liste de course
        $listeDeCourse = t_listeDeCourse::create([
            'lisDate' => $lisDate,
        ]);

        // Relier la recette à la liste de courses via la table t_generer
        t_generer::create([
            'fkListeDeCourse' => $listeDeCourse->idListeDeCourse,
            'fkRecette' => $idRecette,
        ]);

        // Associer la liste de courses à l'utilisateur via la table t_planifier
        t_planifier::create([
            'fkUser' => $user->id,
            'fkListeDeCourse' => $listeDeCourse->idListeDeCourse,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Récupérer les informations sur les ingrédients de la recette
        $ingredients = t_utiliser::select(
            't_utiliser.fkIngredient',
            't_utiliser.utiQuantite',
            't_ingredient.ingUniteDeMesure',
            't_ingredient.ingNom'
        )
            ->join('t_ingredient', 't_utiliser.fkIngredient', '=', 't_ingredient.idIngredient')
            ->where('t_utiliser.fkRecette', $idRecette)
            ->get();

        // Parcourir les ingrédients et les ajouter à la liste de courses
        foreach ($ingredients as $ingredient) {
            if ($ingredient->utiQuantite > 0) {
                t_contenir::create([
                    'fkListeDeCourse' => $listeDeCourse->idListeDeCourse,
                    'fkIngredient' => $ingredient->fkIngredient,
                    'conQuantite' => $ingredient->utiQuantite,
                ]);
            }
        }

        $msgAjouterListeCourse = 'La liste de courses a été ajoutée avec succès';
        return redirect()->route('accueil')->with(['msgAjouterListeCourse' => $msgAjouterListeCourse]);
    }


    public function showGroceryLists()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer tous les mangas favoris de l'utilisateur
        $userId = t_planifier::where('fkUser', $user->id)->get();

        // Récupérer toutes les listes de courses de l'utilisateur

        $groceryList = t_listeDeCourse::select(
            't_listeDeCourse.idListeDeCourse',
            't_listeDeCourse.lisDate',
            't_recette.recTitre',
            t_contenir::raw('GROUP_CONCAT(DISTINCT CONCAT_WS("  ", t_ingredient.ingNom, t_contenir.conQuantite, t_ingredient.ingUniteDeMesure) SEPARATOR ", ") as ingredients')
        )
            ->leftJoin('t_generer', 't_listeDeCourse.idListeDeCourse', '=', 't_generer.fkListeDeCourse')
            ->leftJoin('t_recette', 't_generer.fkRecette', '=', 't_recette.idRecette')
            ->leftJoin('t_contenir', 't_listeDeCourse.idListeDeCourse', '=', 't_contenir.fkListeDeCourse')
            ->leftJoin('t_ingredient', 't_contenir.fkIngredient', '=', 't_ingredient.idIngredient')
            ->whereIn('t_listeDeCourse.idListeDeCourse', $userId->pluck('fkListeDeCourse'))
            ->orderBy('t_listeDeCourse.lisDate', 'desc')
            ->groupBy('t_listeDeCourse.idListeDeCourse', 't_listeDeCourse.lisDate', 't_recette.recTitre')
            ->get();




        //Si l'utilisateur n'a pas de liste de course, afficher le message "Aucune liste de courses pour le moment"
        if ($groceryList->isEmpty()) {
            $message = "Aucune liste de courses pour le moment";
            return view('afficherListeDeCourse', ['message' => $message, 'groceryList' => $groceryList]);
        }

        return view('afficherListeDeCourse', ['groceryList' => $groceryList]);
    }


    //------------------------------------Page d'ajout d'une recette------------------------------------------//

    //ajouter un recipe dans la base de donnée depuis le site
    public function addRecipe(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'recTitre' => 'required',
            'recTemps' => 'required',
            'recImageLien' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
            ],
            'recNbDePersonne' => 'required|numeric',
            'recDateAjout' => 'required',
            'recPreparation' => 'required',
            'categories' => 'required|array|min:1',
            'ingredients' => 'required|array|min:1',
        ]);

        // Récupération de l'utilisateur connecté
        $user = auth()->user();

        // Enregistrement de l'image et récupération du chemin
        if ($file = $request->hasFile('recImageLien')) {
            $file = $request->file('recImageLien');
            $fileNameWithExt = $file->getClientOriginalName(); // Nom avec extension 'filename.jpg'
            $imageName = explode('.', $fileNameWithExt)[0]; // Nom de fichier 'filename'
            $extension = $file->getClientOriginalExtension(); // Extension 'jpg'
            $recImageLien = public_path() . '/img';
            $uploadname = $imageName . '-' . time() . '.' . $extension;
            $file->move($recImageLien, $uploadname);
        }

        // Insertion d'une recette dans la base de données
        $newRecipe = new t_recette([
            'recTitre' => $validatedData['recTitre'],
            'recTemps' => $validatedData['recTemps'],
            'recImageLien' => $uploadname,
            'recNbDePersonne' => $validatedData['recNbDePersonne'],
            'recDateAjout' => $validatedData['recDateAjout'],
            'recPreparation' => $validatedData['recPreparation'],
            'fkUser' => $user->id,
            

        ]);
        $newRecipe->save();
  
        // Lier les catégories à la recette
        $categories = $request->input('categories', []);
        $categoriesData = [];
        foreach ($categories as $categoryId) {
            if (!is_null($categoryId)) {
                $categoriesData[] = $categoryId;
            }
        }
        $newRecipe->categories()->sync($categoriesData);

        // Lier les ingrédients à la recette
        $ingredients = $request->input('ingredients', []);
        $quantites = $request->input('utiQuantite', []);
        $ingredientsData = [];
        foreach ($ingredients as $index => $ingredientId) {
            if (!is_null($ingredientId)) {
                $quantite = $quantites[$index];
                $ingredientsData[$ingredientId] = ['utiQuantite' => $quantite];
            }
        }
        $newRecipe->ingredients()->sync($ingredientsData);

        $msgNewRecipe = 'La recette a été ajoutée sur le site';

        // Redirection vers la page d'accueil
        return redirect()->route('accueil')->with([
            'msgNewRecipe' => $msgNewRecipe,
        ]);
    }



    // permet d'afficher les categorie et les ingredients dans la page "ajouterRecette"
    public function getCategorieAndIngredient()
    {
        // Récupération des categories et des ingredients depuis la base de données
        $categories = t_categorie::all();
        $ingredients = t_ingredient::all();

        return view('ajouterRecette', [
            'categories' => $categories,
            'ingredients' => $ingredients,
        ]);
    }

}
