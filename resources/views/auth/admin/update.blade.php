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
                            <form method="POST" action="{{ route('adminUpdatePost', ['admin_id' => $data[0]->admin_id]) }}">
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
                                                @if($data[0]->break == 1)
                                                    <input type="radio" id="break-on" name="break" value="1" checked><label for="break-on">ON</label>
                                                    <input type="radio" id="break-off" name="break" value="0"><label for="break-off">OFF</label>
                                                @else
                                                    <input type="radio" id="break-on" name="break" value="1"><label for="break-on">ON</label>
                                                    <input type="radio" id="break-off" name="break" value="0" checked><label for="break-off">OFF</label>
                                                @endif
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
                                                <input id="admin_no" type="text" name="admin_no" value="{{ $data[0]->id }}" readonly="readonly" required>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>ID</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input id="rand_id" type="text" name="admin_id" value="{{ $data[0]->admin_id }}" readonly="readonly" required>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>PW</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input id="registerPassword" type="password" name="password" value="{{ $data[0]->pwd_store }}">
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
                                                <input type="text" name="department_name" value="{{ $data[0]->department_name }}" placeholder="事業局　ジブリパーク部">
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>役職</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="job_title" value="{{ $data[0]->job_title }}" placeholder="部次長">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-register-wrap admin-main-register">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>氏名<span>必須</span></div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="name" value="{{ $data[0]->name }}" placeholder="愛知　太郎" required><br>
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
                                                <input type="text" name="furi_name" value="{{ $data[0]->furi_name }}" placeholder="アイチ　タロウ"><br>
                                                <p>※ 全角カタカナ</p>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>メールアドレス<span>必須</span></div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <div class="admin-register-item-right-email">
                                                    <input type="text" name="email" value="{{ $data[0]->email }}" placeholder="xxx.xxx">
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
                                                    <input type="text" name="email_confirm" value="{{ $data[0]->email }}" placeholder="xxx.xxx">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>電話番号</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="tel" name="phone" value="{{ $data[0]->phone }}" placeholder="999-999-9999"><br>
                                                <p>※ 半角</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-register-btn-group">
                                    <button type="submit" class="admin-register-btn btn-primary">新規登録・修正　確認画面へ</button>
                                    <a href="{{ route('adminDelete', ['admin_id' => $data[0]->admin_id]) }}" class="admin-delete-btn btn-danger">登録を削除</a>
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