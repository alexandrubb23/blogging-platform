$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#createPost").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "/post",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        },
    });
}
