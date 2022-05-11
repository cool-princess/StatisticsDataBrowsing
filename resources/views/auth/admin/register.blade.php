@extends('layouts.custom')

@section('content')
    <section id="admin_register" class="top">
        <div class="container">
            <div class="header">
                @include('includes.header')
            </div>
            <div class="wrap">
                <div class="wrapper active">
                    <div class="navbar-main">
                        @include('includes.navbar')
                    </div>
                    <div class="mainbar">
                        <div class="main-body">
                            <div class="main-title">管理者 登録</div>
                            <form method="POST" action="{{ route('adminRegisterPost') }}">
                                @csrf
                                <div class="admin-register-part">
                                    <div class="admin-register-wrap">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>
                                                    休止<span>必須</span>
                                                </div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="radio" id="break-on" name="break" value="1" checked><label for="break-on">ON</label>
                                                <input type="radio" id="break-off" name="break" value="0"><label for="break-off">OFF</label>
                                                <p>※休止の場合はOFFを選択</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-register-wrap">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>
                                                    No
                                                </div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                {{ $admin_no }}
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>ID</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input id="rand_id" type="text" name="admin_id" value="GD9<?php echo str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT); ?>" readonly="readonly" required>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>PW</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="password" id="registerPassword" name="password" value="<?php echo substr(md5(mt_rand()), 0, 8); ?>" autocomplete="new-password" readonly="readonly">
                                                <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-register-wrap">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>部署名</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="department_name" placeholder="事業局　ジブリパーク部">
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>役職</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="job_title" placeholder="部次長">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-register-wrap admin-main-register">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>氏名<span>必須</span></div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="name" placeholder="愛知　太郎" :value="old('name')"><br>
                                                <p>※ 一部旧字体はご利用いただけない場合がございます。 <br>
                                                該当の文字を別の文字に置き換えてご入力ください。 例）﨑→崎、髙→高、栁→柳、など</p>
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>氏名フリガナ</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="furi_name" placeholder="アイチ　タロウ"><br>
                                                <p>※ 全角カタカナ</p>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>メールアドレス<span>必須</span></div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <div class="admin-register-item-right-email">
                                                    <input type="text" name="email" placeholder="xxx@xxx.xxx" required>
                                                </div>
                                                <p>※ 半角英数</p>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>メールアドレス<br>再入力</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <div class="admin-register-item-right-email">
                                                    <input type="text" name="email_confirm" placeholder="xxx@xxx.xxx">
                                                </div>
                                                @if ($errors->has('email_confirm'))
                                                    <span class="invalid-feedback">{{ $errors->first('email_confirm') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>電話番号</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="tel" name="phone" placeholder="999-999-9999"><br>
                                                <p>※ 半角</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-register-btn-group">
                                    <button type="submit" class="admin-register-btn btn-primary">新規登録・修正</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                @include('includes.footer')
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#adminManage').addClass('active');
            $('#adminHome').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#registerPassword');
            if(togglePassword) {
                togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
@stop