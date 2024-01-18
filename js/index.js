const navLinks = document.querySelectorAll(".nav-link");
navLinks.forEach((e) => {
    e.href === window.location.href && e.classList.add("active");
}),
    $.widget.bridge("uibutton", $.ui.button),
    window.setTimeout(function () {
        $(".alert")
            .fadeTo(500, 0)
            .slideUp(500, function () {
                $(this).remove();
            });
    }, 4e3);
