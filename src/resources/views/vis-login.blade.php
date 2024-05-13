@extends('admin::layouts.vis-login')

@section('main')

    <div id="main" role="main" style="background-image: url({{config('builder.login.background_url')}});">
        <div id="content" class="container">

                <div class="b-login col-xs-12 col-sm-12 col-md-5 col-lg-4 " style="float: right;">

                    <div class="b-bottom">
                       {{config('builder.login.bottom_block')}}
                    </div>

                    <div class="well no-padding">

                        @if (Session::has('login_not_found'))
                            <div class="alert alert-danger fade in">
                                {{Session::get('login_not_found')}}
                            </div>
                        @endif

                        <form method="post"action="{{route('login')}}" name="repawning" class="smart-form client-form">
                            {{ csrf_field() }}

                            <header>
                                {{__cms('Войти')}}
                            </header>
    
                            <fieldset>
                                
                                <section>
                                    <label class="label">{{(__cms('Эл.почта'))}}</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input type="email" name="email" email_required = "{{__cms('Введите адрес эл.почты')}}" email_email = "{{__cms('Введите валидный адрес эл.почты')}}">
                                       </label>
                                </section>
    
                                <section>
                                    <label class="label">{{__cms('Пароль')}}</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="password" password_required = "{{__cms('Введите пароль')}}" autocomplete="off">
                                        </label>
                                </section>
                                
                                @if (config('builder::login.is_active_remember_me'))
                                    <section>
                                        <label class="checkbox">
                                            <input type="checkbox" name="remember" checked="checked">
                                            <i></i>{{__cms('Запомнить меня')}}</label>
                                    </section>
                                @endif
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary submit_button">
                                    {{__cms('Войти')}}
                                </button>
                            </footer>
                      </form>
    
                    </div>
                        
                </div>

        </div>
    </div>


@stop

