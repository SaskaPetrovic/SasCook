<?php
/**
* ETML
* Auteur      : Saska Petrovic
* Date        : 16.05.2023
* Description : Controller permettant de gérer la bd_sascook
*/

namespace App\Http\Controllers;

use App\Models\t_categorie;
use App\Models\t_recette;
use Illuminate\Http\Request;
use Psy\Command\WhereamiCommand;

class recipeController extends Controller
{
    
    //----------------------------------------- Accueil, afficher la dernière recette ajoutée sur le site -------------------------------------------//
    public function lastRecipe()
    {
       // Récupérer la dernière recette ajoutée
       $lastRecipe = t_recette::select('t_recette.recTitre', 't_recette.recDate','t_recette.recImage', t_categorie::raw('GROUP_CONCAT(t_categorie.catNom SEPARATOR ", ") as categorie'))
        ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.idRecette')
        ->leftJoin('t_categorie', 't_appartenir.idCategorie', '=', 't_categorie.idCategorie')
        ->orderBy('t_recette.created_at', 'desc')
        ->groupBy('t_recette.idRecette')
        ->first();


        
     //----------------------------------------- Accueil, afficher une recette aléatoire sur la page d'accueil -------------------------------------------//
     
       //----------ChatGPT utilisé pour le sec_to_time --------------//
       $randomRecipe = t_recette::select('t_recette.recTitre', 't_recette.recDate','t_recette.recImage', t_recette::raw("SEC_TO_TIME(TIME_TO_SEC(t_recette.recTemps)) AS recTemps"), t_categorie::raw('GROUP_CONCAT(t_categorie.catNom SEPARATOR ", ") as categorie'))
       ->leftJoin('t_appartenir', 't_recette.idRecette', '=', 't_appartenir.idRecette')
       ->leftJoin('t_categorie', 't_appartenir.idCategorie', '=', 't_categorie.idCategorie')
       ->where('t_recette.recTemps', '<=', '00:30:00')
       ->groupBy('t_recette.idRecette')
       ->inRandomOrder()
       ->limit(1)
       ->first();


        // Retourner la vue avec toutes les informations
        return view('accueil', [
            'lastRecipe' => $lastRecipe,'randomRecipe' => $randomRecipe,
        ]);
    }

}
