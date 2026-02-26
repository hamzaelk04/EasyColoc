<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer une colocation - ColocApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="d-flex flex-column justify-content-between min-vh-100">

    @include('includes.header')

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary w-25 mx-auto p-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Create a new colocation
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Create Colocation Form -->
                    <section class="form-section">
                        <div class="form-card">

                            <form id="createColocForm" method="POST">
                                @csrf

                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Nom de la colocation *</label>
                                    <input type="text" id="name" name="name" required
                                        placeholder="Ex: Coloc Centre Ville">
                                    <small class="error-message"></small>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" rows="4"
                                        placeholder="Petite description de la colocation..."></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn submit-btn">
                                        <span class="btn-text">Créer la colocation</span>
                                        <span class="loader hidden"></span>
                                    </button>
                                </div>
                                <div class="success-message hidden">
                                    🎉 Colocation créée avec succès !
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>



    </div>
    </section>

    @include('includes.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
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