$(document).ready(function (){

    // Banner Hover effect
    let ImgBannerFilm = document.querySelectorAll('.para-card');
    console.log(ImgBannerFilm );
    // Looping
    for (i = 0; i < ImgBannerFilm.length; i ++){
        console.log(ImgBannerFilm.length);
        ImgBannerFilm[i].addEventListener('mousemove', function(e){

            let posX = 10;
            let posY = 50;

            // let posX = -e.positionLeft;
            // let posY = -e.positionTop;

            console.log(ImgBannerFilm[i]);

            this.style.setProperty('--x', posX+ 'px');
            this.style.setProperty('--y', posY + 'px');

        });


    }

    // Change effect select input
    let selectNote = document.querySelectorAll('.select-dropdown');
        for (i = 0; i < selectNote.length; i++) {
        selectNote[i].addEventListener('change', function(e) {

            this.classList.add('focused-selected');
        });
    }




});