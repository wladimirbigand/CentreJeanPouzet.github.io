const month_names = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];
 
// jours ouverts / fermés
let openDays = [2,3,4,5,6,9,10,11,12,16,17,19,20,23,24,25,27,30];    
let closedDays = [1,7,8,14,15,13,18,21,22,26,28,29,31];                    
 
// Mois et année actuels
let currentMonth = new Date().getMonth();  
let currentYear = new Date().getFullYear();
 
// met à jour le header avec le mois et l'année selectionnés
function updateHeader(month, year) {
    document.getElementById('month-picker').textContent = month_names[month];
    document.getElementById('year').textContent = year;
}
 
// genere l'agenda avec le mois et l'année selectionnés
function generateCalendar(month, year) {
    const calendar_days = document.querySelector('.calendar-days');
    calendar_days.innerHTML = '';   // reset le contenu de l'agenda
 
    const days_in_month = new Date(year, month + 1, 0).getDate(); // combien de jours dans tel mois
    const first_day = new Date(year, month, 1).getDay();          // jours de la semaine du 1er jour du mois (0 = Dimanche , 6 = Samedi)
 
    // cases vides avant le début du mois
    for (let i = 0; i < first_day; i++) {
        let empty_day = document.createElement('div');
        calendar_days.appendChild(empty_day);
    }
 
    // générer chaque jour du mois
    for (let day = 1; day <= days_in_month; day++) {
        let day_cell = document.createElement('div');
        day_cell.textContent = day;
 
        // verifie si c'est le jour actuel
        const isToday =
            day === new Date().getDate() &&
            month === new Date().getMonth() &&
            year === new Date().getFullYear();
 
        if (isToday) {
            if (openDays.includes(day)) {
                day_cell.classList.add('open-current-date');
            } else if (closedDays.includes(day)) {
                day_cell.classList.add('closed-current-date');
            }
        }
 
        // classes en fonction des jours ouverts / fermés
        if (openDays.includes(day)) {
            day_cell.classList.add('open');
        } else if (closedDays.includes(day)) {
            day_cell.classList.add('closed');
        }
 
        calendar_days.appendChild(day_cell);    // ajoute la cell du jour à l'agenda
    }
}
 
// ajoute un jour ouvert à la liste et reload l'agenda
function addOpenDay(day) {
    config.openDays.push(day);
    generateCalendar(currentMonth, currentYear);
}
 
// Bouton "Mois précédent"
document.getElementById('prev-month').addEventListener('click', () => {
    currentMonth -= 1;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear -= 1;
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear);
});
 
// Bouton "Mois Suivant"
document.getElementById('next-month').addEventListener('click', () => {
    currentMonth += 1;
    if (currentMonth > 11) {    // Si mois dépasse décembre
        currentMonth = 0;       // Mois actuel = Janvier
        currentYear += 1;       // Année actuelle ++
    }
    updateHeader(currentMonth, currentYear);
    generateCalendar(currentMonth, currentYear);
});
 
// Lance l'agenda avec le mois et l'année actuels
updateHeader(currentMonth, currentYear);
generateCalendar(currentMonth, currentYear);