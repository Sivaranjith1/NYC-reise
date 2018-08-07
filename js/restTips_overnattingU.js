let meldingBoks = document.querySelector('.melding');
let textBoks = document.querySelector('#text');
let alleTips = document.querySelector('#alleTips');
let antallStjerne = 0;
let stjerneDiv = document.querySelector(".stjerner");

function stjerneTrykk(number) {
    antallStjerne = number;
    let checked = document.querySelectorAll('.checked');
    checked.forEach(elem => elem.classList.remove('checked'));

    let blankeStjerner = stjerneDiv.querySelectorAll('.fa');
    for(i = number; i > 0; i--) {
        blankeStjerner[i-1].classList.add('checked');
    }
}

function sendTips(id) {
    let tipsBoks = document.querySelector('#nyTips').value;
    if(tipsBoks != '' && antallStjerne != 0) {
        fetch('http://127.0.0.1/NYC-reise/rest/nyttReisetipsOvernattingU.php', {
        method: "POST",
        body: JSON.stringify({bes: tipsBoks, attID: id, stjerne: antallStjerne})
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

                let stjerneDiv = "<div class='stjernerAll'>";
                for(i = antallStjerne; i > 0; i--) {
                    stjerneDiv = stjerneDiv+"<span class='fa fa-star'></span>";
                }
                stjerneDiv = stjerneDiv+"</div>";
                child.innerHTML = `<div class='flex1'>${element.beskrivels}</div>${stjerneDiv}`;
                alleTips.appendChild(child);
            }            
            document.querySelector('#nyTips').value = '';
            meldingBoks.style.backgroundColor = element.success ? "#28a745" : "#d9534f";
            visMelding();
            antallStjerne = 0;
            let checked = document.querySelectorAll('.checked');
            checked.forEach(elem => elem.classList.remove('checked'));
        })
    } else if(tipsBoks == '') {
        let melding = 'Tekstboksen kan ikke være tom';
        textBoks.innerHTML = melding;
        meldingBoks.style.backgroundColor = "#d9534f";
        visMelding();
    } else if (antallStjerne == 0) {
        let melding = 'Man må velge stjerner';
        textBoks.innerHTML = melding;
        meldingBoks.style.backgroundColor = "#d9534f";
        visMelding();
    }
    
}

function visMelding() {
    meldingBoks.classList.add("vis");
    setTimeout(function(){ meldingBoks.classList.remove("vis");; }, 30000);
}