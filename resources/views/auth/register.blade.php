@extends('layouts.app')

@section('content')

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                          <div class="form-group has-feedback">
                                <input placeholder="Nombre Completo" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>

                          <div class="form-group has-feedback">
                                <input placeholder="Correo" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          <div class="form-group has-feedback">
                                <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <div class="form-group has-feedback">
                                <input placeholder="Confirmar Contraseña" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div>




                        <div class="row">
                          <div class="col-xs-8">

                          </div>
                          <!-- /.col -->
                          <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                          </div>
                          <!-- /.col -->
                        </div>

                    </form>
                </div>
@endsection
