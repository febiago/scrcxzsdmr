@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register.create') }}">
                @csrf

                <div class="row">
                <div class="form-group col-12">
                    <label for="name">Nama</label>
                    <input id="name" value="{{ old('name') }}" type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group col-12">
                    <label for="username">Username</label>
                    <input id="username" value="{{ old('username') }}" type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group col-12">
                    <label for="password"
                        class="d-block">Password</label>
                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                    <div id="pwindicator"
                        class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="password2"
                        class="d-block">Password Confirmation</label>
                    <input id="password2"
                        type="password"
                        class="form-control"
                        name="password-confirm">
                </div>

                <div class="form-group col-12">
                        <label>Role</label>
                        <select id='role' name='role' class="form-control selectric">
                            <option>admin</option>
                            <option>operator</option>
                        </select>
                    </div>

                <div class="form-group col-12">
                    <button type="submit"
                        class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
