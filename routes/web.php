<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\recipeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
//------------------------------------------------Accueil---------------------------------------------//

//page d'accueil, dernière recette ajoutée
//page de recette, recette aléatoire en moins de 30 min + 
Route::get('/', [recipeController::class, 'homeRecipe'])->name('accueil');


//barre de recherche
//filtre des catégories et des ingrédients
Route::get('/recette', [recipeController::class, 'allRecipies'])->name('recette');


//------------------------------------------------description---------------------------------------------//

//affiche toutes les détails des recettes
Route::get('/description/{id}', [recipeController::class, 'descriptionRecipies'])->name('description');

//permet le calcule du nombre de personnes
Route::post('/description/{id}', [recipeController::class, 'descriptionRecipies'])->name('description');

//formulaire liste de course
Route::middleware('auth')->group(function () {
  Route::get('/listeDeCourse/{id}', [recipeController::class, 'formListeDeCourse'])->name('listeDeCourse');
  Route::post('/listeDeCourse/{id}', [recipeController::class, 'formListeDeCourse'])->name('listeDeCourse');
});


//page afficher les listes de courses
Route::middleware('auth')->group(function () {
  Route::post('/afficherListeDeCourse/ajouter/{id}', [recipeController::class, 'addGroceryList'])->name('ajouter.list');
  Route::get('/afficherListeDeCourse', [recipeController::class, 'showGroceryLists'])->name('afficherListeDeCourse');

  
});



//page d'ajout
Route::middleware('auth')->group(function () {
  Route::post('/ajouterRecette', [recipeController::class, 'addRecipe'])
  ->name('ajouterRecette');
  Route::get('/ajouterRecette', [recipeController::class, 'getCategorieAndIngredient'])
  ->name('ajouterRecette');
});

//Route::get('/dashboard', function () {
  // return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
