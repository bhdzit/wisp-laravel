@extends('layouts.app')

@section('content')

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group has-feedback">
                          <input placeholder="Correo" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group has-feedback">
                              <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                              <div class="col-xs-8">
                                <div class="checkbox icheck">
                                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                  <label class="form-check-label" for="remember">
                                      {{ __('Mantener la sesión iniciada') }}
                                  </label>
                                </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                  {{ __('Login') }}
                              </button>
                              </div>
                              <!-- /.col -->
                            </div>



                    </form>

                                              @if (Route::has('password.request'))
                                                  <a class="text-center" href="{{ route('password.request') }}">
                                                      {{ __('¿Olvidó la contraseña?') }}
                                                  </a><br>
                                              @endif
                                              <a  class="text-center" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
@endsection
