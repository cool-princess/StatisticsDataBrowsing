@extends('layouts.custom')

@section('content')
    <section id="login">
        <div class="container">
            <div class="login-wrap">
                <div class="login-title">
                    <h1>ジブリパークチケット購入者<br>
                        統計データ提供サイト
                    </h1>
                </div>
                @if ($error = $errors->first('user_id'))
                    <div class="invalid-feedback">
                        {{ $error }}
                    </div>
                @endif
                <div class="login-form">
                    <form method="POST" action="{{ route('userLoginPost') }}">
                        @csrf
                        <div class="login-item">
                            <div class="login-item-label">
                                ログインID：
                            </div>
                            <div class="login-item-input">
                                <input type="text" name="user_id" required autocomplete="user_id">
                            </div>
                        </div>
                        <div class="login-item">
                            <div class="login-item-label">
                                パスワード：
                            </div>
                            <div class="login-item-input">
                                <input type="password" name="password" required autocomplete="current-password">
                            </div>
                        </div>
                        <label class="login-save" for="remember_me">
                            ログインID・パスワードを保持する<input type="checkbox" id="remember_me" name="remember">
                            <span class="checkmark"></span>
                        </label>
                        <a href="#forgot-modal" class="login-info-forgot">ID・パスワードを忘れた方はこちら</a>
                        <button type="submit" class="login-btn">
                            ログイン
                        </button>
                    </form>
                </div>
            </div>
            <div id="forgot-modal" class="modal">
                <div class="modal-content">
                    <h1>ログインID・パスワードを忘れた方</h1>
                    <p>
                        登録されている担当者様より、<br>
                        以下の事項を記入の上、メールにてお問合せください。<br>
                        後日、返信メールで連絡いたします。<br><br>
                        ・メールタイトル<br>
                        　ジブリパークチケット購入者統計データ提供サイト　ID・PW問合せ<br><br>
                        ・メール本文<br>
                        　登録会社名：<br>
                        　担当者名：<br>
                        　連絡先電話番号：<br>
                        　連絡先メールアドレス：<br>
                        ・連絡先<br>
                        愛知県観光コンベンション局観光振興課<br>
                        企画グループ<br>
                        <a href="kanko@pref.aichi.lg.jp">kanko@pref.aichi.lg.jp</a>
                    </p>
                    <a href="#" class="modal-close">&times;</a>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("click", function(event) {
                if (event.target.matches(".login-info-forgot")) {
                    document.querySelector(".modal").style.visibility = "visible";
                    document.querySelector(".modal").style.opacity = "1";
                }
                // If user either clicks X button OR clicks outside the modal window, then close modal by calling closeModal()
                else if (event.target.matches(".modal-close") || !event.target.closest(".modal-content")) {
                    closeModal();
                }
            },
                false
        )

        function closeModal() {
            document.querySelector(".modal").style.visibility = "hidden";
            document.querySelector(".modal").style.opacity = "0";
        }
    </script>
@stop