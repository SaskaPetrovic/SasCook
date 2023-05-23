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
//page d'accueil, dernière recette ajoutée
//page de recette, recette aléatoire en moins de 30 min + 
Route::get('/', [recipeController::class, 'lastRecipe'])->name('accueil');


//barre de recherche
//filtre des catégories et des ingrédients
Route::get('/recette', [recipeController::class, 'allRecipies'])->name('recette');

//affiche toutes les détails des recettes

Route::get('/description/{id}', [recipeController::class, 'descriptionRecipies'])->name('description');

//permet le calcule du nombre de personnes
Route::post('/description/update-servings/{id}', [recipeController::class, 'updateServings'])->name('updateServings');



//Route::get('/dashboard', function () {
  // return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
