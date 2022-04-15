@extends('layouts.main')
@section('content')
    <div class="clearfix px-4">
        <button type="button" class="btn btn-success float-end">Add User</button>
    </div>
    <div class="row g-3 my-2">
        <div class="bg-white">
            <div class="py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="fs-4">List Users</h3>
                </div>
                <div class="input-group w-25">
                    <input type="search" class="form-control" placeholder="Search..."
                        aria-label="" aria-describedby="button-addon2">
                    <button class="btn bg-white border-start-0" style="border: 1px solid #ced4da" type="button" id="button-addon2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="col px-4">
                <table class="table bg-white rounded shadow-sm table-hover table-responsive">
                    <thead>
                        <tr class="table-secondary text-secondary">
                            <th scope="col">Name</th>
                            <th scope="col">Create Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr class="px-4">
                            <td class="d-flex align-items-center">
                                <div class="me-2">
                                    <img src="{{ asset('images/avatar.jpg') }}" class="avatar" alt="" srcset="">
                                </div>
                                <div class="me-5">
                                    <h6 class="my-0">{{ $user->firstname.' '.$user->lastname }}</h6>
                                    <p class="text-muted my-0">{{ $user->email }}</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    @foreach ($user->roles as $role)
                                    <span class="rounded-pill {{ $role->name == 'Super Admin' ? 'bg-danger' : (($role->name == 'Admin') ? 'bg-primary' : (($role->name == 'Employee') ? 'bg-secondary' : 'bg-success')) }} px-2 py-1 text-light">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($user->created_at)->format('j F, Y') }}
                            </td>
                            <td class="d-flex align-items-center">
                                <button class="btn">
                                    <i class="far fa-edit text-secondary"></i>
                                </button>

                                <button class="btn">
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
@endsection
