@extends('layouts.app')

@section('content')
<div class="login-body">
<div class="container login-modal">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-danger">
                <div class="panel-heading login-header">Login</div>

                <div class="panel-body">
                    @if(session('error'))
                        <div class="panel panel-warning">
                          <div class="panel-heading notification text-center">{{session('error')}}</div>
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}" style="margin-top: 20px">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail / Username</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link login-link" href="{{ route('password.request') }}">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="panel-footer">
                    <div class="text-center">
                    <i class="fa fa-copyright"></i> 2017 All Rights Reserved | <a href="misslabelindonesia.com">misslabelindonesia.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
