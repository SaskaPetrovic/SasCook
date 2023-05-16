<!--
ETML
Auteur      : Saska Petrovic
Date        : 16.05.2023
Description : Header du site
-->

<!--header du site-->
<header>
    <main class="AccFontColor">
        <div class="container flex flex-col flex-wrap items-center p-5 mx-auto md:flex-row">
            <a class="flex items-center mb-4 font-medium text-gray-900 title-font md:mb-0">
                <img class="logo" src="{{'/img/logo.png'}}">
                <a href="/accueil" class="ml-3 text-xl">SasCook </a>
            </a>
            <nav class="flex flex-wrap items-center justify-center text-base md:ml-auto">
                <a class="mr-5 hover:text-gray-900" href="{{ url('/accueil') }}">Accueil</a>
                <a class="mr-5 hover:text-gray-900" href="{{ url('/recette') }}">Recettes</a>
                <a class="mr-5 hover:text-gray-900" href="{{ url('/contact') }}">Contact</a>

                @if (Route::has('login'))
                <div class="mr-5 AccFontColor">
                    @auth
                    <div class="dropdown">
                        <button class="dropdown-btn hover:text-gray-900">{{ Auth::user()->name }}
                            <div class="ml-1" id="iconeDropdown">
                                <svg class="fill-current h-7 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        
                        <div class="dropdown-content dropdown-transition">
                       <!-- <a class="dropdownHover" href="{{ url('/favoris') }}">Favoris</a>-->
                        <a class="dropdownHover" href="{{ url('/ajouterRecette') }}">Ajouter une recette</a>
                        <a class="dropdownHover" href="{{ url('/modifierRecette') }}">Modifier/supprimer une recette</a>
                          <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">{{ __('Déconnexion') }}</button>
                            </form>
                        </div>
                    </div>

                    @else
                    <a href="{{ route('login') }}" class="mr-5 hover:text-gray-900">Connexion</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="mr-5 hover:text-gray-900">Créer un compte</a>
                    @endif
                    @endauth
                </div>
                @endif
            </nav>
        </div>
    </main>
    @include('dropdown')
</header>