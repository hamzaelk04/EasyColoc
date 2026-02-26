<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer une colocation - ColocApp</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>

<body>

    @include('includes.header')

    <!-- Page Header -->
    <section class="page-hero">
        <div class="page-hero-content">
            <h1>Créer une nouvelle colocation</h1>
            <p>Lancez votre espace et commencez à gérer vos dépenses partagées.</p>
        </div>
    </section>

    <!-- Create Colocation Form -->
    <section class="form-section">
        <div class="form-card">

            <form id="createColocForm" method="POST" >
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nom de la colocation *</label>
                    <input type="text" id="name" name="name" required placeholder="Ex: Coloc Centre Ville">
                    <small class="error-message"></small>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"
                        placeholder="Petite description de la colocation..."></textarea>
                </div>

                <!-- Currency -->
                <div class="form-group">
                    <label for="currency">Devise *</label>
                    <select id="currency" name="currency" required>
                        <option value="">Choisir une devise</option>
                        <option value="EUR">€ Euro</option>
                        <option value="USD">$ Dollar</option>
                        <option value="GBP">£ Livre</option>
                    </select>
                    <small class="error-message"></small>
                </div>

                <!-- Budget -->
                <div class="form-group">
                    <label for="budget">Budget mensuel estimé</label>
                    <input type="number" id="budget" name="budget" min="0" step="0.01"
                        placeholder="Ex: 1200">
                </div>

                <button type="submit" class="btn submit-btn">
                    <span class="btn-text">Créer la colocation</span>
                    <span class="loader hidden"></span>
                </button>

                <div class="success-message hidden">
                    🎉 Colocation créée avec succès !
                </div>

            </form>

        </div>
    </section>

    @include('includes.footer')

    <script>
        const form = document.getElementById('createColocForm');
        const submitBtn = document.querySelector('.submit-btn');
        const loader = document.querySelector('.loader');
        const btnText = document.querySelector('.btn-text');
        const successMessage = document.querySelector('.success-message');

        form.addEventListener('submit', function (e) {

            let valid = true;

            const name = document.getElementById('name');
            const currency = document.getElementById('currency');

            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            if (name.value.trim() === '') {
                name.nextElementSibling.textContent = "Le nom est obligatoire.";
                valid = false;
            }

            if (currency.value === '') {
                currency.nextElementSibling.textContent = "Veuillez choisir une devise.";
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                return;
            }

            // UX Enhancement
            submitBtn.disabled = true;
            loader.classList.remove('hidden');
            btnText.textContent = "Création...";
        });
    </script>

</body>

</html>