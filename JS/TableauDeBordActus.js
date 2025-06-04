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

    document.getElementById('modifyActusImage')
        .addEventListener('change', function() {
            currentImg.style.display = "none";
        });
});

    // Aperçu d’image
    function previewImage(input, previewEl) {
        previewEl.innerHTML = '';
        if (!input.files[0]) return;
        const fr = new FileReader();
        fr.onload = e => previewEl.innerHTML = `<img src="${e.target.result}">`;
        fr.readAsDataURL(input.files[0]);
    }
    document.getElementById('addActusImage')
        .addEventListener('change', e=> previewImage(e.target, document.getElementById('previewAddActusImage')));
    document.getElementById('modifyActusImage')
        .addEventListener('change', e=> previewImage(e.target, document.getElementById('previewModifyActusImage')));

