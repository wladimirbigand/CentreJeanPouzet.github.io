const month_names = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

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



function formatDateISO(year, month, day) {
    const mm = month + 1 < 10 ? '0' + (month + 1) : (month + 1);
    const dd = day < 10 ? '0' + day : day;
    return `${year}-${mm}-${dd}`;
}

function openAllDays(month, year) {
    const days_in_month = new Date(year, month + 1, 0).getDate();
    for (let day = 1; day <= days_in_month; day++) {
        openDays[formatDateISO(year, month, day)] = true;
    }
    generateCalendar(month, year);
}

function closeAllDays(month, year) {
    const days_in_month = new Date(year, month + 1, 0).getDate();
    for (let day = 1; day <= days_in_month; day++) {
        delete openDays[formatDateISO(year, month, day)];
    }
    generateCalendar(month, year);
}

document.getElementById('openAllBtn').addEventListener('click', () => openAllDays(currentMonth, currentYear));
document.getElementById('closeAllBtn').addEventListener('click', () => closeAllDays(currentMonth, currentYear));

function updateHeader(month, year) {
    document.getElementById('month-picker').textContent = month_names[month];
    document.getElementById('year').textContent = year;
}

function generateCalendar(month, year) {
    const calendar_days = document.querySelector('.calendar-days');
    calendar_days.innerHTML = '';

    const days_in_month = new Date(year, month + 1, 0).getDate();
    const first_day = new Date(year, month, 1).getDay();

    for (let i = 0; i < first_day; i++) {
        let empty_day = document.createElement('div');
        calendar_days.appendChild(empty_day);
    }

    for (let day = 1; day <= days_in_month; day++) {
        let day_cell = document.createElement('div');
        day_cell.textContent = day;

        const dateISO = formatDateISO(year, month, day);

        if (openDays[dateISO]) {
            day_cell.classList.add('open');
        } else {
            day_cell.classList.add('closed');
        }

        day_cell.addEventListener('click', () => {
            if (openDays[dateISO]) {
                delete openDays[dateISO];
                day_cell.classList.remove('open');
                day_cell.classList.add('closed');
            } else {
                openDays[dateISO] = true;
                day_cell.classList.remove('closed');
                day_cell.classList.add('open');
            }
        });

        calendar_days.appendChild(day_cell);
    }
}

document.getElementById('prev-month').addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear);
});

function fetchOpenDaysFromServer() {
    fetch('recuperer_jours.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.openDates)) {
                openDays = {};
                data.openDates.forEach(date => {
                    openDays[date] = true;
                });

                // Ne génère le calendrier que maintenant :
                updateHeader(currentMonth, currentYear);
                generateCalendar(currentMonth, currentYear);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Erreur lors du chargement des jours ouverts.',
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur réseau',
                text: error.message,
                confirmButtonColor: '#d33'
            });
        });
}



document.getElementById('next-month').addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear);
});

fetchOpenDaysFromServer();

// ✅ Chemin mis à jour ici : (pas IA)
document.getElementById('saveBtn').addEventListener('click', () => {
    const openDates = Object.keys(openDays);

    fetch('sauvegarder_jours.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ openDates }),
    })
        .then(response => {
            if (!response.ok) throw new Error("Réponse non OK");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès !',
                    text: 'Modifications enregistrées avec succès.',
                    confirmButtonColor: '#3085d6'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Erreur lors de l\'enregistrement : ' + (data.message || 'Erreur inconnue'),
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur réseau',
                text: error.message,
                confirmButtonColor: '#d33'
            });
        });
});