<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Abonnement bientôt expiré</title>
</head>
<body style="margin:0;padding:0;background:#FAF8FC;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:#241F3D;">
    <div style="max-width:480px;margin:0 auto;padding:32px 24px;">
        <div style="background:#fff;border:1px solid #EBE6F5;border-radius:14px;padding:28px;">
            <h1 style="font-size:18px;margin:0 0 16px;">Bonjour {{ $client->nom }},</h1>
            <p style="font-size:14px;line-height:1.6;">
                Votre abonnement à Gestion Dépôt Gaz arrive à échéance le
                <strong>{{ $client->date_fin_abonnement->format('d/m/Y') }}</strong>.
            </p>
            <p style="font-size:14px;line-height:1.6;">
                Pour continuer à utiliser votre espace sans interruption, merci de procéder au renouvellement
                ({{ $client->periode_abonnement }}, {{ number_format($client->montant_abonnement, 0, ',', ' ') }} FCFA)
                avant cette date.
            </p>
            <p style="font-size:13px;color:#7A7390;margin-top:24px;">
                Pour toute question, contactez-nous directement.
            </p>
        </div>
    </div>
</body>
</html>
