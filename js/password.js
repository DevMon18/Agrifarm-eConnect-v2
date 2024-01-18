const togglePasswordCheckbox = document.querySelector(".toggle-password");
togglePasswordCheckbox.addEventListener("change", (e) => {
    const o = document.querySelectorAll(".password");
    o.forEach((o) => {
        o.type = e.target.checked ? "text" : "password";
    });
});
