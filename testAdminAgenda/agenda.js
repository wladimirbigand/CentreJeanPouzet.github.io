const month_names = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

// Variables mois et année courants
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

// Stockage des jours ouverts par date ISO "YYYY-MM-DD"
let openDays = {
    "2025-05-02": true,
    "2025-05-03": true,
    "2025-05-04": true,
    "2025-05-05": true,
    "2025-05-06": true,
    "2025-05-09": true,
    "2025-05-10": true,
    "2025-05-11": true,
    "2025-05-12": true,
    "2025-05-16": true,
    "2025-05-17": true,
    "2025-05-19": true,
    "2025-05-20": true,
    "2025-05-23": true,
    "2025-05-24": true,
    "2025-05-25": true,
    "2025-05-27": true,
    "2025-05-30": true,
};

// Formatte la date en ISO YYYY-MM-DD
function formatDateISO(year, month, day) {
    const mm = month + 1 < 10 ? '0' + (month + 1) : (month + 1);
    const dd = day < 10 ? '0' + day : day;
    return `${year}-${mm}-${dd}`;
}

function openAllDays(month, year) {
    const days_in_month = new Date(year, month + 1, 0).getDate();
    for (let day = 1; day <= days_in_month; day++) {
        const dateISO = formatDateISO(year, month, day);
        openDays[dateISO] = true;
    }
    generateCalendar(month, year);
}

function closeAllDays(month, year) {
    const days_in_month = new Date(year, month + 1, 0).getDate();
    for (let day = 1; day <= days_in_month; day++) {
        const dateISO = formatDateISO(year, month, day);
        delete openDays[dateISO];
    }
    generateCalendar(month, year);
}

// Événements boutons
document.getElementById('openAllBtn').addEventListener('click', () => {
    openAllDays(currentMonth, currentYear);
});

document.getElementById('closeAllBtn').addEventListener('click', () => {
    closeAllDays(currentMonth, currentYear);
});


// Met à jour l'affichage du mois et de l'année
function updateHeader(month, year) {
    document.getElementById('month-picker').textContent = month_names[month];
    document.getElementById('year').textContent = year;
}

// Génère le calendrier pour le mois et l'année donnés
function generateCalendar(month, year) {
    const calendar_days = document.querySelector('.calendar-days');
    calendar_days.innerHTML = '';

    // Nombre de jours dans le mois
    const days_in_month = new Date(year, month + 1, 0).getDate();
    // Jour de la semaine du 1er jour du mois (0 = Dimanche)
    const first_day = new Date(year, month, 1).getDay();

    // Cases vides avant le début du mois (pour aligner au bon jour de la semaine)
    for (let i = 0; i < first_day; i++) {
        let empty_day = document.createElement('div');
        calendar_days.appendChild(empty_day);
    }

    // Génération des jours du mois
    for (let day = 1; day <= days_in_month; day++) {
        let day_cell = document.createElement('div');
        day_cell.textContent = day;

        const dateISO = formatDateISO(year, month, day);

        // Ajoute la classe "open" si ce jour est dans openDays, sinon "closed"
        if (openDays[dateISO]) {
            day_cell.classList.add('open');
        } else {
            day_cell.classList.add('closed');
        }

        // Clique pour basculer ouvert/fermé
        day_cell.addEventListener('click', () => {
            if (day_cell.classList.contains('open')) {
                day_cell.classList.remove('open');
                day_cell.classList.add('closed');
                openDays[dateISO] = false;
                delete openDays[dateISO]; // Optionnel, pour supprimer la clé
            } else {
                day_cell.classList.remove('closed');
                day_cell.classList.add('open');
                openDays[dateISO] = true;
            }
        });

        calendar_days.appendChild(day_cell);
    }
}

// Navigation mois précédent
document.getElementById('prev-month').addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear);
});

// Navigation mois suivant
document.getElementById('next-month').addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear);
});

// Initialisation au chargement de la page
updateHeader(currentMonth, currentYear);
generateCalendar(currentMonth, currentYear);
