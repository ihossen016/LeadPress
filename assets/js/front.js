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

                if (resp.success) {
                    $(this).hide();

                    $(".leadpress-optin-message").removeClass("hide");
                } else {
                    $(".leadpress-optin-form-message").append(
                        `<p>${resp.message}</p>`
                    );
                    console.log(resp.message);
                    $(".leadpress-optin-form-message").show();
                }
            },
            error: function (err) {
                leadpress_modal(false);
                console.log(err);
            },
        });
    });
});
