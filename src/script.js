let menuDisplayed = false;

$("#register-form").submit(function (e) {
    e.preventDefault();
    $("#register-error").html("");

    const formData = new FormData($("#register-form")[0]);

    if (formData.get("password") !== formData.get("confirm-password"))
        return $("#register-error").html("Passwords do not match");

    const userData = {
        name: formData.get("name"),
        email: formData.get("email"),
        password: formData.get("password"),
    };
    $.ajax({
        type: "POST",
        url: "src/api/users.php",
        data: userData,
        success: function (response) {
            response = JSON.parse(response);
            response.code != 200 ? $("#register-error").html(response.data) : window.location.href = "./login.php";
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        },
    });
});

$("#login-form").submit(function (e) {
    e.preventDefault();
    $("#login-error").html("");
    const formData = new FormData($("#login-form")[0]);
    const userData = {
        loginEmail: formData.get("email"),
        password: formData.get("password"),
    };

    $.ajax({
        type: "POST",
        url: "src/api/users.php",
        data: userData,
        success: function (response) {
            try {
                response = JSON.parse(response);
                response.code != 200 ? $("#login-error").html(response.data) : window.location.href = "./";
            } catch (error) {
                $("#login-error").html("Something went wrong.");
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);

        },
    });
})

$("#menu-button").click(function (e) {
    console.log('hi');
    if (!menuDisplayed) {
        $("#menu").css("display", "flex");
        $("#menu-button").html(`<svg width="24" height="24" fill="currentColor"viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41Z"></path> </svg>`)
        menuDisplayed = true;
    } else {
        $("#menu").css("display", "none");
        $("#menu-button").css("margin-right", "-100%");
        menuDisplayed = false;
    }
});

