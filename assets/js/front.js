let leadpress_modal = (show = true) => {
    if (show) {
        jQuery("#leadpress-modal").show();
    } else {
        jQuery("#leadpress-modal").hide();
    }
};

jQuery(function ($) {
    $("#leadpress-optin-form").on("submit", function (e) {
        e.preventDefault();

        leadpress_modal(true);

        let data = $(this).serialize();

        console.log(data);

        leadpress_modal(false);
    });
});
