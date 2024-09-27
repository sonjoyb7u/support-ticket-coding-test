const charts = document.querySelectorAll(".chart");

charts.forEach(function (chart) {
    var ctx = chart.getContext("2d");
    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [
                {
                    label: "# of Votes",
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(255, 206, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(255, 159, 64, 1)",
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
});

$(document).ready(function () {
    $(".data-table").each(function (_, table) {
        $(table).DataTable();
    });
});

// Update product active/inactive status ...
$(document).on("click", ".updateTicketClosedStatus", function () {
    var status = $(this).children("i").attr("status");
    var id = $(this).attr("ticket_id");
    // var status_id = $('.ticket_status').data("id");
    $.ajax({
        headers: {
            "X-CSRF-Token": $("meta[name=csrf-token]").attr("content"),
        },
        type: "POST",
        url: "/admin/tickets/update-ticket-close-status",
        data: { id: id, status: status },
        beforeSend: function () {},
        success: function (response) {
            if (response.status == 1) {
                $(`#ticket-id-${response.id}`).html(
                    `<i style="font-size: 30px; color: red" class="bi bi-toggle-off" status="close"></i>`
                );
                $(`#ticket_status_${response.id}`).text("Open");
                toastr.success(response.message);
            } else {
                $(`#ticket-id-${response.id}`).html(
                    `<i style="font-size: 30px; color: green" class="bi bi-toggle-on" status="open"></i>`
                );
                $(`#ticket_status_${response.id}`).text("Closed");
                toastr.error(response.message);
            }
        },
        error: function (error) {
            console.log(`Error: ${error}`);
        },
    });
});
// Update brand active/inactive status ...
