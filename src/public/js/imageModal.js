document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("image-modal");
    const modalImg = document.getElementById("modal-image");
    const closeBtn = document.querySelector(".close");

    document.querySelectorAll(".preview-image").forEach(img => {
        img.addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = this.src;
        });
    });

    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    modal.onclick = function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };
});