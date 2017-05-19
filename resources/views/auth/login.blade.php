@extends('layouts.app')

@section('content')
<div class="auth-area">
    <a href="/"><img src="/images/vx.png" class="auth-logo" /></a>
    <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Username">

                        @if ($errors->has('name'))
                            <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="">
                        <input type="password" class="form-control" name="password" placeholder="Password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="button button-full">
                    <i class="icon ion-log-in"></i>Login
                </button>

                {{--<div class="login-helper" style="margin-bottom: 0.375rem">--}}
                {{--Not registered? <a href="/register">Create an account</a>--}}
                {{--</div>--}}

                <div class="login-helper">
                    <div class="nomargin text-center">Need an account? <a href="/register">Register here</a></div>
                </div>

                <div class="login-helper">
                    Forgot your password? <a href="{{ url('/password/reset') }}">Click here to reset</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
