@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-header">
                    <img class="login-logo" src="{{asset('img/logo.png')}}" alt="">
                    <h1>Добро пожаловать</h1>
                    <p>Чтобы войти, введите email и пароль</p>
                </div>
                <div class="login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input id="email" type="email" class="mb-4 form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="Введите логин">
                        @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               required autocomplete="current-password" placeholder="Введите пароль">
                        @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <button class="btn login_btn" type="submit">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
