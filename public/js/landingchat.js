document.addEventListener("DOMContentLoaded", () => {
  const box = document.getElementById("jennyMessages");
  if (!box) return;

  const segments = [
    [
      { from: "user", text: "Hola Jenny, me siento saturada con todo lo que tengo que hacer." },
      { from: "jenny", text: "Respiremos. ¿Qué es lo que sí debe pasar hoy sin falta?" },
      { from: "user", text: "Terminar una presentación para mañana." },
      { from: "jenny", text: "Perfecto, lo pondremos como prioridad número uno y te reservo un bloque de enfoque." }
    ],
    [
      { from: "user", text: "Siempre termino posponiendo las tareas importantes." },
      { from: "jenny", text: "Nos pasa a muchos. Probemos con bloques cortos de enfoque y descansos breves." },
      { from: "user", text: "¿Y si me pierdo o me distraigo?" },
      { from: "jenny", text: "Yo te aviso cuándo retomar, para que no tengas que preocuparte por eso." }
    ],
    [
      { from: "user", text: "Me preocupa olvidar reuniones y eventos importantes." },
      { from: "jenny", text: "Podemos registrar todo y activar recordatorios con tiempo para que llegues tranquila." },
      { from: "user", text: "Quiero evitar hacer todo a último minuto." },
      { from: "jenny", text: "Te avisaré antes para que puedas prepararte con calma." }
    ],
    [
      { from: "user", text: "Quiero organizarme mejor, pero sin llenar mi día de cosas." },
      { from: "jenny", text: "Me encanta eso. El descanso también es una prioridad real, no un premio extra." },
      { from: "user", text: "¿Puedo reservar tiempo solo para mí?" },
      { from: "jenny", text: "Claro, lo bloquearemos igual que cualquier compromiso importante." }
    ]
  ];

  const typingTime = 900;
  const waitMsg = 1100;
  const pauseSegment = 1300;

  let current = 0;

  function typingBubble() {
    const wrap = document.createElement("div");
    wrap.className = "typing-bubble";
    wrap.innerHTML = `
      <span>Jenny está escribiendo</span>
      <span class="typing-dots">
        <span></span><span></span><span></span>
      </span>
    `;
    return wrap;
  }

  function msgBubble(msg) {
    const div = document.createElement("div");
    div.className =
      msg.from === "jenny" ? "bubble-jenny apple-bubble" : "bubble-user apple-bubble";

    div.textContent = msg.text;
    return div;
  }

  function playSegment(i) {
    const segment = segments[i];
    box.innerHTML = "";
    box.classList.remove("fade-out-jenny");

    let delay = 300;

    segment.forEach(m => {
      if (m.from === "jenny") {
        setTimeout(() => {
          box.appendChild(typingBubble());
          box.scrollTop = box.scrollHeight;
        }, delay);

        delay += typingTime;

        setTimeout(() => {
          const t = box.querySelector(".typing-bubble");
          if (t) t.remove();
          box.appendChild(msgBubble(m));
          box.scrollTop = box.scrollHeight;
          sound.play();
        }, delay);

        delay += waitMsg;

      } else {
        setTimeout(() => {
          box.appendChild(msgBubble(m));
          box.scrollTop = box.scrollHeight;
        }, delay);

        delay += waitMsg;
      }
    });

    setTimeout(() => box.classList.add("fade-out-jenny"), delay);

    setTimeout(() => {
      current = (i + 1) % segments.length;
      playSegment(current);
    }, delay + pauseSegment);
  }

  playSegment(current);
});
