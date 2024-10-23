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

            console.log($("#change-role-select").val())

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

    if ($("#usersList").length) {
        $.ajax({
            type: "GET",
            url: "src/api/users.php",
            success: function (response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    $("#usersList").empty();
                    const toShow = response.data.slice(0, 12);
                    console.log(toShow);
                    toShow.forEach(user => {
                        $("#usersList").append(
                            `<div
                                style="background-color: white; display: flex; flex-direction: column; padding: 1rem; border-radius: 0.875rem; cursor: pointer;" onclick="window.location.href = './view-user.php?id=${user.id}';">
                                <div style="display: flex; justify-content: space-between;">
                                    <div style="display: flex; gap: 1rem; width: 3rem; height: 3rem;">
                                        <img src="./uploads/${user.img_path}" alt="user" style="width: 100%; border-radius: 9999px;">
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                            <span>${user.name}</span>
                                            <span style="opacity: 50%;">${user.email}</span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center;">${capitalizeFirst(user.role)}</div>
                                </div>
                            </div>`
                        );
                    });
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
                        $("#usersList").empty();
                        const toShow = response.data.slice(0, 12);
                        console.log(toShow);

                        toShow.forEach(user => {
                            $("#usersList").append(
                                `<div
                                style="background-color: white; display: flex; flex-direction: column; padding: 1rem; border-radius: 0.875rem; cursor: pointer;" onclick="window.location.href = './view-user.php?id=${user.id}';">
                                <div style="display: flex; justify-content: space-between;">
                                    <div style="display: flex; gap: 1rem; width: 3rem; height: 3rem;">
                                        <img src="./uploads/${user.img_path}" alt="user" style="width: 100%; border-radius: 9999px;">
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                            <span>${user.name}</span>
                                            <span style="opacity: 50%;">${user.email}</span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center;">${capitalizeFirst(user.role)}</div>
                                </div>
                            </div>`
                            );
                        });
                    }
                }
            });
        });
    }

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
                    $("#servicesList").empty();
                    const toShow = response.data.slice(0, 12);
                    toShow.forEach(service => {

                        const link = $("#servicesList").attr("data-userid") ? 'admin-view-service.php' : 'view-service.php';
                        $("#servicesList").append(`
                        <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: white; cursor: pointer;" onclick="window.location.href = './${link}?id=${service.id}';">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg width="48" height="48" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M31.6718 3.20422C22.3451 -0.11135 12.2076 -0.3852 2.71558 2.42202C2.33828 2.5123 1.98304 2.67769 1.67108 2.90831C1.35911 3.13893 1.09682 3.43004 0.89985 3.76427C0.702884 4.09851 0.575287 4.469 0.524677 4.85363C0.474067 5.23827 0.501482 5.62916 0.605285 6.00297C1.1248 8.08787 1.88259 10.4833 2.79272 12.6551C2.80835 12.7059 2.83276 12.6815 2.83276 12.6307C2.70093 11.6122 3.48411 10.3261 5.0202 9.85832C12.4023 7.50895 20.3468 7.61413 27.6641 10.1581C27.934 10.2504 28.2196 10.2878 28.5042 10.2679C28.7887 10.2481 29.0664 10.1715 29.3209 10.0426C29.5754 9.91372 29.8015 9.7352 29.9859 9.51755C30.1702 9.29991 30.3092 9.04754 30.3945 8.77535C31.3046 5.84575 31.6718 3.85654 31.7626 3.35851C31.7782 3.26574 31.6962 3.23059 31.6718 3.2052V3.20422ZM9.16949 9.64935C8.05136 9.88274 6.5055 10.2499 5.34538 10.6347C3.02611 11.4344 3.13353 14.2566 4.36885 15.157C4.45967 14.6336 5.0202 13.9217 5.64518 13.6815C7.96054 12.7713 10.4468 12.2274 12.9604 12.0028C11.6831 11.4843 10.437 10.7411 9.18609 9.64837L9.16949 9.64935ZM27.6328 15.2996C24.3008 13.734 20.6887 12.8523 17.0101 12.7065C13.3315 12.5608 9.66094 13.1539 6.21547 14.451C5.11101 14.8679 4.41963 16.2117 5.11101 17.487C6.31883 19.6707 7.68954 21.7602 9.21148 23.7378C8.99274 22.98 9.37945 21.5767 10.8638 21.1178C14.9691 19.8561 19.2766 20.3912 22.1398 21.5504C22.9484 21.8756 24.0929 21.6783 24.7345 20.7174C25.8286 19.0319 26.8237 17.2842 27.7148 15.4832C27.7549 15.4021 27.7149 15.3416 27.6328 15.2996ZM20.9807 25.4165C19.7797 24.81 18.6814 24.0189 17.7259 23.0718C17.2835 22.6294 16.6322 21.9937 15.9457 21.2359C14.3783 21.2359 12.8569 21.3931 11.23 21.9127C9.71928 22.3853 9.57768 24.1304 10.2388 25.0405C11.3569 26.434 12.1411 27.1859 13.392 28.4789C14.055 29.1291 14.9452 29.4954 15.8738 29.5C16.8024 29.5045 17.6962 29.147 18.3655 28.5033C19.342 27.5268 19.9426 26.8754 21.0461 25.6245C21.1115 25.5581 21.0861 25.4419 20.9797 25.4165H20.9807Z"
                                            fill="currentColor" />
                                    </svg>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 1.125rem; line-height: 1.75rem;">${service.name}</span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem;">${service.description.length > 35 ? service.description.substring(0, 35) + '...' : service.description}</span>
                                    </div>
                                </div>
                                <span style="color: #49454F;">&#x20B1; ${service.price}</span>
                        </div>`
                        );
                    });
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
                        $("#servicesList").empty();
                        const toShow = response.data.slice(0, 12);

                        toShow.forEach(service => {

                            const link = $("#servicesList").attr("data-userid") ? 'admin-view-service.php' : 'view-service.php';
                            $("#servicesList").append(`
                            <div style="border-radius: 0.375rem; display: flex; justify-content: space-between; padding: 1.5rem; background-color: white; cursor: pointer;" onclick="window.location.href = './${link}?id=${service.id}';">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg width="48" height="48" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M31.6718 3.20422C22.3451 -0.11135 12.2076 -0.3852 2.71558 2.42202C2.33828 2.5123 1.98304 2.67769 1.67108 2.90831C1.35911 3.13893 1.09682 3.43004 0.89985 3.76427C0.702884 4.09851 0.575287 4.469 0.524677 4.85363C0.474067 5.23827 0.501482 5.62916 0.605285 6.00297C1.1248 8.08787 1.88259 10.4833 2.79272 12.6551C2.80835 12.7059 2.83276 12.6815 2.83276 12.6307C2.70093 11.6122 3.48411 10.3261 5.0202 9.85832C12.4023 7.50895 20.3468 7.61413 27.6641 10.1581C27.934 10.2504 28.2196 10.2878 28.5042 10.2679C28.7887 10.2481 29.0664 10.1715 29.3209 10.0426C29.5754 9.91372 29.8015 9.7352 29.9859 9.51755C30.1702 9.29991 30.3092 9.04754 30.3945 8.77535C31.3046 5.84575 31.6718 3.85654 31.7626 3.35851C31.7782 3.26574 31.6962 3.23059 31.6718 3.2052V3.20422ZM9.16949 9.64935C8.05136 9.88274 6.5055 10.2499 5.34538 10.6347C3.02611 11.4344 3.13353 14.2566 4.36885 15.157C4.45967 14.6336 5.0202 13.9217 5.64518 13.6815C7.96054 12.7713 10.4468 12.2274 12.9604 12.0028C11.6831 11.4843 10.437 10.7411 9.18609 9.64837L9.16949 9.64935ZM27.6328 15.2996C24.3008 13.734 20.6887 12.8523 17.0101 12.7065C13.3315 12.5608 9.66094 13.1539 6.21547 14.451C5.11101 14.8679 4.41963 16.2117 5.11101 17.487C6.31883 19.6707 7.68954 21.7602 9.21148 23.7378C8.99274 22.98 9.37945 21.5767 10.8638 21.1178C14.9691 19.8561 19.2766 20.3912 22.1398 21.5504C22.9484 21.8756 24.0929 21.6783 24.7345 20.7174C25.8286 19.0319 26.8237 17.2842 27.7148 15.4832C27.7549 15.4021 27.7149 15.3416 27.6328 15.2996ZM20.9807 25.4165C19.7797 24.81 18.6814 24.0189 17.7259 23.0718C17.2835 22.6294 16.6322 21.9937 15.9457 21.2359C14.3783 21.2359 12.8569 21.3931 11.23 21.9127C9.71928 22.3853 9.57768 24.1304 10.2388 25.0405C11.3569 26.434 12.1411 27.1859 13.392 28.4789C14.055 29.1291 14.9452 29.4954 15.8738 29.5C16.8024 29.5045 17.6962 29.147 18.3655 28.5033C19.342 27.5268 19.9426 26.8754 21.0461 25.6245C21.1115 25.5581 21.0861 25.4419 20.9797 25.4165H20.9807Z"
                                            fill="currentColor" />
                                    </svg>
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <span style="font-size: 1.125rem; line-height: 1.75rem;">${service.name}</span>
                                        <span style="font-size: 0.875rem; line-height: 1.25rem;">${service.description.length > 35 ? service.description.substring(0, 35) + '...' : service.description}</span>
                                    </div>
                                </div>
                                <span style="color: #49454F;">&#x20B1; ${service.price}</span>
                            </div>`
                            );
                        });
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
                    $("#appointmentsList").empty();
                    const toShow = response.data.slice(0, 12);

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
                        $("#appointmentsList").empty();
                        const toShow = response.data.slice(0, 12);

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

    $("#edit-service").submit(function (event) {
        event.preventDefault();

        const formData = new FormData($("#edit-service")[0]);
        const serviceData = {
            id: formData.get("id"),
            name: formData.get("name"),
            price: formData.get("price"),
            duration: formData.get("duration"),
            followup_duration: formData.get("followup_duration"),
            description: formData.get("description"),
        };

        $.ajax({
            type: "PATCH",
            url: "src/api/services.php",
            data: JSON.stringify(serviceData),
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                if (response.code != 200) {
                    $("#service-error").html(response.data)
                } else {
                    $("#service-error").css("color", "#059669");
                    $("#service-error").html("The service has been updated. Redirecting...");
                    setTimeout(() => {
                        window.location.href = `./admin-view-service.php?id=${serviceData.id}`;
                    }, 3000);
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
        const serviceData = {
            name: formData.get("name"),
            price: formData.get("price"),
            duration: formData.get("duration    "),
            followup_duration: formData.get("followup_duration"),
            description: formData.get("description"),
        };

        $.ajax({
            type: "POST",
            url: "src/api/services.php",
            data: serviceData,
            success: function (response) {
                try {
                    console.log(response);
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#service-error").html(response.data)
                    } else {
                        $("#service-error").css("color", "#059669");
                        $("#service-error").html("Your service has been added. Redirecting...");
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
                    if (response.code != 200) {
                        $("#reservation-error").html(response.data)
                    } else {
                        $("#reservation-error").css("color", "#059669");
                        $("#reservation-error").html("Your reservation has been confirmed. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./dashboard.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#reservation-error").html("Something went wrong.");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

    $("#submit-consultation").submit(function (event) {
        event.preventDefault();

        $("#consultation-error").html("");
        const formData = new FormData($("#submit-consultation")[0]);
        const reservationData = {
            customer_id: formData.get("customer"),
            type: formData.get("type"),
            texture: formData.get("texture"),
            hair: formData.get("hair"),
            perming: formData.get("perming"),
            relax: formData.get("relax"),
            rebonding: formData.get("rebonding"),
            bleaching: formData.get("bleaching"),
        };

        $.ajax({
            type: "POST",
            url: "src/api/consultations.php",
            data: reservationData,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#consultation-error").html(response.data)
                    } else {
                        $("#consultation-error").css("color", "#059669");
                        $("#consultation-error").html("Your consultation has been submitted. Redirecting...");
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
            },
        });
    });

    let confirmDeletion = false;

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
        (this.checked) ? $('input[type="radio"]').prop('checked', false).prop('disabled', true) : $('input[type="radio"]').not(this).prop('checked', false).prop('disabled', false);
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
            $("#menu").css("display", "flex");
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