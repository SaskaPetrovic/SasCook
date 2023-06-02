<!--
ETML
Auteur      : Saska Petrovic
Date        : 16.05.2023
Description : Header du site
-->

<!--header du site-->
<header>
        <main class="container flex flex-col flex-wrap items-center p-2 mx-auto md:flex-row">
            <a class="flex items-center mb-4 font-medium text-gray-900 title-font md:mb-0">
                <a href="/"><img class="logo" src="{{'/img/logoSite.png'}}"></a>
                <a href="/" class="ml-3 text-3xl">SasCook </a>
            </a>
            <nav class="flex flex-wrap items-center justify-center text-xl  md:ml-auto" >
                <a class="mr-5 hover:text-gray-900" id="textHover" href="{{ url('/') }}">Accueil</a>
                <a class="mr-5 hover:text-gray-900" id="textHover" href="{{ url('/recette') }}">Recettes</a>


                @if (Route::has('login'))
                <div class="mr-5">
                    @auth
                    <div class="dropdown">
                        <button class="dropdown-btn hover:text-gray-900" id="textHover">{{ Auth::user()->name }}
                            <div class="ml-1" id="iconeDropdown">
                                <svg class="fill-current h-7 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                    111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <div class="dropdown-content dropdown-transition">
                            <a class="dropdownHover" href="{{ url('/ajouterRecette') }}">Ajouter une recette</a>
                            <a class="dropdownHover" href="{{ url('/afficherListeDeCourse') }}">Liste de course</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-btn">{{ __('Déconnexion') }}</button>
                            </form>
                        </div>
                    </div>

                    @else
                    <a href="{{ route('login') }}" id="textHover" class="mr-5 hover:text-gray-900">Connexion</a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" id="textHover" class="mr-5 hover:text-gray-900">Créer un compte</a>
                    @endif
                    @endauth
                </div>
                @endif
            </nav>
        </main>
    @include('dropdown')
</header>