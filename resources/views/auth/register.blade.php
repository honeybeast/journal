@extends('master')
@section('content')
    @php
        if (!empty($_GET['user_id']) && !empty($_GET['email_type'])) {
            $user_id = $_GET['user_id'];
            $email_type = $_GET['email_type'];
            if (!empty($_GET['status']) && !empty($_GET['id'])) {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type,'status='.$_GET['status'],'id='.$_GET['id']]);
            } elseif (!empty($_GET['status'])) {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type,'status='.$_GET['status']]);
            } elseif (!empty($_GET['invoice_id'])) {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type,'invoice_id='.$_GET['invoice_id']]);
            } else {
                $action = route('login',['user_id='.$user_id,'email_type='.$email_type]);
            }
        }else{
            $action = route('login');
        }
        $reg_data = App\SiteManagement::getMetaValue('reg_data');
        $login_focus = '';
        $register_focus = '';
        if (!empty($_GET['type'])) {
            if ($_GET['type'] == 'login') {
                $login_focus = 'autofocus';
            } elseif ($_GET['type'] == 'register') {
                $register_focus = 'autofocus';
            }
        }
    @endphp
    <div id="sj-twocolumns" class="sj-twocolumns">
        <div class="container">
            <div class="row" id="user_register">
                @if (Session::has('message'))
                    <div class="toast-holder">
                        <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
                    </div>
                @elseif (Session::has('error'))
                    <div class="toast-holder">
                        <flash_messages :message="'{{{ Session::get('error') }}}'" :message_class="'danger'" v-cloak></flash_messages>
                    </div>
                @endif
                <div class="provider-site-wrap" v-show="loading" v-cloak><div class="provider-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                    <aside id="sj-sidebarvtwo" class="sj-sidebar">
                        <div class="sj-widget sj-widgetlogin">
                            <div class="sj-widgetheading">
                                <h3>{{trans('prs.login_now')}}</h3>
                            </div>
                            <div class="sj-widgetcontent">
                                <form method="POST" action="{{$action}}" class="sj-formtheme sj-formlogin">
                                    @csrf
                                    <fieldset>
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{$errors->has('email') ? old('email') : ''}}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            placeholder="{{trans('prs.ph_email')}}" {{$login_focus}}>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{$errors->first('email')}}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{trans('prs.ph_pass')}}">
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{$errors->first('password')}}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group sj-forgotpass">
                                            <div class="sj-checkbox">
                                                <input type="checkbox" id="remember" name="remember">
                                                <label for="remember">{{trans('prs.keep_logged_in')}}</label>
                                            </div>
                                            <a class="sj-forgorpass" href="{{ route('password.request') }}">{{trans('prs.forgot_pass')}}</a>
                                        </div>
                                        <div class="sj-btnarea">
                                            <button type="submit" class="sj-btn sj-btnactive">{{trans('prs.btn_login')}}</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                    <div id="sj-content" class="sj-content">
                        <div class="sj-registerarea">
                            <div class="registernow">
                                <div class="sj-widgetheading">
                                    <h3>{{trans('prs.reg_now')}}</h3>
                                </div>
                                <div class="sj-registerformholder">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <form method="POST" action="{{ route('register') }}" class="sj-formtheme sj-formregister" id="register_form" @submit="showloading()">
                                                @csrf
                                                <fieldset>
                                                    <div class="form-group">
                                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}"
                                                        placeholder="{{trans('prs.ph_firstname')}}" required {{$register_focus}}>
                                                        @if ($errors->has('name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="sur_name" value="{{ old('sur_name') }}" class="form-control{{ $errors->has('sur_name') ? 'is-invalid' : '' }}"
                                                        placeholder="{{trans('prs.ph_surname')}}*" required>
                                                        @if ($errors->has('sur_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('sur_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="email" type="email" class="form-control {{ $errors->register->first('email') ? ' is-invalid' : '' }}"  name="email"
                                                        value="{{$errors->register->first('email') ? old('email') : ''}}" placeholder="{{trans('prs.ph_email')}}" required>
                                                        @if ($errors->register->first('email'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{$errors->register->first('email')}}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="password" type="password" class="form-control{{ $errors->register->first('password') ? ' is-invalid' : '' }}" name="password"
                                                        placeholder="{{trans('prs.ph_pass')}}" required>
                                                        @if ($errors->register->first('password'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{$errors->register->first('password')}}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('prs.ph_cnfrm_pass')}}" required>
                                                    </div>
                                                    <div class="form-group half-width assign-role">
                                                        <span class="sj-radio">
                                                            <input id="author" checked="checked" name="role" type="radio" value="author">
                                                            <label for="author">{{trans('prs.author')}}</label>
                                                        </span>
                                                    </div>
                                                    <div class="form-group half-width assign-role">
                                                        <span class="sj-radio">
                                                            <input id="reader" name="role" type="radio" value="reader">
                                                            <label for="reader">{{trans('prs.reader')}}</label>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="sj-checkbox">
                                                            <input type="checkbox" id="terms_condition" name="terms_condition" class="form-control{{ $errors->register->first('terms_condition') ? ' is-invalid' : '' }}" value="registered">
                                                            <label for="terms_condition">{{trans('prs.terms_note')}} <a href="javascript:void(0);">{{trans('prs.terms_conditions')}}</a></label>
                                                            @if ($errors->register->first('terms_condition'))
                                                                <span class="invalid-feedback invalid-checkbox invalid-terms" role="alert">
                                                                    <strong>{{$errors->register->first('terms_condition')}}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="sj-btnarea">
                                                        <button type="submit" class="sj-btn sj-btnactive">{{trans('prs.btn_reg') }}</button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                        @if (!empty($reg_data))
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="sj-howtoregister">
                                                    @foreach ($reg_data as $key => $value)
                                                        <h3>{{$value['title']}}</h3>
                                                        <div class="sj-description">
                                                            @php echo htmlspecialchars_decode(stripslashes($value['desc'])); @endphp
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
