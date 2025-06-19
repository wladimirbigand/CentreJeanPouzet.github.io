document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('selectActusToEdit');
    const titleInput = document.getElementById('modifyActusTitle');
    const textArea = document.getElementById('modifyActusText');
    const currentImg = document.getElementById('previewModifyActusImage');

    function updateFields() {
        const id = select.value;
        titleInput.value = actusData[id].titre;
        textArea.value = actusData[id].texte;

        // Affiche l'image liée à l'actu
        if (actusData[id].image && actusData[id].image !== "") {
            currentImg.src = actusData[id].image;
            currentImg.style.display = "block";
        } else {
            currentImg.src = "";
            currentImg.style.display = "none";
        }
    }

    select.addEventListener('change', updateFields);
    updateFields();
});

// Aperçu d’image dynamique pour les deux sections
function previewImage(input, imgId) {
    const file = input.files[0];
    if (!file) return;

    const fr = new FileReader();
    fr.onload = function (e) {
        const img = document.getElementById(imgId);
        img.src = e.target.result;
        img.style.display = "block";
    };
    fr.readAsDataURL(file);
}

document.getElementById('addActusImage')
    .addEventListener('change', e => previewImage(e.target, 'previewAddActusImage'));

document.getElementById('modifyActusImage')
    .addEventListener('change', e => previewImage(e.target, 'previewModifyActusImage'));
