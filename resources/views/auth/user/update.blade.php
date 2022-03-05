@extends('layouts.custom')

@section('content')
    <section id="member_register" class="top">
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
                            <div class="main-title">会員 個別登録</div>
                            <form method="POST" action="{{ route('userUpdatePost', ['user_id' => $data[0]->user_id]) }}">
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
                                                <input id="user_no" type="text" name="user_no" value="{{ $data[0]->id }}" readonly="readonly" required>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>ID</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                            <input id="rand_id" type="text" name="user_id" value="{{ $data[0]->user_id }}" readonly="readonly" required>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>PW<span>必須</span></div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input id="password" type="password" name="password" value="*********" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-register-wrap">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>会員企業/団体名</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="company_name" value="{{ $data[0]->company_name }}" placeholder="愛知旅行株式会社"><br>
                                                <p>※ 一部旧字体はご利用いただけない場合がございます。<br>
                                                    該当の文字を別の文字に置き換えてご入力ください。 例）﨑→崎、髙→高、栁→柳、など</p>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>会員企業/団体名<br>
                                                    フリガナ</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="furi_company_name" value="{{ $data[0]->furi_company_name }}" placeholder="アイチリョコウカブシキガイシャ"><br>
                                                <p>※ 全角カタカナ</p>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>部署名</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="department_name" value="{{ $data[0]->department_name }}" placeholder="広報部">
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>役職</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="job_title" value="{{ $data[0]->job_title }}" placeholder="係長">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-register-wrap admin-main-register">
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>氏名<span>必須</span></div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="name" placeholder="愛知　太郎" value="{{ $data[0]->name }}" required><br>
                                                <p>※ 一部旧字体はご利用いただけない場合がございます。 <br>
                                                該当の文字を別の文字に置き換えてご入力ください。 例）﨑→崎、髙→高、栁→柳、など</p>
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
                                                <div>メールアドレス</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <div class="admin-register-item-right-email">
                                                    <input type="text" name="email" value="{{ $data[0]->email }}" placeholder="xxx.xxx">
                                                </div>
                                                <p>※ 半角英数</p>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>メールアドレス<br>再入力</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <div class="admin-register-item-right-email">
                                                    <input type="text" name="email_confirm" value="{{ $data[0]->email_confirm }}" placeholder="xxx.xxx">
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
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>郵便番号</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <div class="admin-register-item-right-postal">
                                                    <input type="text" name="zipcode" value="{{ $data[0]->zipcode }}" placeholder="999-999-9999"><a href="" class="admin-postal-search-btn btn-common">住所検索</a>
                                                </div>
                                                <p>※ ハイフンなし、半角数字</p>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>住所1</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <select name="address1" id="address1">
                                                    <option value="">県を選択</option>
                                                    <option value="県を選択1">県を選択1</option>
                                                    <option value="県を選択2">県を選択2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>住所2<br>
                                                    市町村</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="address2" value="{{ $data[0]->address2 }}" placeholder="999-999-9999">
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>住所3</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="address3" value="{{ $data[0]->address3 }}" placeholder="999-999-9999">
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>住所4<br>
                                                    建物名や階数</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <input type="text" name="address4" value="{{ $data[0]->address4 }}" placeholder="999-999-9999">
                                            </div>
                                        </div>
                                        <div class="admin-register-item">
                                            <div class="admin-register-item-left">
                                                <div>業種</div>
                                            </div>
                                            <div class="admin-register-item-right">
                                                <select name="sectors" id="sectors" class="admin-register-item-right-select">
                                                    <option value="">業種を選択</option>
                                                    <option value="業種を選択1">業種を選択1</option>
                                                    <option value="業種を選択2">業種を選択2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-register-btn-group">
                                    <button type="submit" class="admin-register-btn btn-primary">新規登録・修正　確認画面へ</button>
                                    <a href="{{ route('userDelete', ['user_id' => $data[0]->user_id]) }}" class="admin-delete-btn btn-danger">登録を削除</a>
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
            document.getElementById("address1").value = "{{ $data[0]->address1 }}";
            document.getElementById("sectors").value = "{{ $data[0]->sectors }}";
            $('#userManage').addClass('active');
            $('#adminHome').removeClass('active');
            $('#adminManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop