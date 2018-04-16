$alleSlide = document.querySelector(".alleSlides");
$slideNummer = 1;
$antallSlide = document.querySelectorAll(".slide").length;
function slideVenstre() {
    if($slideNummer === $antallSlide) {
        $slideNummer = 1;
        $alleSlide.style.left = "0%";
    }else {
        $slideNummer ++;
        $alleSlide.style.left = -(($slideNummer - 1) * 100) + "%";
    }
}

function slideHoyre() {
    if($slideNummer === 1) {
        $slideNummer = $antallSlide;
        $alleSlide.style.left = -(($slideNummer - 1) * 100) + "%";
    } else {
        $slideNummer --;
        $alleSlide.style.left = -(($slideNummer - 1) * 100) + "%";
    }
}