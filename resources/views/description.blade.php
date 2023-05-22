<p class="leading-relaxed font-medium mb-2">Ingrédients:</p>
                        @foreach(explode(",", $recette->ingredients) as $ingredient)
                        <h2 class="text-s font-medium tracking-widest text-gray-400 title-font" >{{ $ingredient }}</h2>
                        @endforeach