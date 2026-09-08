@extends('layouts.super-admin')

@section('titre', 'Configurer le lien d\'accès')

@section('content')
<div class="card" style="max-width: 600px; margin: 2rem auto;">
    <div class="card-header">
        <h3 class="card-title">🔗 Configuration du lien unique pour : {{ $client->nom }}</h3>
    </div>
    
    <div class="card-body" style="padding: 1.5rem;">
        <form action="{{ route('super-admin.demandes.envoyer-acces', $demande) }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label class="form-label">Aperçu du lien d'accès (Page d'accueil) :</label>
                <div style="font-family: monospace; background: #f8fafc; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; color: #64748b; word-break: break-all;">
                    {{ url('/') }}?client=<span id="aperçu-slug" style="color: #2563eb; font-weight: bold;">{{ $client->slug }}</span>
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="slug" class="form-label">Personnaliser le segment (Identifiant / Slug) :</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $client->slug) }}" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                <small style="color: var(--text-muted); display: block; margin-top: 4px;">Exemple : <code>gaz-marahoue-2</code> ou <code>client-2</code> selon votre choix.</small>
                @error('slug')
                    <span style="color: var(--danger); font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('super-admin.demandes.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Confirmer l\'envoi des accès par e-mail au client ?')">
                    🚀 Enregistrer et envoyer les accès par e-mail
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Petit script pour mettre à jour l'aperçu en direct quand le super-admin tape
    const inputSlug = document.getElementById('slug');
    const apercuSlug = document.getElementById('aperçu-slug');
    
    inputSlug.addEventListener('input', function() {
        apercuSlug.textContent = this.value || '...';
    });
</script>
@endsection