@extends('auth.layouts.master')

@section('title', 'Авторизация')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Авторизация</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" aria-label="Login">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <a href="{{route('google')}}" class="btn btn-danger btn-block">Login with Google</a>
                            <a href="{{route('facebook')}}" class="btn btn-primary btn-block">Login with Facebook</a>
                        </div>
                    </div>

                    <p style="text-align: center">OR</p>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <input id="email" type="email" class="form-control"
                                   name="email" value="" required autofocus placeholder="Email">

                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                            <input id="password" type="password" class="form-control"
                                   name="password" required placeholder="Password">

                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                Войти
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
