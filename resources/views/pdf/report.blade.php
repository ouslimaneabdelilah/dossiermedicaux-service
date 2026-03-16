<!DOCTYPE html>
<html>
<head>
    <title>Rapport Patient - {{ $dossier->matricule }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #2c3e50; padding-bottom: 10px; margin-bottom: 30px; }
        .header h1 { color: #2c3e50; margin: 0; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; color: #2c3e50; border-left: 4px solid #3498db; padding-left: 10px; margin-bottom: 10px; }
        .info-grid { display: table; width: 100%; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; font-weight: bold; width: 30%; padding: 5px 0; }
        .info-value { display: table-cell; padding: 5px 0; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; border-top: 1px solid #ddd; padding-top: 5px; }
        .badge { background: #3498db; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-right: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RareCare - Dossier Médical</h1>
        <p>Matricule: {{ $dossier->matricule }}</p>
    </div>

    <div class="section">
        <div class="section-title">Informations Patient</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">ID Patient:</div>
                <div class="info-value">{{ $dossier->patient_id }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Détails Cliniques</div>
        <p><strong>Description:</strong></p>
        <p>{{ $dossier->description }}</p>
    </div>

    <div class="section">
        <div class="section-title">Maladies Associées</div>
        @if($dossier->maladies->count() > 0)
            @foreach($dossier->maladies as $maladie)
                <span class="badge">Maladie ID: {{ $maladie->maladie_id }}</span>
            @endforeach
        @else
            <p>Aucune maladie enregistrée.</p>
        @endif
    </div>

    <div class="footer">
        Ceci est un document généré automatiquement par RareCare. Date: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
