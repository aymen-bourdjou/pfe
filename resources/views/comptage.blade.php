<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Ajout de Bootstrap pour le style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
<div class="container">
    <h1>Créer un nouveau comptage</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('api/comptage/ajouter_comptage') }}" method="POST">
        @csrf  <!-- Token CSRF pour la protection -->

        <div class="form-group">
            <label for="id_inventaire">Inventaire</label>
            <input type="text" name="id_inventaire" id="id_inventaire" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="id_departement">Département</label>
            <input type="text" name="id_departement" id="id_departement" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nom_comptage">Nom du comptage</label>
            <input type="text" name="nom_comptage" id="nom_comptage" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>

<!-- Ajout de Bootstrap JS et jQuery pour le bon fonctionnement -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
