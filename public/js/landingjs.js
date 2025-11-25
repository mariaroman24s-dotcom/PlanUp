// Carrusel 
const track = document.getElementById("appleLogosTrack");

let position = 0;
let speed = 0.6; // velocidad 

function moveCarousel() {
    position -= speed;

    /* por si se mueve un logo, se reinicia */
    if (Math.abs(position) >= track.firstElementChild.offsetWidth + 64) {
        track.appendChild(track.firstElementChild);
        position = 0;
    }

    track.style.transform = `translateX(${position}px)`;

    requestAnimationFrame(moveCarousel);
}

window.addEventListener("load", () => {
    // Clonar imagenes
    for (let i = 0; i < 3; i++) {
        track.appendChild(track.children[i].cloneNode(true));
    }
    moveCarousel();
});
