@extends('layouts.app')

@section('content')
<div class="auth-area">
    <a href="/"><img src="/images/vx.png" class="auth-logo" /></a>
    <div class="panel panel-default">
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>


            @else

            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <p>Enter your e-mail to reset your password:</p>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="button button-primary button-full">
                            Send Password Reset Link
                        </button>
                    </div>
                </div>
            </form>

            @endif
        </div>
    </div>
</div>
@endsection
