@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel-left col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <a href="http://www.brayn.io" target="_blank">
                {{-- <img src="{{ asset('img/lemons-logo.png') }}"> --}}
            </a>
        </div>
        <div class="panel-right col-lg-6 col-md-8 col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-mail</label>

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
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Log in
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    body{
        background-color: #29363f;
        max-height: 100vh;
        width: 100vw;
    }
    .row .panel-left{
        line-height: 100vh;
    }
    .row .panel-left img{
        line-height: 1;
        margin-right: 10%;
        margin-left: 50%;
        margin-right: 10%;
    }
    .row .panel-right{
        height: 100vh;
    }
    .row .panel-right .panel{
        margin-top: calc( 55vh - 125px );
        border: 0;
        border-left: 1px solid #37444d;
        background-color: transparent;
    }
    .row .panel-right .panel .panel-body{
        line-height: 1;
        background-color: transparent;
    }
    .row .panel-right .panel .panel-body .form-control{
        border: 1.5px solid #54616a;
        background: transparent;
        color: #54616a;
    }
    .row .panel-right .panel .panel-body .form-control:active,
    .row .panel-right .panel .panel-body .form-control:focus,
    .row .panel-right .panel .panel-body .form-control:hover{
        color: rgba(255,255,255, .9);
        border: 1.5px solid #6ed9a1;
    }
    .row .panel-right .panel .panel-body .btn-primary{
        background-color: #6ed9a1;
        font-family: 'BPG ESM';
        display: block;
        color: #fff;
        outline: 0;
        width: 73%;
    }
    .row .panel-right .panel .panel-body .btn.btn-link{
        color: darkcyan;
    }
    label,
    .form-horizontal .control-label {
        font-family: 'BPG ESM';
        color: #54616a;
    }
</style>
@endsection
