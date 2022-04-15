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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}" />
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
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
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
            $('.datatable').DataTable({
                sorting:false,
                lengthChange: false,
                searching:false
            });
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
            $('#btn-submit').text('Update User');
            console.log(data);
        }

        $('#frmUser').submit(function (event) {
            event.preventDefault();
            $("#loader").show();
            if ($('#action_type').val() == 'add') {
                if ($('#password').val() == "") {
                    $('#error_password').text('Password field is required.');
                    $("#loader").hide();
                }

                if ($('#password').val() !== $('#confirm_password').val()) {
                    $("#loader").hide();
                    swal({
                        title: 'Notification!!!',
                        text: 'Password does not match',
                        icon: 'warning'
                    });
                }

                let payload = {
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
                    }
                }

                let payload = {
                    employee_id: $('#employee_id').val(),
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

                    } else if (data.status == 422) {
                        console.log(data.data);
                    } else {
                        swal({
                            title: 'Notification!!!',
                            text: data.message,
                            icon: 'warning'
                        })
                    }
                },
                error: function (err) {
                    swal('Whoops!!!', 'Error while communicating with the server', 'warning')
                }
            });
        })

    </script>
</body>

</html>
