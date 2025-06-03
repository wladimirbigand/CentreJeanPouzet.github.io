const month_names = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

// Variables globales
let allOpenDays = [];  // Toutes les dates ouvertes, format "YYYY-MM-DD"

let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

function updateHeader(month, year) {
    document.getElementById('month-picker').textContent = month_names[month];
    document.getElementById('year').textContent = year;
}

async function fetchOpenDays() {
    try {
        const response = await fetch('/Front/User/recuperer_jours.php'); // <-- vérifier chemin exact
        const data = await response.json();
        if (data.success) {
            return data.openDates;
        } else {
            console.error('Erreur récupération jours :', data.message);
            return [];
        }
    } catch (error) {
        console.error('Erreur fetch:', error);
        return [];
    }
}

function generateCalendar(month, year, openDates) {
    const calendar_days = document.querySelector('.calendar-days');
    calendar_days.innerHTML = '';

    const days_in_month = new Date(year, month + 1, 0).getDate();
    const first_day = new Date(year, month, 1).getDay();

    // cases vides avant le début du mois
    for (let i = 0; i < first_day; i++) {
        calendar_days.appendChild(document.createElement('div'));
    }

    for (let day = 1; day <= days_in_month; day++) {
        let day_cell = document.createElement('div');
        day_cell.textContent = day;

        const dateStr = `${year}-${String(month + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;

        if (openDates.includes(dateStr)) {
            day_cell.classList.add('open');
        } else {
            day_cell.classList.add('closed');
        }

        const today = new Date();
        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            day_cell.classList.add(openDates.includes(dateStr) ? 'open-current-date' : 'closed-current-date');
        }

        calendar_days.appendChild(day_cell);
    }
}

async function initCalendar() {
    allOpenDays = await fetchOpenDays();
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear, allOpenDays);
}

// Navigation mois précédent / suivant
document.getElementById('prev-month').addEventListener('click', async () => {
    currentMonth--;
    if(currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear, allOpenDays);
});

document.getElementById('next-month').addEventListener('click', async () => {
    currentMonth++;
    if(currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear, allOpenDays);
});

// Au chargement de la page
document.addEventListener('DOMContentLoaded', initCalendar);
