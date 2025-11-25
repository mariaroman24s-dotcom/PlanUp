async function deleteEvent(id) {
    if (!confirm("¿Eliminar evento?")) return;

    const res = await fetch("/src/config/event_delete.php?id=" + id);
    const msg = await res.text();

    if (msg === "deleted") {
        alert("Evento eliminado");
        location.reload();
    } else {
        alert("Error: " + msg);
    }
}
