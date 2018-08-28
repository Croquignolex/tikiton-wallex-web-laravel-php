$(function () {
    $('.min_max').maxlength({
        alwaysShow: true,
        warningClass: "label label-success",
        limitReachedClass: "label label-danger",
        placement: 'top'
    });
});