$(document).ready(function () {

    let menuDisplayed = false;

    function printStars(rating) {
        let fullStar = '<svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24"\
                        xmlns="http://www.w3.org/2000/svg">\
                        <path\
                            d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27Z">\
                        </path>\
                    </svg>';

        let halfStar = '<svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill - rule="evenodd" d = "m14.81 8.62 7.19.62-5.45 4.73L18.18 21 12 17.27 5.82 21l1.64-7.03L2 9.24l7.19-.61L12 2l2.81 6.62ZM12 6.1v9.3l3.77 2.28-1-4.28 3.32-2.88-4.38-.38L12 6.1Z" clip - rule="evenodd" ></path></svg> ';    // Half star

        let emptyStar = '<svg width="16" height="16" fill="yellow" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d = "m22 9.74-7.19-.62L12 2.5 9.19 9.13 2 9.74l5.46 4.73-1.64 7.03L12 17.77l6.18 3.73-1.63-7.03L22 9.74ZM12 15.9l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.6l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.9Z" ></path></svg >';   // Empty star

        let fullStars = Math.floor(rating);
        let halfStars = (rating - fullStars >= 0.5) ? 1 : 0;
        let emptyStars = 5 - (fullStars + halfStars);

        let i, str = '';
        for (i = 0; i < fullStars; i++) {
            str += fullStar;
        }

        if (halfStars) {
            str += halfStar;
        }

        for (i = 0; i < emptyStars; i++) {
            str += emptyStar;
        }

        return str;
    }

    function capitalizeFirst(string) { return string.charAt(0).toUpperCase() + string.slice(1); }

    let changingRoles = false;

    let shownPassword = false;
    let showConfirm = false;

    $(document).on('click', function (event) {
        if ($(event.target).is('#filterModal')) {
            $('#filterModal').css('display', 'none');
        }
    });

    $(".filter-button").click(function () {
        $("#filterModal").css("display", "flex");
    })

    $("#closeModal").click(function () {
        $("#filterModal").css("display", "none");
    })

    $(".show-password").click(function () {
        if (shownPassword) {
            $(".password-input").attr("type", "password");
            shownPassword = false;
        } else {
            $(".password-input").attr("type", "text");
            shownPassword = true;
        }
    })

    $("#show-confirm").click(function () {
        if (showConfirm) {
            $(".confirm-password-input").attr("type", "password");
            showConfirm = false;
        } else {
            $(".confirm-password-input").attr("type", "text");
            showConfirm = true;
        }
    })

    $("#chemical").change(function () {
        this.checked ? $("#suitability").css('display', 'none') : $("#suitability").css('display', 'flex');
    });

    $("#change-role").click(function () {
        if (!changingRoles) {
            $("#change-role").html("Save");
            $("#role").css("display", "none");
            $("#change-role-select").css("display", "block");
        } else {
            $("#change-role").html("Change role");
            $("#role").css("display", "block");
            $("#change-role-select").css("display", "none");

            $("#change-role-error").html("");

            $.ajax({
                type: "PATCH",
                url: "src/api/users.php",
                data: JSON.stringify({
                    id: $("#role").attr("data-id"),
                    role: $("#change-role-select").val(),
                }),
                success: function (response) {
                    console.log(response)
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#change-role-error").html(response.data)
                    } else {
                        $("#change-role-error").css("color", "#059669");
                        $("#change-role-error").html("User role has been updated. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./view-user.php?id=" + $("#role").attr("data-id");
                        }, 3000);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }

        changingRoles = !changingRoles;
    })

    $('.star').on('click', function () {
        const index = $(this).index();
        const rating = index + 1;

        // Update the hidden input value
        $('#rating').val(rating);

        // Reset all stars
        $('.star').removeClass('selected');

        // Highlight the selected stars
        $('.star').slice(0, rating).addClass('selected');
    });

    if ($("#stylistsList").length) {
        $.ajax({
            type: "GET",
            url: "src/api/stylists.php",
            success: function (response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    $("#stylistsList").empty();
                    const toShow = response.data.slice(0, 12);
                    toShow.forEach(stylist => {
                        const stars = printStars(stylist.average_rating);
                        $("#stylistsList").append(`
                        <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: white; cursor: pointer;" onclick="window.location.href = './view-stylist.php?id=${stylist.stylist_id}';">
                                <div style="display: flex; align-items: center; gap: 1.5rem;">
                                    <img src="./uploads/${stylist.stylist_img}" alt="stylist" width="48" height="48" style="border-radius: 9999px;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 1.125rem; line-height: 1.75rem;">${stylist.stylist_name}</span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem; opacity: 75%;">${stylist.stylist_email}</span>
                                    </div>
                                </div>
                                <span>${stars}</span>
                        </div>`
                        );
                    });
                }
            }
        });

        $("#stylists-search").on("input", function () {
            const search = $("#stylists-search");
            $.ajax({
                type: "GET",
                data: {
                    search: search.val()
                },
                url: "src/api/stylists.php",
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        $("#stylistsList").empty();
                        const toShow = response.data.slice(0, 12);

                        toShow.forEach(stylist => {
                            const stars = printStars(stylist.average_rating);
                            $("#stylistsList").append(`
                            <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: white; cursor: pointer;" onclick="window.location.href = './view-stylist.php?id=${stylist.stylist_id}';">
                                <div style="display: flex; align-items: center; gap: 1.5rem;">
                                    <img src="./uploads/${stylist.stylist_img}" alt="stylist" width="48" height="48" style="border-radius: 9999px;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 1.125rem; line-height: 1.75rem;">${stylist.stylist_name}</span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem; opacity: 75%;">${stylist.stylist_email}</span>
                                    </div>
                                </div>
                                <span>${stars}</span>
                            </div>`
                            );
                        });
                    }
                }
            });
        });
    }

    let appointments = [];
    let services = [];
    let treatments = [];
    let users = [];

    function displayAppointments(appointmentArray = appointments) {
        $("#appointmentsList").empty();
        const toShow = appointmentArray.slice(0, 12);

        toShow.forEach(appointment => {
            let color = 'background-color: rgb(115 115 115);';

            switch (appointment.status) {
                case 'pending':
                    color = 'background-color: rgb(115 115 115);';
                    break;
                case 'confirmed':
                    color = 'background-color: rgb(14 165 233);';
                    break;
                case 'completed':
                    color = 'background-color: rgb(34 197 94);';
                    break;
                case 'rescheduled':
                    color = 'background-color: rgb(234 179 8);';
                    break;
                case 'cancelled':
                case 'noshow':
                    color = 'background-color: rgb(239 68 68);';
                    break;
                default:
                    color = 'background-color: rgb(115 115 115);';
                    break;
            }

            const date = appointment.schedule.split(" ")[0];

            let dateObj = new Date(appointment.schedule);
            let hours = dateObj.getHours();
            let minutes = dateObj.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            let formattedTime = `${hours}:${minutes < 10 ? '0' : ''}${minutes} ${ampm}`;

            const link = $("#appointmentsList").attr("data-userid") ? 'view-appointment.php' : 'admin-view-appointment.php';

            $("#appointmentsList").append(`
            <tr onclick="window.location.href = '${link}?id=${appointment.appointment_id}';" class="appointment-row">
                <td style="display: flex; justify-content: center; padding: 0.5rem 0rem;">
                    ${appointment.stylist}
                </td>
                ${!$("#appointmentsList").attr("data-userid") && `<td>${appointment.customer}</td>`}
                <td>${appointment.service}</td>
                <td>${date}</td>
                <td>${formattedTime}</td>
                <td style="padding-left: 1rem; padding-right: 1rem; width: 9rem; ">
                    <div style="${color} border-radius: 9999px; color: white; padding-top: 0.25rem; padding-bottom: 0.25rem;">
                        ${appointment.status == "noshow" ? "No show" : appointment.status.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}
                    </div>
                </td>
            </tr>`
            );
        });
    }

    function displayServices(servicesArray = services) {
        $("#servicesList").empty();
        console.log(servicesArray);
        const toShow = servicesArray.slice(0, 12);
        toShow.forEach(service => {

            const link = $("#servicesList").attr("data-userid") ? 'admin-view-service.php' : 'view-service.php';
            $("#servicesList").append(`
                        <div style="border-radius: 0.375rem; display: flex; padding: 1.5rem; background-color: white; cursor: pointer;">
                                <div style="display: flex; gap: 0.5rem; ${!$("#servicesList").attr("data-userid") ? "width: 100%;" : "width: 100%;"}" onclick="window.location.href = './${link}?id=${service.id}';">
                                    <img src="./uploads/services/${service.img_path}" alt="Image" style="width: 3rem; height: 3rem; border-radius: 9999px;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem; width: 9rem;">
                                        <span style="font-size: 1.125rem; line-height: 1.75rem;">${service.name}</span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem; width: 100%;">${service.description.length > 35 ? service.description.substring(0, 35) + '...' : service.description}</span>
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column;  align-items: flex-end; gap: 0.5rem;width: 6rem;">
                                    <span style="color: #49454F; text-align: left;">&#x20B1; ${service.price}</span>
                                    ${!$("#servicesList").attr("data-userid") && service.chemical == 0 ? `<button onclick="testFunction(${service.id})" style="background-color: #A80011; border: 0px; color: white; padding: 0.5rem; border-radius: 0.5rem; cursor: pointer; width: 10rem;">Reserve appointment</button>` : ''}
                                </div>
                        </div>`
            );
        });
    }

    function displayTreatments(treatmentsArray = treatments) {
        $("#treatmentsList").empty();
        const toShow = treatmentsArray.slice(0, 12);
        toShow.forEach(treatment => {
            const link = $("#treatmentsList").attr("data-userid") ? 'admin-view-treatment.php' : 'view-treatment.php';
            $("#treatmentsList").append(
                `<div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: white; cursor: pointer;" onclick="window.location.href = './${link}?id=${treatment.treatment_id}';">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <img src="./uploads/services/${treatment.img_path}" alt="Image" style="width: 3rem; height: 3rem; border-radius: 9999px;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 1.125rem; line-height: 1.75rem;">${treatment.name}</span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem;">${treatment.description.length > 35 ? service.description.substring(0, 35) + '...' : treatment.description}</span>
                                    </div>
                                </div>
                                <span style="color: #49454F;">&#x20B1; ${treatment.price}</span>
                        </div>`
            );
        });
    }

    function displayUsers(usersArray = users) {
        $("#usersList").empty();
        const toShow = usersArray.slice(0, 12);
        toShow.forEach(user => {
            $("#usersList").append(
                `<div
                    style="background-color: white; display: flex; flex-direction: column; padding: 1rem; border-radius: 0.875rem; cursor: pointer;" onclick="window.location.href = './view-user.php?id=${user.id}';">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="display: flex; gap: 1rem; width: 3rem; height: 3rem;">
                            <img src="./uploads/${user.img_path}" alt="user" style="width: 100%; border-radius: 9999px;">
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                <span>${user.name}</span>
                                <span style="color: rgb(115, 115, 115")>${user.email}</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center;">${capitalizeFirst(user.role)}</div>
                    </div>
                </div>`
            );
        });
    }

    $(".clear-filters").click(function () {
        $("#staff").val("");
        $("#customer").val("");
        $("#service").val("");
        $("#date").val("");
        $("#time").val("");
        $("#status").val("");

        $("#name").val("");
        $("#description").val("");
        $("#price").val("");

        $("#name").val("");
        $("#email").val("");
        $("#role").val("");

        displayAppointments();
        displayServices();
        displayUsers();
        displayTreatments();
        $('#filterModal').css('display', 'none');
    });

    $("#filterAppointments").submit(function (event) {
        event.preventDefault();
        const staff = $("#staff").val().toLowerCase();
        const customer = $("#customer").val().toLowerCase();
        const service = $("#service").val().toLowerCase();
        const date = $("#date").val();
        const time = $("#time").val();
        const status = $("#status").val().toLowerCase();

        const filteredAppointments = appointments.filter(appointment => {
            return (
                (staff === "" || appointment.stylist.toLowerCase().includes(staff)) &&
                (customer === "" || appointment.customer.toLowerCase().includes(customer)) &&
                (service === "" || appointment.service.toLowerCase().includes(service)) &&
                (date === "" || appointment.schedule.includes(date)) &&
                (time === "" || appointment.schedule.includes(time)) &&
                (status === "" || appointment.status.toLowerCase() === status)
            );
        });

        displayAppointments(filteredAppointments);
        $('#filterModal').css('display', 'none');
    })

    $("#filterServices").submit(function (event) {
        event.preventDefault();
        const name = $("#name").val().toLowerCase();
        const description = $("#description").val().toLowerCase();
        const price = $("#price").val();

        const filteredServices = services.filter(service => {
            return (
                (name === "" || service.name.toLowerCase().includes(name)) &&
                (description === "" || service.description.toLowerCase().includes(description)) &&
                (price == "" || service.price == price || Math.floor(service.price) == price)
            );
        });

        displayServices(filteredServices);
        $('#filterModal').css('display', 'none');
    })

    let showingDropdown = false;

    $("#dropdownFilter").click(function () {
        $("#dropdown").css('display', showingDropdown ? 'none' : 'block');
        showingDropdown = !showingDropdown;
    })

    $(".filterUsers").click(function () {
        const filteredUsers = users.filter(user => user.role.includes($(this).attr("data-id")));

        displayUsers($(this).attr("data-id") == "all" ? users : filteredUsers);
    })

    $(".filterAppointments").click(function () {
        const filteredAppointments = appointments.filter(appointment => appointment.status.includes($(this).attr("data-id").toLowerCase()));

        displayAppointments($(this).attr("data-id") == "all" ? appointments : filteredAppointments);
    })

    $(".filterServices").click(function () {
        const filteredServices = services.filter(service => service.chemical == $(this).attr("data-id"));

        displayServices($(this).attr("data-id") == "all" ? services : filteredServices);
    })

    $("#filterUsers").submit(function (event) {
        event.preventDefault();
        const name = $("#name").val().toLowerCase();
        const email = $("#email").val().toLowerCase();
        const role = $("#role").val().toLowerCase();

        const filteredUsers = users.filter(user => {
            return (
                (name === "" || user.name.toLowerCase().includes(name)) &&
                (email === "" || user.email.toLowerCase().includes(email)) &&
                (role === "" || user.role.includes(role))
            );
        });

        displayUsers(filteredUsers);
        $('#filterModal').css('display', 'none');
    })

    if ($("#usersList").length) {
        $.ajax({
            type: "GET",
            url: "src/api/users.php",
            success: function (response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    users = response.data;
                    displayUsers();
                }
            }
        });

        $("#users-search").on("input", function () {
            const search = $("#users-search");
            $.ajax({
                type: "GET",
                data: {
                    search: search.val()
                },
                url: "src/api/users.php",
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        users = response.data;
                        displayUsers();
                    }
                }
            });
        });
    }

    if ($("#servicesList").length) {
        $.ajax({
            type: "GET",
            data: {
                popular: 12
            },
            url: "src/api/services.php",
            success: function (response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    services = response.data;
                    displayServices();
                }
            }
        });

        $("#services-search").on("input", function () {
            const search = $("#services-search");
            $.ajax({
                type: "GET",
                data: {
                    popular: 10,
                    search: search.val()
                },
                url: "src/api/services.php",
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        services = response.data;
                        displayServices();
                    }
                }
            });
        });
    }

    if ($("#treatmentsList").length) {
        $.ajax({
            type: "GET",
            url: "src/api/treatments.php",
            success: function (response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    treatments = response.data;
                    displayTreatments();
                }
            }
        });

        $("#treatments-search").on("input", function () {
            const search = $("#treatments-search");
            $.ajax({
                type: "GET",
                data: {
                    search: search.val()
                },
                url: "src/api/treatments.php",
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        treatments = response.data;
                        displayTreatments();
                    }
                }
            });
        });
    }

    if ($("#appointmentsList").length) {
        $.ajax({
            type: "GET",
            data: {
                customer_id: $("#appointmentsList").attr("data-userid")
            },
            url: "src/api/appointments.php",
            success: function (response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    appointments = response.data;
                    displayAppointments();
                }
            }
        });

        $("#appointments-search").on("input", function () {
            const search = $("#appointments-search");

            $.ajax({
                type: "GET",
                data: {
                    customer_id: $("#appointmentsList").attr("data-userid"),
                    search: search.val()
                },
                url: "src/api/appointments.php",
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.code == 200) {
                        appointments = response.data;
                        displayAppointments();
                    }
                }
            });
        });
    }

    let isRescheduling = false;

    $("#reschedule-appointment").submit(function (event) {
        event.preventDefault();
        $("#reschedule-error").html("");

        if (!isRescheduling) {
            $("#formattedDate").hide();
            $("#rescheduled_date").attr("type", "datetime-local");
        } else {

            const formData = new FormData($("#reschedule-appointment")[0]);

            const rescheduleData = {
                id: formData.get("id"),
                customer_id: formData.get("customer_id"),
                stylist_id: formData.get("stylist_id"),
                status: formData.get("status") ? formData.get("status") : "Rescheduled",
                scheduled_date: $("#rescheduled_date").val()
            }


            const link = formData.get("status") ? 'admin-view-appointment.php' : 'view-appointment.php';

            $.ajax({
                type: "PATCH",
                url: "src/api/appointments.php",
                data: JSON.stringify(rescheduleData),
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#reschedule-error").html(response.data)
                    } else {
                        $("#reschedule-error").css("color", "#059669");
                        $("#reschedule-error").html(`Your appointment has been ${formData.get("status") ? "edited" : "rescheduled"}. Redirecting...`);
                        setTimeout(() => {
                            window.location.href = `./${link}?id=` + rescheduleData.id;
                        }, 3000);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }
        isRescheduling = !isRescheduling;
    });

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
                console.log(response);
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
    });

    $("#admin-login-form").submit(function (e) {
        e.preventDefault();
        $("#admin-login-error").hide();
        const formData = new FormData($("#admin-login-form")[0]);
        const userData = {
            loginEmail: formData.get("email"),
            password: formData.get("password"),
            admin: true
        };

        $.ajax({
            type: "POST",
            url: "src/api/users.php",
            data: userData,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    $("#admin-login-error").css("display", "block");
                    response.code != 200 ? $("#admin-login-error").html(response.data) : window.location.href = "./admin-dashboard.php";
                } catch (error) {
                    $("#admin-login-error").css("display", "block");
                    $("#admin-login-error").html("Something went wrong.");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);

            },
        });
    })

    $("#add-user").submit(function (event) {
        event.preventDefault();

        $("#user-error").html("");
        const formData = new FormData($("#add-user")[0]);

        $.ajax({
            type: "POST",
            url: "src/api/users.php",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function (response) {
                try {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#user-error").html(response.data)
                    } else {
                        $("#user-error").css("color", "#059669");
                        $("#user-error").html("Your user has been added. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./users.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#user-error").html("Something went wrong.");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#add-treatment").submit(function (event) {
        event.preventDefault();

        $("#treatment-error").html("");
        const formData = new FormData($("#add-treatment")[0]);

        $.ajax({
            type: "POST",
            url: "src/api/treatments.php",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#treatment-error").html(response.data)
                    } else {
                        $("#treatment-error").css("color", "#059669");
                        $("#treatment-error").html("Your treatment has been added. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./admin-treatments.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#treatment-error").html("Something went wrong.");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#add-service").submit(function (event) {
        event.preventDefault();

        $("#service-error").html("");
        const formData = new FormData($("#add-service")[0]);

        $.ajax({
            type: "POST",
            url: "src/api/services.php",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            success: function (response) {
                try {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#service-error").html(response.data)
                    } else {
                        $("#service-error").css("color", "#059669");
                        $("#service-error").html(response.data);
                        setTimeout(() => {
                            window.location.href = "./admin-services.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#service-error").html("Something went wrong.");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#add-review").submit(function (event) {
        event.preventDefault();

        $("#review-error").html("");
        const formData = new FormData($("#add-review")[0]);
        const reviewData = {
            customer_id: formData.get("customer_id"),
            appointment_id: formData.get("appointment_id"),
            rating: formData.get("rating"),
            review: formData.get("review"),
        };

        $.ajax({
            type: "POST",
            url: "src/api/reviews.php",
            data: reviewData,
            success: function (response) {
                try {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#review-error").html(response.data)
                    } else {
                        $("#review-error").css("color", "#059669");
                        $("#review-error").html("Your review has been added. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./view-appointment.php?id=" + reviewData.appointment_id;
                        }, 3000);
                    }
                } catch (error) {
                    $("#review-error").html("Something went wrong.");
                    console.log(error);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    });


    $("#confirm-reservation").submit(function (event) {
        event.preventDefault();

        $("#reservation-error").html("");
        const formData = new FormData($("#confirm-reservation")[0]);
        const reservationData = {
            customer_id: formData.get("customer"),
            stylist_id: formData.get("stylist"),
            service_id: formData.get("service"),
            status: 'pending',
            scheduled_date: formData.get("date") + ' ' + formData.get("time"),
        };

        $.ajax({
            type: "POST",
            url: "src/api/appointments.php",
            data: reservationData,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    console.log(response)
                    if (response.code != 200) {
                        $("#reservation-error").html(response.data)
                    } else {
                        $("#reservation-error").css("color", "#059669");
                        $("#reservation-error").html(`Your appointment for ${response.data.service_name} with ${response.data.stylist_name} at ${new Date(response.data.appointment_date).toDateString()} ${new Date(response.data.appointment_date).toLocaleTimeString()} has been confirmed. Redirecting...`);
                        setTimeout(() => {
                            window.location.href = "./dashboard.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#reservation-error").html("Something went wrong.");
                    console.log(response);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    // $("#submit-consultation").submit(function (event) {
    //     event.preventDefault();

    //     $("#consultation-error").html("");
    //     const formData = new FormData($("#submit-consultation")[0]);
    //     const reservationData = {
    //         customer_id: formData.get("customer"),
    //         type: formData.get("type"),
    //         texture: formData.get("texture"),
    //         hair: formData.get("hair"),
    //         treatment: formData.get("treatment"),
    //     };

    //     $.ajax({
    //         type: "POST",
    //         url: "src/api/consultations.php",
    //         data: reservationData,
    //         success: function (response) {
    //             try {
    //                 response = JSON.parse(response);
    //                 if (response.code != 200) {
    //                     $("#consultation-error").html(response.data)
    //                 } else {
    //                     $("#consultation-error").css("color", "#059669");
    //                     $("#consultation-error").html("Your consultation has been submitted. Do you wish to reserve an appointment?");
    //                     $("#submit-consultation-btn").css("display", "none");
    //                     $("#back-consultation-btn").css("display", "none");
    //                     $("#redirect-appointment").css("display", "block");
    //                     $("#back-dashboard").css("display", "block");
    //                 }
    //             } catch (error) {
    //                 $("#consultation-error").html("Something went wrong.");
    //                 console.log(error)
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.log(xhr.responseText);
    //         },
    //     });
    // });

    let confirmDeletion = false;

    $(".cancel-appointment").click(function () {
        if (!confirmDeletion) {
            confirmDeletion = true;
            $(".cancel-appointment").html("Confirm");
            $(".cancel-appointment-msg").css("font-weight", 900);
            return $(".cancel-appointment-msg").html("Are you sure you want to cancel this appointment?");
        }

        const userData = {
            id: $(".cancel-appointment").attr("data-id"),
            cancel: 1
        }

        $.ajax({
            type: "PATCH",
            url: "src/api/appointments.php",
            data: JSON.stringify(userData),
            success: function (response) {
                try {
                    console.log("RES: ", response)
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $(".cancel-appointment-msg").html(response.data)
                    } else {
                        $(".cancel-appointment-msg").css("color", "#059669");
                        $(".cancel-appointment-msg").html("Your appointment has been cancelled. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./appointments.php";
                        }, 3000);
                    }
                } catch (error) {
                    $(".cancel-appointment-msg").html("Something went wrong.");
                    console.log("ERR: ", error)
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#delete-user").click(function () {
        if (!confirmDeletion) {
            confirmDeletion = true;
            $("#delete-user").html("Confirm");
            $("#user-error").css("font-weight", 900);
            return $("#user-error").html("Are you sure you want to delete this user?");
        }

        const userData = {
            id: $("#delete-user").attr("data-id"),
            admin: true,
        };

        $.ajax({
            type: "DELETE",
            url: "src/api/users.php",
            data: JSON.stringify(userData),
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#user-error").html(response.data)
                    } else {
                        $("#user-error").css("color", "#059669");
                        $("#user-error").html("Your user has been deleted. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./users.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#user-error").html("Something went wrong.");
                    console.log(error)
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#delete-service").click(function () {
        if (!confirmDeletion) {
            confirmDeletion = true;
            $("#delete-service").html("Confirm");
            $("#service-error").css("font-weight", 900);
            return $("#service-error").html("Are you sure you want to delete this service?");
        }

        const serviceData = {
            id: $("#delete-service").attr("data-id"),
        };

        $.ajax({
            type: "DELETE",
            url: "src/api/services.php",
            data: JSON.stringify(serviceData),
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#service-error").html(response.data)
                    } else {
                        $("#service-error").css("color", "#059669");
                        $("#service-error").html("Your service has been deleted. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./admin-services.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#service-error").html("Something went wrong.");
                    console.log(error)
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#delete-treatment").click(function () {
        if (!confirmDeletion) {
            confirmDeletion = true;
            $("#delete-treatment").html("Confirm");
            $("#treatment-error").css("font-weight", 900);
            return $("#treatment-error").html("Are you sure you want to delete this treatment?");
        }

        const treatmentData = {
            id: $("#delete-treatment").attr("data-id"),
        };

        $.ajax({
            type: "DELETE",
            url: "src/api/treatments.php",
            data: JSON.stringify(treatmentData),
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#treatment-error").html(response.data)
                    } else {
                        $("#treatment-error").css("color", "#059669");
                        $("#treatment-error").html("Your treatment has been deleted. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./admin-treatments.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#treatment-error").html("Something went wrong.");
                    console.log(error)
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#delete-consultation").submit(function (event) {
        event.preventDefault();

        if (!confirmDeletion) {
            confirmDeletion = true;
            $("#delete-consultation-button").html("Confirm");
            $("#consultation-error").css("font-weight", 900);
            $("#consultation-error").css("text-transform", "uppercase");
            return $("#consultation-error").html("Are you sure you want to delete your consultation data?");
        }

        const formData = new FormData($("#delete-consultation")[0]);
        const reservationData = {
            id: formData.get("id"),
        };

        $.ajax({
            type: "DELETE",
            url: "src/api/consultations.php",
            data: JSON.stringify(reservationData),
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#consultation-error").html(response.data)
                    } else {
                        $("#consultation-error").css("color", "#059669");
                        $("#consultation-error").html("Your consultation has been deleted. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./dashboard.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#consultation-error").html("Something went wrong.");
                    console.log(error)
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    });

    $("#profile-information").submit(function (event) {
        event.preventDefault();

        const formData = new FormData($("#profile-information")[0]);
        const profileData = {
            id: formData.get("id"),
            name: formData.get("name"),
            email: formData.get("email"),
        };

        $.ajax({
            type: "PATCH",
            url: "src/api/users.php",
            data: JSON.stringify(profileData),
            success: function (response) {
                try {
                    response = JSON.parse(response);

                    if (response.code != 200) {
                        $("#profile-saved").css("display", "block");
                        $("#profile-saved").css("color", "#DC2626");
                        $("#profile-saved").html("");
                        $("#profile-saved").html(response.data);
                    } else {
                        $("#profile-saved").css("display", "block");
                        $("#profile-saved").css("color", "#059669");
                        $("#profile-saved").html("");
                        $("#profile-saved").html("Saved");
                        setTimeout(() => {
                            window.location.href = "./profile.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#profile-saved").css("display", "block");
                    $("#profile-saved").css("color", "#DC2626");
                    $("#profile-saved").html("Something went wrong.");
                }
            },
        })
    })

    $("#update-password").submit(function (event) {
        event.preventDefault();

        const formData = new FormData($("#update-password")[0]);
        if (formData.get("new-password") !== formData.get("confirm-password")) {
            $("#password-saved").css("display", "block");
            $("#password-saved").css("color", "#DC2626");
            $("#password-saved").html("");
            $("#password-saved").html("Passwords do not match");
            return;
        }

        const passwordData = {
            id: formData.get("id"),
            oldPassword: formData.get('current-password'),
            newPassword: formData.get("new-password"),
        };

        $.ajax({
            type: "PATCH",
            url: "src/api/users.php",
            data: JSON.stringify(passwordData),
            success: function (response) {
                try {
                    response = JSON.parse(response);

                    if (response.code != 200) {
                        $("#password-saved").css("display", "block");
                        $("#password-saved").css("color", "#DC2626");
                        $("#password-saved").html("");
                        $("#password-saved").html(response.data);
                    } else {
                        $("#password-saved").css("display", "block");
                        $("#password-saved").css("color", "#059669");
                        $("#password-saved").html("");
                        $("#password-saved").html("Saved");
                        setTimeout(() => {
                            window.location.href = "./profile.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#password-saved").css("display", "block");
                    $("#password-saved").css("color", "#DC2626");
                    $("#password-saved").html("Something went wrong.");
                }
            },
        })
    })

    $("#delete-account").submit(function (event) {
        event.preventDefault();

        const formData = new FormData($("#delete-account")[0]);
        const passwordData = {
            id: formData.get("id"),
            password: formData.get("delete-password"),
        };

        $.ajax({
            type: "DELETE",
            url: "src/api/users.php",
            data: JSON.stringify(passwordData),
            success: function (response) {
                try {
                    response = JSON.parse(response);

                    if (response.code != 200) {
                        $("#delete-confirm").css("display", "block");
                        $("#delete-confirm").css("color", "#DC2626");
                        $("#delete-confirm").html("");
                        $("#delete-confirm").html(response.data);
                    } else {
                        $("#delete-confirm").css("display", "block");
                        $("#delete-confirm").css("color", "#059669");
                        $("#delete-confirm").html("");
                        $("#delete-confirm").html("Deleted");
                        setTimeout(() => {
                            window.location.href = "./logout.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#delete-confirm").css("display", "block");
                    $("#delete-confirm").css("color", "#DC2626");
                    $("#delete-confirm").html("Something went wrong.");
                }
            },
        });
    });


    $('#none').change(function () {
        (this.checked) ? $('input[type="checkbox"]').not(this).prop('checked', false).prop('disabled', true) : $('input[type="checkbox"]').not(this).prop('checked', false).prop('disabled', false);
    });

    $('input[name="bleaching"]').change(function () {
        if (this.checked)
            $('input[type="radio"]').not(this).prop('checked', false);
    });

    $('input[name="perming"], input[name="rebonding"], input[name="relax"]').change(function () {
        if (this.checked) {
            if ($('input[name="bleaching"]').is(':checked')) {
                $('input[name="perming"], input[name="rebonding"], input[name="relax"]').not(this).prop('disabled', true);
                $('input[name="bleaching"]').prop('disabled', false);
            }
        }
        else {
            $('input[name="perming"], input[name="rebonding"], input[name="relax"]').not(this).prop('disabled', false);
        }
    });

    $("#menu-button").click(function () {
        if (!menuDisplayed) {
            $("#menu").css("display", "block");
            $("#menu-button").html(`<svg width = "24" height = "24" fill = "currentColor"viewBox = "0 0 24 24" xmlns = "http://www.w3.org/2000/svg" > <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41Z"></path> </svg> `)
            menuDisplayed = true;
        } else {
            $("#menu").css("display", "none");
            // $("#menu-button").css("margin-right", "-100%");
            $("#menu-button").html(`<svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M3 8V6h18v2H3Zm0 5h18v-2H3v2Zm0 5h18v-2H3v2Z" clipRule="evenodd"></path></svg>`);
            menuDisplayed = false;
        }
    });

});