jQuery(document).ready(function ($) {
    $('.wemp-rsvp-btn').on('click', function () {

        let eventId = $(this).data('event');

        $.post(wempRSVP.ajax_url, {
            action: 'wemp_rsvp',
            event_id: eventId,
            nonce: wempRSVP.nonce
        }, function (response) {
            alert(response.data);
        });
    });
});