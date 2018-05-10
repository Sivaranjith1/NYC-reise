let ikkeHenter = true;
let total = document.querySelector('#totalt').innerHTML;
let offset = 5;
let igjen = total.split(" ")[0] - offset;
let nummer = 1;
let bydelGet = '';

let container = document.querySelector('.container');
window.onscroll = function(ev) {
if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 100) && ikkeHenter) {
    ikkeHenter = false;
    igjen > 0 && hentData();
}
};

let url = `http://127.0.0.1/NYC-reise/rest/attraksjon.php?num=${nummer}`;
function hentData() {
url = `http://127.0.0.1/NYC-reise/rest/attraksjon.php?num=${nummer}&${bydelGet}`;
fetch(url)
    .then(function(response) {
    return response.json();
    })
    .then(data => {
    igjen -= offset; 
    nummer ++;
    let antall = 0;
    data.forEach(element => {
        let child = document.createElement("div");
        child.setAttribute("class", "att");
        let gatenr = element.gatenr == 0 ? '' : element.gatenr;
        child.innerHTML = `<a class='overLenke' href='${element.lenk}'></a>
            <div class='bilde'>
                <img src='${element.bilde}' alt='bilde av attraksjon'>
            </div>
            <div class='flex1'>
                <h2>${element.Navn}</h2>
                <p>Addresse: ${gatenr} ${element.addresse}, ${element.postnummer} ${element.Poststed}</p>
                <h4>${element.bydelNavn}</h4>
                <p>${element.tid}</p>
                <div class='col'>
                    <p>Kategori: </p>
                    ${element.katRekke}
                </div>
            </div>`;
        container.appendChild(child);
        antall = element.totalt && element.totalt;
        if(antall != 0) {document.querySelector('#totalt').innerHTML = antall + " resultater";}
    });
    if(igjen > 0) {
        ikkeHenter = true;
    }
    })
}

function filterTrykket() {
let fil = document.querySelector('.filtere');
fil.classList.toggle('aapen');
}

let bydelOppdater = false;
function sokFilter(){

if(bydelOppdater){
    let attBokser = document.querySelectorAll(".att");
    ikkeHenter = false;
    attBokser.forEach(element => {
    element.parentNode.removeChild(element);
    });

    //bydel
    bydelGet = '';
    let forste = true;
    bydelArray.forEach(element => {
    if(!forste) {
        bydelGet = bydelGet + '&';
    }

    bydelGet = bydelGet + `bydel[]=${element}`;
    forste = false;
    })
    
    igjen = total.split(" ")[0];
    nummer = 0;
    url = `http://127.0.0.1/NYC-reise/rest/attraksjon.php?num=${nummer}&${bydelGet}`;
    hentData();

    bydelOppdater = false;
}


}

let bydelArray = []
function endreBydel (n, bydel) {
bydelOppdater = true
if(bydelArray[n] != bydel){
    bydelArray[n] = bydel;
} else {
    bydelArray[n] = null;
}
}