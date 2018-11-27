$(window).on('load', function () {
    $("#loader").fadeOut();
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover()
});

function notification(notificationTitle, notificationMessage, notificationType, notificationIcon, notificationEnter, notificationExit, notificationDelay){
    $.notify({
        icon: notificationIcon,
        title: notificationTitle,
        message: notificationMessage
    },{
        type: notificationType,
        delay: notificationDelay,
        showProgressbar: true,
        animate: {
            enter: 'animated ' + notificationEnter,
            exit: 'animated ' + notificationExit
        },
        placement: {
            from: 'top',
            align: 'right'
        },
        template:
            '<div data-notify="container" class="col-xs-10 col-sm-6 col-md-5 col-lg-4 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<strong><span data-notify="title">{1}</span></strong><br />' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
            '</div>'
    });
}

function hexadecimalWithoutHashTag(hexadecimal)
{
    return (hexadecimal.charAt(0) === '#')
        ? hexadecimal.substring(1, 7) : hexadecimal;
}

function hexadecimalToRGBa(hexadecimal, alpha = 1){
    let RGB = { red: 0, green: 0, blue: 0 };
    try
    {
        RGB = {
            red : parseInt(hexadecimalWithoutHashTag(hexadecimal).substring(0, 2), 16),
            green : parseInt(hexadecimalWithoutHashTag(hexadecimal).substring(2, 4), 16),
            blue : parseInt(hexadecimalWithoutHashTag(hexadecimal).substring(4, 6), 16)
        }
    }
    catch (e) { RGB = { red: 0, green: 0, blue: 0 } }

    return 'rgba(' + RGB.red + ', ' + RGB.green + ', ' + RGB.blue + ', ' + alpha + ')';
}

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 1000, // Speed back to top (ms)
            easingType: 'easeOutBounce', // Scroll to top easing (see http://easings.net/)
            animation: 'slide', // Fade, slide, none
            animationSpeed: 1000, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});
