<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agenda - Centre Jean Pouzet</title>

    <link rel="stylesheet" href="agenda.css" />
</head>

<body>

<main>
    <section>
        <div class="container">
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-case legend-open"></div>
                    <span>Ouvert</span>
                </div>
                <div class="legend-item">
                    <div class="legend-case legend-closed"></div>
                    <span>Fermé</span>
                </div>
            </div>
            <div class="toggle-buttons" style="display:flex; gap: 10px; margin-bottom: 20px;">
                <button id="openAllBtn" style="flex:1; padding: 10px; border-radius: 8px; border:none; background-color:#9DBD91; color:white; font-weight:bold; cursor:pointer;">Tout ouvrir</button>
                <button id="closeAllBtn" style="flex:1; padding: 10px; border-radius: 8px; border:none; background-color:#FF6F61; color:white; font-weight:bold; cursor:pointer;">Tout fermer</button>
            </div>
            <div class="calendar">
                <div class="calendar-header">
                    <button id="prev-month" class="month-nav">←</button>
                    <div class="month-display">
                        <span id="month-picker">Mois</span>
                        <span id="year">Année</span>
                    </div>
                    <button id="next-month" class="month-nav">→</button>
                </div>
                <div class="calendar-body">
                    <div class="calendar-week-days">
                        <div>Dim</div>
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mer</div>
                        <div>Jeu</div>
                        <div>Ven</div>
                        <div>Sam</div>
                    </div>
                    <div class="calendar-days"></div>
                </div>
            </div>

            <button id="saveBtn">Enregistrer les modifications</button>
        </div>
    </section>
</main>

<script src="agenda.js"></script>
</body>

</html>
