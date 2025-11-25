document.addEventListener("DOMContentLoaded", () => {

    const chat = document.getElementById("jenny-chat");
    const btn = document.getElementById("jenny-btn");
    const input = document.getElementById("jenny-input");
    const send = document.getElementById("jenny-send");
    const messages = document.getElementById("jenny-messages");

    // Abrir / cerrar
    btn.addEventListener("click", () => {
        chat.style.display = chat.style.display === "flex" ? "none" : "flex";
    });

    // Enviar mensaje
    function sendMessage() {
        const text = input.value.trim();
        if (text === "") return;

        // Burbuja usuario
        const userBubble = document.createElement("div");
        userBubble.classList.add("bubble", "user");
        userBubble.textContent = text;
        messages.appendChild(userBubble);

        input.value = "";

        messages.scrollTop = messages.scrollHeight;

        // Respuesta automática
        setTimeout(() => {
            const botBubble = document.createElement("div");
            botBubble.classList.add("bubble", "bot");
            botBubble.textContent = "Estoy pensando… 💭";

            messages.appendChild(botBubble);
            messages.scrollTop = messages.scrollHeight;
        }, 600);
    }

    send.addEventListener("click", sendMessage);
    input.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
    });

});
