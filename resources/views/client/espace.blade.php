<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Espace Client - {{ $client->nom }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1 class="h3 mb-3">Bienvenue sur votre espace, {{ $client->nom }}</h1>
                        <p class="text-muted">Votre abonnement est actuellement : <span class="badge bg-success">{{ $client->statut }}</span></p>
                        
                        <hr class="my-4">

                        <p>Ceci est votre tableau de bord dédié.</p>
                        
                        <!-- Bouton de connexion vers ton application de gestion existante -->
                        <a href="{{ route('login') }}" class="btn btn-primary">Se connecter à l'application</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>