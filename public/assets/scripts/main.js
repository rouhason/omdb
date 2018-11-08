$(document).ready(function (){

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





});