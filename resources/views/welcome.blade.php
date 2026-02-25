<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>ColocApp - Accueil</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Navigation -->
    @include('includes.header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Gérez vos dépenses de colocation facilement</h1>
            <p>Invitez vos colocataires, suivez vos dépenses et simplifiez vos remboursements.</p>
            <a href="register" class="btn">Commencer maintenant</a>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <h2>Fonctionnalités clés</h2>
        <div class="feature-grid">
            <div class="feature">
                <h3>👥 Gestion des colocations</h3>
                <p>Créez ou rejoignez une colocation en quelques clics.</p>
            </div>
            <div class="feature">
                <h3>💰 Suivi des dépenses</h3>
                <p>Ajoutez vos dépenses et voyez qui doit à qui.</p>
            </div>
            <div class="feature">
                <h3>📊 Statistiques</h3>
                <p>Analysez vos dépenses par catégorie et par mois.</p>
            </div>
            <div class="feature">
                <h3>⭐ Réputation</h3>
                <p>Un système de réputation pour encourager la fiabilité.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('includes.footer')

    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>