/**
 * Created by Wilco on 26/05/17.
 */

$(document).ready(function() {


    $(".button-collapse").sideNav();

    $('.slider').slider({
        interval: 3000,
        indicators: false
    });

    $('select').material_select();

    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 100, // Creates a dropdown of 15 years to control year
        max: new Date(2020, 7, 14),
        min: new Date(1910,7,14)
    });

    $('.datepicker2').pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 30, // Creates a dropdown of 15 years to control year
        min: -1
    });

    $('.modal').modal();


    $('.carousel.carousel-slider').carousel({fullWidth: true});

    setTimeout(autoplay, 4000);
    function autoplay() {
        setTimeout(autoplay, 4000);
        $('.carousel').carousel('next');
    }
});
