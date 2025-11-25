document.addEventListener("DOMContentLoaded", () => {

    const dayCells = document.querySelectorAll(".day");
    const circleDays = document.querySelectorAll(".circle-day");

    function navigateTo(date) {
        const url = new URL(window.location.href);
        url.searchParams.set("dia", date);
        window.location.href = url.toString();
    }

    dayCells.forEach(day => {
        if (!day.classList.contains("empty")) {
            day.addEventListener("click", () => {
                navigateTo(day.dataset.date);
            });
        }
    });

    circleDays.forEach(cd => {
        cd.addEventListener("click", () => {
            navigateTo(cd.dataset.date);
        });
    });

});

function changeMonth(direction) {
    const url = new URL(window.location.href);

    // Obtener la fecha actual del calendario
    let selected = url.searchParams.get("dia");

    // Si no existe o es inválida, usar HOY
    if (!selected || isNaN(Date.parse(selected))) {
        selected = new Date().toISOString().split("T")[0];
    }

    const date = new Date(selected + "T00:00:00"); // evitar problemas de zona horaria

    // Ajustar mes
    date.setMonth(date.getMonth() + direction);

    // Asegurar que el día exista dentro del mes
    const fixedDate = new Date(date.getFullYear(), date.getMonth(), Math.min(
        parseInt(selected.split("-")[2]),
        new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate()
    ));

    const finalDate = fixedDate.toISOString().split("T")[0];

    url.searchParams.set("dia", finalDate);
    window.location.href = url.toString();
}

function toggleYearDropdown(event) {
    event.stopPropagation();
    document.getElementById("yearDropdown").classList.toggle("hidden");
}

// Cerrar menú si se hace clic fuera
document.addEventListener("click", () => {
    const dropdown = document.getElementById("yearDropdown");
    if (dropdown) dropdown.classList.add("hidden");
});

// Elegir año
document.addEventListener("click", e => {
    if (e.target.classList.contains("year-option")) {
        const year = e.target.dataset.year;

        const url = new URL(window.location.href);
        let currentDate = url.searchParams.get("dia") || new Date().toISOString().split("T")[0];

        let d = new Date(currentDate + "T00:00:00");
        d.setFullYear(year);

        // Corregir día inválido (ej. 31 feb)
        const maxDay = new Date(d.getFullYear(), d.getMonth() + 1, 0).getDate();
        if (d.getDate() > maxDay) d.setDate(maxDay);

        url.searchParams.set("dia", d.toISOString().split("T")[0]);
        window.location.href = url.toString();
    }
});

function moveHorizontalDays(direction) {
    const url = new URL(window.location.href);
    let selected = url.searchParams.get("dia") || new Date().toISOString().split("T")[0];
    
    let date = new Date(selected + "T00:00:00");
    date.setDate(date.getDate() + direction);

    const newDate = date.toISOString().split("T")[0];
    url.searchParams.set("dia", newDate);
    window.location.href = url.toString();
}
