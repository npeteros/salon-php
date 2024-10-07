$(document).ready(function () {

    let menuDisplayed = false;

    localStorage.getItem('theme') == 'dark' ? $('body').addClass('dark') : $('body').removeClass('dark');

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
                        $("#servicesList").append(`
                        <div class="w-full rounded-md flex justify-between p-6 bg-white dark:bg-neutral-400">
                            <div class="flex items-center gap-2">
                                <svg width="48" height="48" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M31.6718 3.20422C22.3451 -0.11135 12.2076 -0.3852 2.71558 2.42202C2.33828 2.5123 1.98304 2.67769 1.67108 2.90831C1.35911 3.13893 1.09682 3.43004 0.89985 3.76427C0.702884 4.09851 0.575287 4.469 0.524677 4.85363C0.474067 5.23827 0.501482 5.62916 0.605285 6.00297C1.1248 8.08787 1.88259 10.4833 2.79272 12.6551C2.80835 12.7059 2.83276 12.6815 2.83276 12.6307C2.70093 11.6122 3.48411 10.3261 5.0202 9.85832C12.4023 7.50895 20.3468 7.61413 27.6641 10.1581C27.934 10.2504 28.2196 10.2878 28.5042 10.2679C28.7887 10.2481 29.0664 10.1715 29.3209 10.0426C29.5754 9.91372 29.8015 9.7352 29.9859 9.51755C30.1702 9.29991 30.3092 9.04754 30.3945 8.77535C31.3046 5.84575 31.6718 3.85654 31.7626 3.35851C31.7782 3.26574 31.6962 3.23059 31.6718 3.2052V3.20422ZM9.16949 9.64935C8.05136 9.88274 6.5055 10.2499 5.34538 10.6347C3.02611 11.4344 3.13353 14.2566 4.36885 15.157C4.45967 14.6336 5.0202 13.9217 5.64518 13.6815C7.96054 12.7713 10.4468 12.2274 12.9604 12.0028C11.6831 11.4843 10.437 10.7411 9.18609 9.64837L9.16949 9.64935ZM27.6328 15.2996C24.3008 13.734 20.6887 12.8523 17.0101 12.7065C13.3315 12.5608 9.66094 13.1539 6.21547 14.451C5.11101 14.8679 4.41963 16.2117 5.11101 17.487C6.31883 19.6707 7.68954 21.7602 9.21148 23.7378C8.99274 22.98 9.37945 21.5767 10.8638 21.1178C14.9691 19.8561 19.2766 20.3912 22.1398 21.5504C22.9484 21.8756 24.0929 21.6783 24.7345 20.7174C25.8286 19.0319 26.8237 17.2842 27.7148 15.4832C27.7549 15.4021 27.7149 15.3416 27.6328 15.2996ZM20.9807 25.4165C19.7797 24.81 18.6814 24.0189 17.7259 23.0718C17.2835 22.6294 16.6322 21.9937 15.9457 21.2359C14.3783 21.2359 12.8569 21.3931 11.23 21.9127C9.71928 22.3853 9.57768 24.1304 10.2388 25.0405C11.3569 26.434 12.1411 27.1859 13.392 28.4789C14.055 29.1291 14.9452 29.4954 15.8738 29.5C16.8024 29.5045 17.6962 29.147 18.3655 28.5033C19.342 27.5268 19.9426 26.8754 21.0461 25.6245C21.1115 25.5581 21.0861 25.4419 20.9797 25.4165H20.9807Z"
                                        fill="currentColor" />
                                </svg>
                                <div class="flex flex-col gap-1">
                                    <span class="text-lg">${service.name}</span>
                                    <span class="text-sm">${service.description.length > 35 ? service.description.substring(0, 35) + '...' : service.description}</span>
                                </div>
                            </div>
                            <span class="text-[#49454F] dark:text-neutral-900">&#x20B1; ${service.price}</span>
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
                            $("#servicesList").append(`
                            <div class="w-full rounded-md flex justify-between p-6 bg-white dark:bg-neutral-400">
                                <div class="flex items-center gap-2">
                                    <svg width="48" height="48" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M31.6718 3.20422C22.3451 -0.11135 12.2076 -0.3852 2.71558 2.42202C2.33828 2.5123 1.98304 2.67769 1.67108 2.90831C1.35911 3.13893 1.09682 3.43004 0.89985 3.76427C0.702884 4.09851 0.575287 4.469 0.524677 4.85363C0.474067 5.23827 0.501482 5.62916 0.605285 6.00297C1.1248 8.08787 1.88259 10.4833 2.79272 12.6551C2.80835 12.7059 2.83276 12.6815 2.83276 12.6307C2.70093 11.6122 3.48411 10.3261 5.0202 9.85832C12.4023 7.50895 20.3468 7.61413 27.6641 10.1581C27.934 10.2504 28.2196 10.2878 28.5042 10.2679C28.7887 10.2481 29.0664 10.1715 29.3209 10.0426C29.5754 9.91372 29.8015 9.7352 29.9859 9.51755C30.1702 9.29991 30.3092 9.04754 30.3945 8.77535C31.3046 5.84575 31.6718 3.85654 31.7626 3.35851C31.7782 3.26574 31.6962 3.23059 31.6718 3.2052V3.20422ZM9.16949 9.64935C8.05136 9.88274 6.5055 10.2499 5.34538 10.6347C3.02611 11.4344 3.13353 14.2566 4.36885 15.157C4.45967 14.6336 5.0202 13.9217 5.64518 13.6815C7.96054 12.7713 10.4468 12.2274 12.9604 12.0028C11.6831 11.4843 10.437 10.7411 9.18609 9.64837L9.16949 9.64935ZM27.6328 15.2996C24.3008 13.734 20.6887 12.8523 17.0101 12.7065C13.3315 12.5608 9.66094 13.1539 6.21547 14.451C5.11101 14.8679 4.41963 16.2117 5.11101 17.487C6.31883 19.6707 7.68954 21.7602 9.21148 23.7378C8.99274 22.98 9.37945 21.5767 10.8638 21.1178C14.9691 19.8561 19.2766 20.3912 22.1398 21.5504C22.9484 21.8756 24.0929 21.6783 24.7345 20.7174C25.8286 19.0319 26.8237 17.2842 27.7148 15.4832C27.7549 15.4021 27.7149 15.3416 27.6328 15.2996ZM20.9807 25.4165C19.7797 24.81 18.6814 24.0189 17.7259 23.0718C17.2835 22.6294 16.6322 21.9937 15.9457 21.2359C14.3783 21.2359 12.8569 21.3931 11.23 21.9127C9.71928 22.3853 9.57768 24.1304 10.2388 25.0405C11.3569 26.434 12.1411 27.1859 13.392 28.4789C14.055 29.1291 14.9452 29.4954 15.8738 29.5C16.8024 29.5045 17.6962 29.147 18.3655 28.5033C19.342 27.5268 19.9426 26.8754 21.0461 25.6245C21.1115 25.5581 21.0861 25.4419 20.9797 25.4165H20.9807Z"
                                            fill="currentColor" />
                                    </svg>
                                    <div class="flex flex-col gap-1">
                                        <span class="text-lg">${service.name}</span>
                                        <span class="text-sm">${service.description.length > 35 ? service.description.substring(0, 35) + '...' : service.description}</span>
                                    </div>
                                </div>
                                <span class="text-[#49454F] dark:text-neutral-900">&#x20B1; ${service.price}</span>
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
                    console.log(toShow);

                    toShow.forEach(appointment => {
                        let color = 'neutral';

                        switch (appointment.status) {
                            case 'pending':
                                color = 'neutral';
                                break;
                            case 'confirmed':
                                color = 'sky';
                                break;
                            case 'completed':
                                color = 'green';
                                break;
                            case 'rescheduled':
                                color = 'yellow';
                                break;
                            case 'cancelled':
                            case 'no show':
                                color = 'red';
                                break;
                            default:
                                color = 'neutral';
                                break;
                        }

                        const date = appointment.schedule.split(" ")[0];

                        let dateObj = new Date(appointment.schedule);
                        let hours = dateObj.getHours();
                        let minutes = dateObj.getMinutes();
                        let ampm = hours >= 12 ? 'PM' : 'AM';
                        let formattedTime = `${hours}:${minutes < 10 ? '0' : ''}${minutes} ${ampm}`;


                        $("#appointmentsList").append(`
                        <tr>
                            <td class="flex justify-center py-2">
                                <img src="./uploads/${appointment.stylist_img}" alt="staff"
                                    class="size-8 rounded-full">
                            </td>
                            <td>${appointment.service}</td>
                            <td>${date}</td>
                            <td>${formattedTime}</td>
                            <td class="px-4 w-36">
                                <div class="bg-${color}-500 rounded-full text-white py-1">
                                    ${appointment.status.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}
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
                    console.log(response);

                    if (response.code == 200) {
                        $("#appointmentsList").empty();
                        const toShow = response.data.slice(0, 12);

                        toShow.forEach(appointment => {
                            let color = 'neutral';

                            switch (appointment.status) {
                                case 'pending':
                                    color = 'neutral';
                                    break;
                                case 'confirmed':
                                    color = 'sky';
                                    break;
                                case 'completed':
                                    color = 'green';
                                    break;
                                case 'rescheduled':
                                    color = 'yellow';
                                    break;
                                case 'cancelled':
                                case 'no show':
                                    color = 'red';
                                    break;
                                default:
                                    color = 'neutral';
                                    break;
                            }

                            const date = appointment.schedule.split(" ")[0];

                            let dateObj = new Date(appointment.schedule);
                            let hours = dateObj.getHours();
                            let minutes = dateObj.getMinutes();
                            let ampm = hours >= 12 ? 'PM' : 'AM';
                            let formattedTime = `${hours}:${minutes < 10 ? '0' : ''}${minutes} ${ampm}`;


                            $("#appointmentsList").append(`
                        <tr>
                            <td class="flex justify-center py-2">
                                <img src="./uploads/${appointment.stylist_img}" alt="staff"
                                    class="size-8 rounded-full">
                            </td>
                            <td>${appointment.service}</td>
                            <td>${date}</td>
                            <td>${formattedTime}</td>
                            <td class="px-4 w-36">
                                <div class="bg-${color}-500 rounded-full text-white py-1">
                                    ${appointment.status.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}
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

    $("#confirm-booking").submit(function (event) {
        event.preventDefault();

        $("#booking-error").html("");
        const formData = new FormData($("#confirm-booking")[0]);
        const bookingData = {
            customer_id: formData.get("customer"),
            stylist_id: formData.get("stylist"),
            service_id: formData.get("service"),
            status: 'pending',
            scheduled_date: formData.get("date") + ' ' + formData.get("time"),
        };

        $.ajax({
            type: "POST",
            url: "src/api/appointments.php",
            data: bookingData,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.code != 200) {
                        $("#booking-error").html(response.data)
                    } else {
                        $("#booking-error").removeClass("text-red-600");
                        $("#booking-error").addClass("text-green-600");
                        $("#booking-error").html("Your booking has been confirmed. Redirecting...");
                        setTimeout(() => {
                            window.location.href = "./dashboard.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#booking-error").html("Something went wrong.");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    })

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
                    console.log(response);
                    response = JSON.parse(response);
                    console.log(response);

                    if (response.code != 200) {
                        $("#profile-saved").removeClass('hidden');
                        $("#profile-saved").removeClass('text-green-600');
                        $("#profile-saved").removeClass('dark:text-green-400');
                        $("#profile-saved").addClass('text-red-600');
                        $("#profile-saved").addClass('dark:text-red-400');
                        $("#profile-saved").html("");
                        $("#profile-saved").html(response.data);
                    } else {
                        $("#profile-saved").removeClass('hidden');
                        $("#profile-saved").removeClass('text-red-600');
                        $("#profile-saved").removeClass('dark:text-red-400');
                        $("#profile-saved").addClass('text-green-600');
                        $("#profile-saved").addClass('dark:text-green-400');
                        $("#profile-saved").html("");
                        $("#profile-saved").html("Saved");
                        setTimeout(() => {
                            window.location.href = "./profile.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#profile-saved").removeClass('hidden');
                    $("#profile-saved").removeClass('text-green-600');
                    $("#profile-saved").removeClass('dark:text-green-400');
                    $("#profile-saved").addClass('text-red-600');
                    $("#profile-saved").addClass('dark:text-red-400');
                    $("#profile-saved").html("Something went wrong.");
                }
            },
        })
    })

    $("#update-password").submit(function (event) {
        event.preventDefault();

        const formData = new FormData($("#update-password")[0]);
        if (formData.get("new-password") !== formData.get("confirm-password")) {
            $("#password-saved").removeClass('hidden');
            $("#password-saved").removeClass('text-green-600');
            $("#password-saved").removeClass('dark:text-green-400');
            $("#password-saved").addClass('text-red-600');
            $("#password-saved").addClass('dark:text-red-400');
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
                        $("#password-saved").removeClass('hidden');
                        $("#password-saved").removeClass('text-green-600');
                        $("#password-saved").removeClass('dark:text-green-400');
                        $("#password-saved").addClass('text-red-600');
                        $("#password-saved").addClass('dark:text-red-400');
                        $("#password-saved").html("");
                        $("#password-saved").html(response.data);
                    } else {
                        $("#password-saved").removeClass('hidden');
                        $("#password-saved").removeClass('text-red-600');
                        $("#password-saved").removeClass('dark:text-red-400');
                        $("#password-saved").addClass('text-green-600');
                        $("#password-saved").addClass('dark:text-green-400');
                        $("#password-saved").html("");
                        $("#password-saved").html("Saved");
                        setTimeout(() => {
                            window.location.href = "./profile.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#password-saved").removeClass('hidden');
                    $("#password-saved").removeClass('text-green-600');
                    $("#password-saved").removeClass('dark:text-green-400');
                    $("#password-saved").addClass('text-red-600');
                    $("#password-saved").addClass('dark:text-red-400');
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
                    console.log(response);
                    response = JSON.parse(response);
                    console.log('safaf', response);

                    if (response.code != 200) {
                        $("#delete-confirm").removeClass('hidden');
                        $("#delete-confirm").removeClass('text-green-600');
                        $("#delete-confirm").removeClass('dark:text-green-400');
                        $("#delete-confirm").addClass('text-red-600');
                        $("#delete-confirm").addClass('dark:text-red-400');
                        $("#delete-confirm").html("");
                        $("#delete-confirm").html(response.data);
                    } else {
                        $("#delete-confirm").removeClass('hidden');
                        $("#delete-confirm").removeClass('text-red-600');
                        $("#delete-confirm").removeClass('dark:text-red-400');
                        $("#delete-confirm").addClass('text-green-600');
                        $("#delete-confirm").addClass('dark:text-green-400');
                        $("#delete-confirm").html("");
                        $("#delete-confirm").html("Saved");
                        setTimeout(() => {
                            window.location.href = "./logout.php";
                        }, 3000);
                    }
                } catch (error) {
                    $("#delete-confirm").removeClass('hidden');
                    $("#delete-confirm").removeClass('text-green-600');
                    $("#delete-confirm").removeClass('dark:text-green-400');
                    $("#delete-confirm").addClass('text-red-600');
                    $("#delete-confirm").addClass('dark:text-red-400');
                    $("#delete-confirm").html("Something went wrong.");
                }
            },
        });
    })

    $("#menu-button").click(function (e) {
        console.log('hi');
        if (!menuDisplayed) {
            $("#menu").css("display", "flex");
            $("#menu-button").html(`< svg width = "24" height = "24" fill = "currentColor"viewBox = "0 0 24 24" xmlns = "http://www.w3.org/2000/svg" > <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41Z"></path> </svg > `)
            menuDisplayed = true;
        } else {
            $("#menu").css("display", "none");
            $("#menu-button").css("margin-right", "-100%");
            menuDisplayed = false;
        }
    });

});