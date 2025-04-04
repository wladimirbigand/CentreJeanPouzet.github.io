document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("myModal");
    const images = document.querySelectorAll(".ContainerIMG img#IMG");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    var span = document.getElementsByClassName("close")[0]; // Sélectionne la croix pour fermer

    // Ouvre le modal au clic sur une image
    images.forEach((img) => {
        img.onclick = function () {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        };
    });

    // Ferme le modal au clic sur la croix
    span.onclick = function () {
        modal.style.display = "none";
    };

    // Ferme le modal au clic en dehors de l'image
    modal.onclick = function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };
});
