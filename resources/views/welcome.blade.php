@extends('layouts.main')
@section('content')
    <div class="clearfix px-4">
        <button type="button" class="btn btn-success float-end" id="adduser">
            Add User
        </button>
    </div>
    <div class="row g-3 my-2">
        <div class="bg-white">
            <div class="py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="fs-4">List Users</h3>
                </div>
                <div class="input-group w-25">
                    <input type="search" class="form-control" placeholder="Search..." aria-label=""
                        aria-describedby="button-addon2">
                    <button class="btn bg-white border-start-0" style="border: 1px solid #ced4da" type="button"
                        id="button-addon2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="col px-4">
                <div class="table-responsive">
                    <table class="table bg-white rounded shadow-sm">
                        <thead>
                            <tr class="table-secondary text-secondary">
                                <th scope="col" class="px-4">Name</th>
                                <th scope="col">Create Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="px-4">
                                    <td class="d-flex align-items-center">
                                        <div class="me-2 px-4">
                                            <img src="{{ asset('images/avatar.jpg') }}" class="avatar" alt=""
                                                srcset="">
                                        </div>
                                        <div class="me-5">
                                            <h6 class="my-0">{{ $user->firstname . ' ' . $user->lastname }}</h6>
                                            <p class="text-muted my-0">{{ $user->email }}</p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            @foreach ($user->roles as $role)
                                                <span
                                                    class="rounded-pill {{ $role->name == 'Super Admin'? 'bg-danger': ($role->name == 'Admin'? 'bg-primary': ($role->name == 'Employee'? 'bg-secondary': 'bg-success')) }} px-2 py-1 text-light">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('j F, Y') }}
                                        </div>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <button class="btn" onclick='editUser(<?php echo json_encode($user); ?>)'>
                                            <i class="far fa-edit text-secondary"></i>
                                        </button>

                                        <button class="btn" onclick='deleteUser(<?php echo json_encode($user); ?>)'>
                                            <i class="fas fa-trash text-secondary"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button type="hidden" id="openModal" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modal"
        style="display: none">
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmUser">
                        <input type="hidden" name="action_type" id="action_type" value="">
                        <input type="hidden" name="employee_id" id="employee_id" value="">
                        <div class="row mb-4">
                            <div class="col">
                                <input type="text" name="firstname" id="firstname" class="form-control"
                                    placeholder="First name" aria-label="First name">
                                    <p class="text-danger" id="error_firstname"></p>
                            </div>
                            <div class="col">
                                <input type="text" name="lastname" id="lastname" class="form-control"
                                    placeholder="Last name" aria-label="Last name">
                                    <p class="text-danger" id="error_lastname"></p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email ID*"
                                    aria-label="Email ID*">
                                    <p class="text-danger" id="error_email"></p>
                            </div>
                            <div class="col">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"
                                    aria-label="Phone">
                                    <p class="text-danger" id="error_phone"></p>
                            </div>
                            <div class="col">
                                <select name="role" id="role" class="form-select">
                                    <option selected>Select Role Type</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger" id="error_role"></p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="Username*" aria-label="Username*">
                                    <p class="text-danger" id="error_username"></p>
                            </div>
                            <div class="col">
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Password" aria-label="Password">
                                    <p class="text-danger" id="error_password"></p>
                            </div>
                            <div class="col">
                                <input type="password" name="password_confirmation" id="confirm_password"
                                    class="form-control" placeholder="Confirm Password" aria-label="Confirm Password">
                            </div>
                        </div>
                        <div class="clearfix float-end">
                            <button type="submit" class="btn btn-primary"><span id="btn-submit"></span> <span id="loader"><i class="fas fa-spinner fa-spin"></i></span></button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Ends Here --}}
@endsection
