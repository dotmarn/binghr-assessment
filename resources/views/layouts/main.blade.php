<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- CSS only -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="{{ asset('js/font-awesome.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    <div class="d-flex" id="wrapper">
        @include('partials.sidebar')
        <div id="page-content-wrapper">
            <div class="content">
                @include('partials.navbar')
                <div class="container-fluid px-4">
                    @yield('content')
                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript Bundle with Popper -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var wrapper = document.getElementById("wrapper");
        var sidebar = document.getElementById('sidebar-wrapper')
        var toggleButton = document.getElementById("menu-toggle");
        var adduser = document.getElementById("adduser");

        toggleButton.onclick = function() {
            wrapper.classList.toggle("toggled");
            sidebar.classList.toggle("sidebar-bg");
        };

        window.addEventListener('DOMContentLoaded', event => {
            $("#loader").hide();
        });

        adduser.addEventListener('click', event => {
            document.getElementById('openModal').click();
            $('#title').text('Add User');
            $('#action_type').val('add');
            $('#btn-submit').text('Add User');
        });

        function editUser(data) {
            document.getElementById('openModal').click();
            $('#title').text('Update User ('+data.employee_id+')');
            $('#action_type').val('update');
            $('#employee_id').val(data.id);
            $('#firstname').val(data.firstname);
            $('#lastname').val(data.lastname);
            $('#username').val(data.username);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#role').val(data.roles[0].id);
            $('#btn-submit').text('Update User');
        }

        $('#frmUser').submit(function (event) {
            event.preventDefault();
            $("#loader").show();
            if ($('#action_type').val() == 'add') {
                if ($('#password').val() == "") {
                    $('#error_password').text('Password field is required.');
                    $("#loader").hide();
                    return;
                }

                if ($('#password').val() !== $('#confirm_password').val()) {
                    $("#loader").hide();
                    swal({
                        title: 'Notification!!!',
                        text: 'Password does not match',
                        icon: 'warning'
                    });
                    return;
                }

                var payload = {
                    username: $('#username').val(),
                    firstname: $('#firstname').val(),
                    lastname: $('#lastname').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    role: $('#role').val(),
                    password: $('#password').val(),
                    action_type: $('#action_type').val()
                };

            } else {
                // For update check if password field is filled
                if ($('#password').val() != "") {
                    if ($('#password').val() !== $('#confirm_password').val()) {
                        $("#loader").hide();
                        swal({
                            title: 'Notification!!!',
                            text: 'Password does not match',
                            icon: 'warning'
                        });

                        return;
                    }
                }

                var payload = {
                    id: $('#employee_id').val(),
                    username: $('#username').val(),
                    firstname: $('#firstname').val(),
                    lastname: $('#lastname').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    role: $('#role').val(),
                    password: $('#password').val(),
                    action_type: $('#action_type').val()
                };
            }

            $.ajax({
                url: '/api/create-or-update-user',
                type: 'POST',
                dataType: "json",
                data: payload,
                success: function (data) {
                    if (data.status == 200) {
                        swal('Notification!!!', data.message, 'success').then((value) => {
                            window.location.reload();
                        });
                    }
                },
                error: function (err) {
                    $("#loader").hide();
                    if (err.status == 422) {

                        let errors = err.responseJSON.data;

                        handleValidationMessages(errors);

                    } else {
                        swal('Whoops!!!', 'Error while communicating with the server', 'warning')
                    }
                }
            });


        })

        function handleValidationMessages(errors)
        {
            if (errors.firstname) {
                $('#error_firstname').text(errors.firstname[0]);
            }

            if (errors.lastname) {
                $('#error_lastname').text(errors.lastname[0]);
            }

            if (errors.username) {
                $('#error_username').text(errors.username[0]);
            }

            if (errors.email) {
                $('#error_email').text(errors.email[0]);
            }

            if (errors.phone) {
                $('#error_phone').text(errors.phone[0]);
            }

            if (errors.role) {
                $('#error_role').text(errors.role[0]);
            }

            if (errors.password) {
                $('#error_password').text(errors.password[0]);
            }
        }

    </script>
</body>

</html>
