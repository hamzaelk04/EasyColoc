document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");
    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Inscription réussie (simulation) !");
            window.location.href = "dashboard.html";
        });
    }

    // Menu mobile
    const menuToggle = document.getElementById("menuToggle");
    const navLinks = document.getElementById("navLinks");
    if (menuToggle) {
        menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    }
});
