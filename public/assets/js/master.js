$(window).on('load', function () {
    $("#loader").fadeOut();
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(function () {
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
            align: 'center'
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