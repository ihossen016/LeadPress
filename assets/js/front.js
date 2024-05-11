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

        var form_data = {};
        $.each($(this).serializeArray(), function (i, field) {
            form_data[field.name] = field.value;
        });

        leadpress_modal();

        $.ajax({
            url: `${LEADPRESS.api_base}lead/create`,
            data: {
                nonce: LEADPRESS.rest_nonce,
                ...form_data,
            },
            type: "POST",
            dataType: "json",
            success: function (resp) {
                leadpress_modal(false);
                console.log(resp);
            },
            error: function (err) {
                leadpress_modal(false);
                console.log(err);
            },
        });
    });
});
