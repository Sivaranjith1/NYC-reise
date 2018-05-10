let sugBox = document.querySelector('.suggest');
function getSok() {
    let verdi = document.getElementById('sookBar').value;
    if (verdi != '') {
        fetch(`http://127.0.0.1/NYC-reise/rest/sook.php?sok=${verdi}`)
            .then(res => res.json())
            .then(res => {
                sugBox.innerHTML = '';
                let child;
                res.forEach(element => {
                    child = document.createElement("div");
                    child.setAttribute("class", "suggBox");
                    child.innerHTML = `
                        <a class="overLenke" style="z-index: 80;" href="attDetalje.php?id=${element.id}"></a>
                        <div class='bilde'><img src='${element.bilde}' alt='bilde av attraksjon'/></div>
                        <div class='flex1'>
                        <h3 style="margin:0;">${element.Navn}</h3>
                        <h4>Pris: ${element.pris}</h4>
                        </div>
                        `;
                    sugBox.appendChild(child);
                });
            })
    }
}