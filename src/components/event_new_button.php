<link rel="stylesheet" href="/public/css/event_new.css">
<script src="/public/js/event_new.js" defer></script>

<button class="btn-new-event" onclick="openEventModal()">
    + Crear un nuevo evento
</button>

<!-- Modal -->
<div id="eventModal" class="event-modal hidden">
    <div class="event-modal-content">

        <h2 class="modal-title">Crear nuevo evento</h2>

        <form id="eventForm">
            
            <label>Título del evento</label>
            <input type="text" name="titulo" required>

            <label>Descripción</label>
            <textarea name="descripcion"></textarea>

            <label>Fecha de inicio</label>
            <input type="datetime-local" name="fecha_inicio" required>

            <label>Fecha de fin</label>
            <input type="datetime-local" name="fecha_fin" required>

            <label>Lugar</label>
            <input type="text" name="ubicacion">

            <div class="modal-buttons">
                <button type="button" class="cancel" onclick="closeEventModal()">Cancelar</button>
                <button type="submit" class="save">Guardar</button>
            </div>

        </form>

    </div>
</div>
