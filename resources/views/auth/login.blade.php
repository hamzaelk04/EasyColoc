<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>ColocApp - Connexion</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Navigation -->
    @include('includes.header')

    <!-- Login Form -->
    <section class="form-section">
        <div class="form-container">
            <h1>Connexion</h1>
            <p>Accédez à votre espace colocation et gérez vos dépenses.</p>
            <form id="loginForm">
                <input type="email" placeholder="Email" required>
                <input type="password" placeholder="Mot de passe" required>
                <button type="submit" class="btn">Se connecter</button>
            </form>
            <p>Pas encore inscrit ? <a href="register">Créer un compte</a></p>
        </div>
    </section>

    <!-- Footer -->
    @include('includes.footer')

    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>