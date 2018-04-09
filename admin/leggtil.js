let katBoks = document.querySelector('.kategorier');
let katID = document.querySelector('#katID');
let fraFor = [];

function leggTilBilde() {
let bildeboks = document.querySelector('#bildeID');
let knapp = document.querySelector('#leggTilBildeKnapp');

let child = document.createElement("div");
child.setAttribute("class", "bildeBoks");
child.innerHTML = `<input type="file" class="button" name="bilde[]">`;
bildeboks.appendChild(child);
bildeboks.removeChild(knapp);
bildeboks.appendChild(knapp);
}

/*
function leggTilBilde() {
       let bildeboks = document.querySelector('#bildeID');
       let knapp = document.querySelector('#leggTilBildeKnapp');

       let child = document.createElement("div");
       child.setAttribute("class", "bildeBoks");
       child.innerHTML = `<input type="file" class="button" name="bilde[]">`;
       bildeboks.appendChild(child);
       bildeboks.removeChild(knapp);
       bildeboks.appendChild(knapp);
     }
*/

function leggTilKat() {
katBoks.style.display = "block";
}

function lagHidden (id, navn) {
let finnes = fraFor.includes(id)
let knapp = document.querySelector('#leggTilKatKnapp');

if(!finnes) {
let child = document.createElement("div");
child.setAttribute("class", "katBoks");
child.innerHTML = `<input type="hidden" class="button" name="kat[]" value="${id}"><p>${navn}</p>`;
katID.appendChild(child);
katID.removeChild(knapp);
katID.appendChild(knapp);
fraFor.push(id);
}

katBoks.style.display = "none";
}

function leggTilNy () {
let input = document.querySelector('#nyKat').value;
let knapp = document.querySelector('#leggTilKatKnapp');

let child = document.createElement("div");
child.setAttribute("class", "katBoks");
child.innerHTML = `<input type="hidden" name="nyKat[]" value="${input}"><p>${input}</p>`;
katID.appendChild(child);
katID.removeChild(knapp);
katID.appendChild(knapp);

document.querySelector('#nyKat').value = "";
katBoks.style.display = "none";
}