/*************************************************
 * PRELOAD (opcional pero mejora velocidad)
 *************************************************/
const preloadImages = [
  "../../public/img/jenny_saludando.webp",
  "../../public/img/jenny_ojos_tapados.png",
  "../../public/img/jenny_un_ojo.png",
  "../../public/img/jenny_destapa_un_ojo.webp",
  "../../public/img/jenny_tapa_un_ojo.webp",
  "../../public/img/jenny_destapa_ojos_1.webp",
  "../../public/img/jenny_destapa_ojos_2.webp",
  "../../public/img/jenny_se_tapa_los_ojos.webp"
];
preloadImages.forEach(src => { const img = new Image(); img.src = src; });

/*************************************************
 * VARIABLES
 *************************************************/
const container     = document.querySelector('.container');
const registerBtn   = document.querySelector('.register-btn');
const loginBtn      = document.querySelector('.login-btn');

// OJO: solo hay un icono con id="bx-hide", es el del login
const toggleEyes = document.querySelectorAll('.toggle-eye');

// Todos los inputs de contraseña (login + registro)
const passwordInputs = document.querySelectorAll('input[type="password"]');

// JENNYS
const jennyLogin    = document.getElementById('jennyLogin');
const jennyRegister = document.getElementById('jennyRegister');

// Estado
let activeJenny    = 'login';   // 'login' | 'register'
let jennyState     = 'normal';  // normal | ojos_cubiertos | un_ojo | animando
let jennyTimeout   = null;
let passwordVisible = false;

/*************************************************
 * ESTADO INICIAL DE LAS JENNYS
 *************************************************/
jennyLogin.style.opacity    = '1';  // se ve
jennyRegister.style.opacity = '0';  // oculta

/*************************************************
 * FUNCIONES AUXILIARES
 *************************************************/
function getCurrentJenny() {
  return activeJenny === 'login' ? jennyLogin : jennyRegister;
}

function playJenny(gifSrc, finalSrc, newState, duration = 900) {
  const bot = getCurrentJenny();
  if (!bot) return;

  clearTimeout(jennyTimeout);

  bot.src = gifSrc;
  jennyState = 'animando';

  jennyTimeout = setTimeout(() => {
    bot.src = finalSrc;
    jennyState = newState;
  }, duration);
}

/*************************************************
 * MOSTRAR / OCULTAR CONTRASEÑA (solo icono del login)
 *************************************************/
/*************************************************
 * CLICK EN CUALQUIER OJO (login + registro)
 *************************************************/
toggleEyes.forEach(eye => {

    eye.addEventListener("click", () => {

        const input = eye.parentElement.querySelector("input");

        const isPassword = input.type === "password";

        input.type = isPassword ? "text" : "password";
        passwordVisible = isPassword;

        eye.classList.toggle("bx-hide", !passwordVisible);
        eye.classList.toggle("bx-show", passwordVisible);

        if (passwordVisible) {
            playJenny("../../public/img/jenny_destapa_un_ojo.webp", "../../public/img/jenny_un_ojo.png", "un_ojo", 700);
        } else {
            playJenny("../../public/img/jenny_tapa_un_ojo.webp", "../../public/img/jenny_ojos_tapados.png", "ojos_cubiertos", 700);
        }

    });

});

/*************************************************
 * FOCUS / BLUR EN TODOS LOS INPUTS PASSWORD
 * (login y registro)
 *************************************************/
passwordInputs.forEach(input => {
  input.addEventListener('focus', () => {
    if (!passwordVisible && jennyState !== 'ojos_cubiertos') {
      playJenny(
        "../../public/img/jenny_se_tapa_los_ojos.webp",
        "../../public/img/jenny_ojos_tapados.png",
        "ojos_cubiertos",
        700
      );
    }
  });

  input.addEventListener('blur', () => {
    if (passwordVisible) {
      // Tenía un ojo destapado y deja de escribir
      playJenny(
        "../../public/img/jenny_destapa_ojos_2.webp",
        "../../public/img/jenny_saludando.webp",
        "normal",
        800
      );
    } else if (jennyState === 'un_ojo') {
      playJenny(
        "../../public/img/jenny_tapa_un_ojo.webp",
        "../../public/img/jenny_ojos_tapados.png",
        "ojos_cubiertos",
        700
      );
    } else if (jennyState === 'ojos_cubiertos') {
      playJenny(
        "../../public/img/jenny_destapa_ojos_1.webp",
        "../../public/img/jenny_saludando.webp",
        "normal",
        800
      );
    }
  });
});

/*************************************************
 * CAMBIO A REGISTRO
 *************************************************/
registerBtn.addEventListener('click', () => {
  container.classList.add('active');

  // ahora la Jenny "activa" es la del registro
  activeJenny = 'register';

  jennyLogin.style.opacity    = '0';
  jennyRegister.style.opacity = '1';

  playJenny("../../public/img/jenny_saludando.webp", "../../public/img/jenny_saludando.webp", "normal", 900);
});

/*************************************************
 * CAMBIO A LOGIN
 *************************************************/
loginBtn.addEventListener('click', () => {
  container.classList.remove('active');

  // vuelve a ser activa la Jenny de login
  activeJenny = 'login';

  jennyRegister.style.opacity = '0';
  jennyLogin.style.opacity    = '1';

  playJenny("../../public/img/jenny_saludando.webp", "../../public/img/jenny_saludando.webp", "normal", 900);
});

const registerForm = document.querySelector(".form-box.register form");

registerForm.addEventListener("submit", function(e) {
    const pass = registerForm.querySelector("input[name='contraseña']").value;
    const confirm = registerForm.querySelector("input[name='confirmar']").value;

    if (pass !== confirm) {
        e.preventDefault(); // evita que se envíe el formulario
        
        alert("Las contraseñas no coinciden ✘");
        return false;
    }
});

const loginForm = document.querySelector(".form-box.login form");

loginForm.addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(loginForm);

    fetch("../config/login.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {

        if (data.trim() === "success") {
            window.location.href = "menu.php"; // ← Tu menú
        } 
        else if (data.trim() === "faltan_datos") {
            alert("Por favor completa todos los campos.");
        }
        else {
            alert("Correo o contraseña incorrectos ✘");
        }
    });
});
