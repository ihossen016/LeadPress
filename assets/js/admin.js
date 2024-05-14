let leadpress_modal = (show = true) => {
    if (show) {
        jQuery("#leadpress-modal").show();
    } else {
        jQuery("#leadpress-modal").hide();
    }
};

jQuery(function ($) {
    // leadpress csv export
    $("#leadpress-export-leads").on("click", function () {
        console.log("clicked");

        const rows = [
            ["Name", "Email", "Date"],
            ["John", "Doe", "2020-01-01"],
            ["Jane", "Doe", "2020-01-02"],
            ["Joe", "Doe", "2020-01-03"],
        ];

        let csvContent =
            "data:text/csv;charset=utf-8," +
            rows.map(e => e.join(",")).join("\n");

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "leadpress_leads.csv");
        document.body.appendChild(link); // Required for FF

        link.click();
    });
});
