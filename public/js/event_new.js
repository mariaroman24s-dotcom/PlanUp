function openEventModal() {
    document.getElementById("eventModal").classList.remove("hidden");
}

function closeEventModal() {
    document.getElementById("eventModal").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("eventForm");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        let data = new FormData(form);

        const res = await fetch("/src/config/event_create.php", {
            method: "POST",
            body: data
        });

        const msg = await res.text();

        if (msg === "success") {
            alert("Evento creado correctamente");
            location.reload();
        } else {
            alert("Error: " + msg);
        }
    });
});
