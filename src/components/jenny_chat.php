<link rel="stylesheet" href="/public/css/jenny_chat.css">
<script src="/public/js/jenny_chat.js" defer></script>

<!-- Botón flotante -->
<button id="jenny-btn" class="jenny-floating-btn">
    <img src="/public/img/chat/jenny_icon.png" alt="">
</button>

<!-- Ventana flotante -->
<div id="jenny-chat" class="jenny-chat-window">

    <!-- Header -->
    <div class="jenny-header">
        <div class="jenny-header-text">
            <h3>Asistente virtual</h3>
            <h2>Jenny</h2>
        </div>
        <img src="/public/img/chat/jenny_head.png" class="jenny-header-img">
    </div>

    <!-- Mensajes -->
    <div id="jenny-messages" class="jenny-messages">
        <div class="bubble bot">
            Hola, soy Jenny, tu asistente virtual. ¿Qué puedo hacer por ti?
        </div>
    </div>

    <!-- Caja de texto -->
    <div class="jenny-input-box">
        <input type="text" id="jenny-input" placeholder="Escribe un mensaje...">
        <button id="jenny-send">
            ➤
        </button>
    </div>

</div>
