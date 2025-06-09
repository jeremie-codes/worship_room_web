<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badge Visiteur - {{ $visiteur->nom_complet }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        
        .badge {
            width: 85mm;
            height: 54mm;
            border: 2px solid #2563eb;
            border-radius: 8px;
            padding: 8px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }
        
        .badge::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 30%, rgba(37, 99, 235, 0.1) 50%, transparent 70%);
            transform: rotate(45deg);
        }
        
        .badge-header {
            text-align: center;
            border-bottom: 1px solid #2563eb;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        
        .badge-title {
            font-size: 12px;
            font-weight: bold;
            color: #2563eb;
            margin: 0;
        }
        
        .badge-number {
            font-size: 10px;
            color: #64748b;
            margin: 0;
        }
        
        .visitor-info {
            position: relative;
            z-index: 1;
        }
        
        .visitor-name {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            margin: 0 0 4px 0;
            text-align: center;
        }
        
        .visitor-type {
            font-size: 10px;
            background: #2563eb;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 4px;
        }
        
        .visitor-details {
            font-size: 9px;
            color: #475569;
            line-height: 1.3;
        }
        
        .badge-footer {
            position: absolute;
            bottom: 4px;
            left: 8px;
            right: 8px;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 2px;
        }
        
        .print-button {
            text-align: center;
            margin: 20px;
        }
        
        .btn {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="print-button no-print">
        <button class="btn" onclick="window.print()">Imprimer le Badge</button>
        <button class="btn" onclick="window.close()" style="background: #6b7280; margin-left: 10px;">Fermer</button>
    </div>

    <div class="badge">
        <div class="badge-header">
            <h1 class="badge-title">BADGE VISITEUR</h1>
            <p class="badge-number">{{ $visiteur->badge_numero }}</p>
        </div>
        
        <div class="visitor-info">
            <h2 class="visitor-name">{{ strtoupper($visiteur->nom_complet) }}</h2>
            
            <div style="text-align: center; margin-bottom: 6px;">
                <span class="visitor-type">{{ strtoupper($visiteur->type) }}</span>
            </div>
            
            <div class="visitor-details">
                @if($visiteur->entreprise)
                    <div><strong>Entreprise:</strong> {{ $visiteur->entreprise }}</div>
                @endif
                
                @if($visiteur->service)
                    <div><strong>Direction:</strong> {{ $visiteur->service->nom }}</div>
                @endif
                
                @if($visiteur->destination)
                    <div><strong>Destination:</strong> {{ $visiteur->destination }}</div>
                @endif
                
                <div><strong>Arrivée:</strong> {{ $visiteur->heure_arrivee->format('d/m/Y H:i') }}</div>
                
                @if($visiteur->vehicule && $visiteur->immatriculation_vehicule)
                    <div><strong>Véhicule:</strong> {{ $visiteur->immatriculation_vehicule }}</div>
                @endif
                
                @if($visiteur->nombre_accompagnants > 0)
                    <div><strong>Accompagnants:</strong> {{ $visiteur->nombre_accompagnants }}</div>
                @endif
            </div>
        </div>
        
        <div class="badge-footer">
            Ce badge doit être porté de manière visible • À remettre en sortie
        </div>
    </div>

    <script>
        // Auto-print si demandé
        if (window.location.search.includes('auto-print=1')) {
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            };
        }
    </script>
</body>
</html>