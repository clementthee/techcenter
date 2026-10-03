document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formContacto");
    const mensajeExito = document.getElementById("mensajeExito");
    const btnCerrar = document.getElementById("btnCerrarMensaje");
    const btnModo = document.getElementById("btnModo");

    function aplicarTema(tema) {
        const oscuro = tema === "dark";
        document.documentElement.setAttribute("data-bs-theme", tema);
        btnModo.classList.toggle("es-oscuro", oscuro);
        btnModo.setAttribute("aria-label", oscuro ? "Modo claro" : "Modo oscuro");
        btnModo.setAttribute("aria-pressed", oscuro ? "true" : "false");
        localStorage.setItem("tema", tema);
    }

    aplicarTema(localStorage.getItem("tema") || "light");

    btnModo.addEventListener("click", function () {
        const actual = document.documentElement.getAttribute("data-bs-theme");
        aplicarTema(actual === "dark" ? "light" : "dark");
    });

    // Cuando mandan el formulario
    formulario.addEventListener("submit", function (e) {
        // Que no se recargue la página, qué verguenza
        e.preventDefault();

        // Escondemos el form y sale el aviso de que ya quedó
        formulario.style.display = "none";
        mensajeExito.style.display = "block";
    });

    // Si le dan a Cerrar
    btnCerrar.addEventListener("click", function () {
        // Se va el aviso y el form vuelve limpio, listo para otro
        mensajeExito.style.display = "none";
        formulario.style.display = "block";
        formulario.reset();
    });
});