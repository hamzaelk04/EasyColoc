<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>ColocApp - Inscription</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <!-- Navigation -->
  <header>
    <nav class="navbar">
      <div class="logo">ColocApp</div>
      <ul class="nav-links" id="navLinks">
        <li><a href="index.html">Accueil</a></li>
        <li><a href="login.html">Connexion</a></li>
        <li><a href="register.html" class="active">Inscription</a></li>
      </ul>
      <div class="menu-toggle" id="menuToggle">&#9776;</div>
    </nav>
  </header>

  <!-- Register Form -->
  <section class="form-section">
    <div class="form-container">
      <h1>Créer un compte</h1>
      <p>Rejoignez ColocApp et simplifiez la gestion de vos dépenses de colocation.</p>
      <form id="registerForm">
        <input type="text" placeholder="firstname" required>
        <input type="text" placeholder="lastname" required>
        <input type="email" placeholder="Email" required>
        <input type="password" placeholder="Mot de passe" required>
        <button type="submit" class="btn">S'inscrire</button>
      </form>
      <p>Déjà inscrit ? <a href="login">Se connecter</a></p>
    </div>
  </section>

  <!-- Footer -->
  @include('includes.footer')

  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
