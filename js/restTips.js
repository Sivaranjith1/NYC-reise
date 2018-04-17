let meldingBoks = document.querySelector('.melding');
let textBoks = document.querySelector('#text');
let alleTips = document.querySelector('#alleTips');

function sendTips(id) {
    let tipsBoks = document.querySelector('#nyTips').value;
    if(tipsBoks != '') {
        fetch('http://127.0.0.1/NYC-reise/rest/nyttReisetips.php', {
        method: "POST",
        body: JSON.stringify({bes: tipsBoks, attID: id})
        })
        .then(element => element.json())
        .then(element => {
            let melding = element.success ? element.success : element.error;
            element.error && console.error(element.error);
            let virker = element.success ? true : false;
            textBoks.innerHTML = melding;
            if(virker){
                let child = document.createElement("div");
                child.setAttribute("class", "tips");
                child.innerHTML = `${element.beskrivels}`;
                alleTips.appendChild(child);
            }            
            document.querySelector('#nyTips').value = '';
            meldingBoks.style.backgroundColor = element.success ? "#28a745" : "#d9534f";
            visMelding();
        })
    } else {
        let melding = 'Tekstboksen kan ikke være tom';
        textBoks.innerHTML = melding;
        meldingBoks.style.backgroundColor = "#d9534f";
        visMelding();
    }
    
}

function visMelding() {
    meldingBoks.classList.add("vis");
    setTimeout(function(){ meldingBoks.classList.remove("vis");; }, 3000);
}