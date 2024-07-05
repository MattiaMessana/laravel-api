import './bootstrap';
import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import '@fortawesome/fontawesome-free/js/all.min.js';
import.meta.glob(["../img/**"]);


// MODALE CANCELLAZZIONE

//trovo tutti i bottoni di cancellazzione 
const deleteBtns = document.querySelectorAll('.delete-form button');

if (deleteBtns.length > 0) {
    //per ogni bottone ascolta il clik 
    deleteBtns.forEach((btn) => {
       btn.addEventListener('click', function (event) {
            //preveniamo ricaricamento pagina 
            event.preventDefault();

            //creo modale in js 
            const modal = new bootstrap.Modal(
                document.getElementById('delete-modal')
            );
            //preleviamo titolo dal data attribute del bottone
            const projectTitle = btn.dataset.projectTitle;
            //inserisco dati nel modale 
            document.getElementById('modal-title').innerHTML = `Stai per cancelare ${projectTitle}`;
            //ascolto sul bottone del modal 
            document.getElementById('modal-delete-btn').addEventListener('click', function() {
                btn.parentElement.submit();
            });
            //mostro il modale 
            modal.show();
        })
    })
}


// PREVIEW IMAGE

const oldImgElem = document.getElementById('oldImg')
const imgElem = document.getElementById('imagePreview');
const inputElem = document.getElementById('cover_img');
const btnDeleteElem = document.getElementById('btnDelete');

if (imgElem && oldImgElem) {
    inputElem.addEventListener('change', function(e) {
        e.preventDefault();
        //istanza nuovo ogetto filerieder(è un api che ha dei motodi per leggere contenuto file)
        const reader = new FileReader();
        reader.onload = function() {
            imgElem.src = reader.result;
            imgElem.classList.remove('hide');
            oldImgElem.classList.add('hide');
            btnDeleteElem.classList.remove('hide');
        };
        // convert string in url for direcory image
        reader.readAsDataURL(e.target.files[0]);
    
    });


    btnDeleteElem.addEventListener('click', function(e) {
        e.preventDefault();
        btnDeleteElem.classList.add('hide');
        imgElem.classList.add('hide');
        oldImgElem.classList.remove('hide');
        inputElem.value = "";
    });


}

