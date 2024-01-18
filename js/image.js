function preview(e, t) {
    const n = document.getElementById(t);
    e.addEventListener("change", () => {
        n.innerHTML = "";
        for (const t of e.files) {
            const e = new FileReader();
            (e.onload = (e) => {
                const t = new Image();
                (t.src = e.target.result), t.classList.add("show-image"), n.appendChild(t);
            }),
                e.readAsDataURL(t);
        }
    });
}
const image1 = document.getElementById("image-1"),
    image2 = document.getElementById("image-2"),
    image3 = document.getElementById("image-3");
    preview(image1, "show-1"),
    preview(image2, "show-2"),
    preview(image3, "show-3");