import './bootstrap';
import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import '@fortawesome/fontawesome-free/js/all.min.js';
import.meta.glob(["../img/**"]);


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