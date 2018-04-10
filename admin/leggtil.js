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

let postSant = false;
function egenPostKnapp () {
  postSant = !postSant;
  let hele = document.querySelector('.post');
  let eksister = document.querySelector('#selectPost');
  let ny = document.querySelector('#egenPost');

  if(postSant) {
    eksister.style.right = "100%";
    eksister.style.left = "auto";

    ny.style.right = "0%";
    ny.style.left = "auto";

    hele.style.height = "214px";
    document.getElementById("postnum").required = true;
  } else {
    eksister.style.right = "auto";
    eksister.style.left = "0";

    ny.style.right = "auto";
    ny.style.left = "100%";

    hele.style.height = "82px";
    document.getElementById("postnum").required = false;
  }
}

let stjerneEgen = document.querySelector('.stjerneEgen');
let viser = false;
function stjerneEgenSelect(dette) {
  let verdi = dette.value;

  if (dette.value === "egen") {
    viser = true;
    stjerneEgen.style.height = "80px";
    stjerneEgen.style.padding = "20px";
    stjerneEgen.style.display = "block";
    document.getElementById("egenStjerne").required = true;
  } else if (viser) {
    viser = false;
    stjerneEgen.style.height = "0px";
    stjerneEgen.style.padding = "0px";
    stjerneEgen.style.display = "none";
    document.getElementById("egenStjerne").required = false;
  }
}