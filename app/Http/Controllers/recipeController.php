<?php

/**
 * ETML
 * Auteur      : Saska Petrovic
 * Date        : 16.05.2023
 * Description : Controller permettant de gérer la bd_sascook
 */

namespace App\Http\Controllers;

use App\Models\t_categorie;
use App\Models\t_ingredient;
use App\Models\t_recette;
use App\Models\t_appartenir;
use App\Models\t_utiliser;
use Illuminate\Http\Request;
use Psy\Command\WhereamiCommand;
use Illuminate\Validation\Rule;


class recipeController extends Controller
{

    //----------------------------------------- Accueil, afficher la dernière recette ajoutée sur le site -------------------------------------------//
    public function lastRecipe()
    {
        // Récupérer la dernière recette ajoutée
        $lastRecipe = t_recette::select('t_recette.recTitre', 't_recette.recDate', 't_recette.recImage', 't_recette.created_at', t_categorie::raw('GROUP_CONCAT(t_categorie.catNom SEPARATOR ", ") as categorie'))
            ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.idRecette')
            ->leftJoin('t_categorie', 't_appartenir.idCategorie', '=', 't_categorie.idCategorie')
            ->orderBy('t_recette.created_at', 'desc')
            ->groupBy('t_recette.idRecette')
            ->first();



        //----------------------------------------- Accueil, afficher une recette aléatoire sur la page d'accueil -------------------------------------------//

        //----------ChatGPT utilisé pour le sec_to_time --------------//
        $randomRecipe = t_recette::select('t_recette.recTitre', 't_recette.recDate', 't_recette.recImage', t_recette::raw("SEC_TO_TIME(TIME_TO_SEC(t_recette.recTemps)) AS recTemps"), t_categorie::raw('GROUP_CONCAT(t_categorie.catNom SEPARATOR ", ") as categorie'))
            ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.idRecette')
            ->leftJoin('t_categorie', 't_appartenir.idCategorie', '=', 't_categorie.idCategorie')
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

        // Récupère toutes les recettes
        $allRecipies = t_recette::select(
            't_recette.*',
            t_categorie::raw('GROUP_CONCAT(DISTINCT t_categorie.catNom SEPARATOR ", ") as categorie'),
            t_ingredient::raw('GROUP_CONCAT(DISTINCT CONCAT_WS(" ", t_ingredient.ingNom, t_utiliser.utiQuantite, t_utiliser.utiUniteDeMesure) SEPARATOR ", ") as ingredients')
        )
            ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.idRecette')
            ->leftJoin('t_categorie', 't_appartenir.idCategorie', '=', 't_categorie.idCategorie')
            ->leftJoin('t_utiliser', 't_recette.idRecette', '=', 't_utiliser.idRecette')
            ->leftJoin('t_ingredient', 't_utiliser.idIngredient', '=', 't_ingredient.idIngredient')
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

        // Si aucune recette n'est trouvé pour les catégories et ingredients sélectionnés
        if ($allRecipiesUpdate->isEmpty()) {
            $messageFilter = "Aucune recette disponible";
        } else {
            $messageFilter = null;
        }



         /*-----------------------------------filtre de recherche----------------------------------------*/

        // Récupère la requête de recherche
        $query = $request->input('query');

        // Vérifie si une recherche a été effectuée
        if ($query) {
            // Effectue la recherche des recettes
            $searchRecipe = t_recette::select(
                't_recette.*',
                t_categorie::raw('GROUP_CONCAT(DISTINCT t_categorie.catNom SEPARATOR ",") as categorie'),
                t_ingredient::raw('GROUP_CONCAT(DISTINCT CONCAT_WS(" ", t_ingredient.ingNom, t_utiliser.utiQuantite, t_utiliser.utiUniteDeMesure) SEPARATOR ", ") as ingredients')
            )
                ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.idRecette')
                ->leftJoin('t_categorie', 't_appartenir.idCategorie', '=', 't_categorie.idCategorie')
                ->leftJoin('t_utiliser', 't_recette.idRecette', '=', 't_utiliser.idRecette')
                ->leftJoin('t_ingredient', 't_utiliser.idIngredient', '=', 't_ingredient.idIngredient')
                ->where('t_recette.recTitre', 'like', "%$query%") // recherche de titre de recette contenant la requête
                ->orderBy('t_recette.created_at', 'desc')
                ->groupBy('t_recette.idRecette')
                ->get();

            // Vérifier si une recette correspond à la recherche sinon cela affiche un message
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
}
