@extends('layouts.app')

@section('content')
    @guest
        <main class="login-form">
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <h3 class="card-header text-center">Login</h3>
                            <div class="card-body">
                                <form method="POST" action="/login">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input type="text" placeholder="Name" id="name" class="form-control"
                                            name="name" required autocomplete="false">
                                    </div>

                                    <div class="form-group mb-3">
                                        <input type="password" placeholder="Password" id="password" class="form-control"
                                            name="password" autocomplete="false" required>
                                        @if ($errors->has('namePassword'))
                                            <span class="text-danger">{{ $errors->first('namePassword') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-grid mx-auto">
                                        <button type="submit" class="btn btn-dark btn-block">Signin</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @else
        <h3>You are already logged in!</h3>
    @endguest
@endsection
