$(document).keypress(function (e) {
    if ((e.which == 24 || e.which == 88) && e.ctrlKey) {
        window.location.href = BASEURL + '#/access/lock';
    }
    if ((e.which == 19) && e.ctrlKey) {
        if ($('#addRecord').length > 0) {
            $('#addRecord').trigger('click');
        }
    }
});
$(function () {

    $('body').on('click', '.delete-option', function () {
        var $btn = $(this);
        var $tr = $btn.parents('tr');
        var requestedId = $tr.prop('id');
        var target = $btn.data('target');
        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f05050",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                method: 'POST',
                url: BASEURL + 'crud/operation/D/' + target + '/' + requestedId,
                data: {},
                dataType: 'json',
                success: function (resp) {
                    $('tr#' + requestedId).remove();
                    swal("Deleted!", resp.MSG, "success");
                }
            });
        });
    });

    $('body').on('click', '.status-option', function () {
        //$('.status-option').unbind('click').bind('click', function () {
        var $btn = $(this);
        var $tr = $btn.parents('tr');
        var requestedId = $tr.prop('id');
        var checkVal = $btn.hasClass('btn-default') ? 1 : 0;
        var target = $btn.data('target');

        $.ajax({
            method: 'POST',
            url: BASEURL + 'crud/operation/U/' + target + '/' + requestedId,
            data: {
                ngstatus: checkVal
            },
            dataType: 'json',
            success: function (resp) {
                swal("Updated!", resp.MSG, "success");
                if (!checkVal) {
                    $btn.removeClass('btn-success');
                    $btn.addClass('btn-default');
                } else {
                    $btn.removeClass('btn-default');
                    $btn.addClass('btn-success');
                }
            }
        });
    });
    
    /*
     * 
     * @type Boolean
     */
    
    // change status
    $('body').on('click', 'a.change-option', function () {
        var $tr = $(this).parents('tr');
        var requestedId = $tr.prop('id');

        var $td = $("td:eq(2)");
        var Controllerpath = $td.prop('id');

        $.ajax({
            method: 'POST',
            url: BASEURL + Controllerpath + '/A/1/' + requestedId,
            data: {},
            // dataType: 'json',
            success: function (resp) {

                var result = JSON.parse(resp);

                // var StatusName = Controllerpath.split('/');
                if (result.RECORD.value == 'Active') {
                    swal("Activated", resp.MSG, "success");
                    $('#i-lock-' + requestedId).parent().addClass('btn-info').removeClass('btn-danger');
                    $('#i-lock-' + requestedId).addClass('glyphicon-ok').removeClass('glyphicon-remove');
                    // $('#i-lock-' + requestedId).tooltip('Active');
                    $('#i-lock-' + requestedId).parent().attr("data-tooltip", "Active");
                } else {
                    swal("Deactivated", resp.MSG, "success");
                    $('#i-lock-' + requestedId).parent().addClass('btn-danger').removeClass('btn-info');
                    $('#i-lock-' + requestedId).addClass('glyphicon-remove').removeClass('glyphicon-ok');
                    $('#i-lock-' + requestedId).parent().attr("data-tooltip", "Deactive");
                }
            }
        });
    });

    /* check if browser window has focus */

    var notIE = (document.documentMode === undefined),
            isChromium = window.chrome;

    if (notIE && !isChromium) {

        /* checks for Firefox and other  NON IE Chrome versions*/
        $(window).on("focusin", function () {

            /* tween resume() code goes here*/
            setTimeout(function () {
                sessionAjax();
            }, 300);

        }).on("focusout", function () {

            /*tween pause() code goes here*/
            //console.log("blur");

        });

    } else {

        /*checks for IE and Chromium versions*/
        if (window.addEventListener) {

            /*bind focus event*/
            window.addEventListener("focus", function (event) {

                /*tween resume() code goes here*/
                setTimeout(function () {
                    //console.log("focus");
                    sessionAjax();
                }, 300);

            }, false);

            /*bind blur event*/
            window.addEventListener("blur", function (event) {

                /*tween pause() code goes here*/
                //console.log("blur");
            }, false);

        } else {

            /*bind focus event*/
            window.attachEvent("focus", function (event) {

                /*tween resume() code goes here*/
                setTimeout(function () {
                    //console.log("focus");
                    sessionAjax();
                }, 300);

            });

            /*bind focus event*/
            window.attachEvent("blur", function (event) {

                /*tween pause() code goes here*/
                //console.log("blur");
            });
        }
    }
});

function sessionAjax() {
    if ($('#isLoginPage').length == 0) {
        $.ajax({
            type: 'POST',
            datType: 'json',
            url: BASEURL + 'login/sessionCheck',
            data: {
                checkSession: 'y'
            },
            success: function (resp) {
                resp = JSON.parse(resp);
                if (resp.value === -1) {
                    window.location.href = BASEURL + '#/access/signin';
                }
            }
        });
    }
}