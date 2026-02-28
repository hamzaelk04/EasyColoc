<header>
    <nav class="navbar">
        <div class="logo">ColocApp</div>
        <ul class="nav-links" id="navLinks">
            <li><a href="/">Accueil</a></li>
            @guest
                <li><a href="login">Connexion</a></li>
                <li><a href="register">Inscription</a></li>
            @endguest
            <li><a href="dashboard">Tableau de bord</a></li>
            @auth
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        logout</a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </ul>
        <div class="menu-toggle" id="menuToggle">&#9776;</div>
    </nav>
</header>