<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vos accès</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Bonjour,</h2>
    <p>Votre demande d'accès a été validée avec succès. Votre espace de gestion est désormais actif.</p>
    
    <p>Voici vos identifiants de connexion :</p>
    <ul>
        <li><strong>Lien d'accès unique :</strong> <a href="{{ $urlAcces }}" target="_blank">{{ $urlAcces }}</a></li>
        <li><strong>Identifiant (Email) :</strong> {{ $emailClient }}</li>
        <li><strong>Mot de passe temporaire :</strong> {{ $motDePasseClair }}</li>
    </ul>

    <p style="color: #e53e3e; font-size: 0.9rem;">⚠️ Nous vous conseillons de modifier votre mot de passe dès votre première connexion.</p>

    <p>Cordialement,<br>L'équipe d'administration</p>
</body>
</html>