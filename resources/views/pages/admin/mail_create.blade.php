@extends('layouts.custom')

@section('content')
    <section id="mail_create" class="top">
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
                        <form method="POST" action="{{route('mailSendPost')}}">
                            @csrf
                            <div class="main-body">
                                <div class="main-title">メール作成</div>
                                <div class="mail-create-part">
                                    <div class="mail-content-title">
                                        内容
                                    </div>
                                    <div class="mail-content-body">
                                        <div class="mail-content-item">
                                            <div class="mail-content-item-left">
                                                No
                                            </div>
                                            <div class="mail-content-item-right">
                                                {{ $mail_count }}
                                            </div>
                                        </div>
                                        <input type="text" required name="from" value="{{getenv('MAIL_FROM_ADDRESS')}}" style="display: none;">
                                        <div class="mail-content-item">
                                            <div class="mail-content-item-left">
                                                タイトル
                                            </div>
                                            <div class="mail-content-item-right">
                                                <input type="text" placeholder="メールタイトル" name="title">
                                            </div>
                                        </div>
                                        <div class="mail-content-item">
                                            <div class="mail-content-item-left">
                                                本文<br>
                                                <a href="" class="plugin-code-btn btn-common">差込コード一覧</a>
                                            </div>
                                            <div class="mail-content-item-right">
                                                <textarea name="body" id="" placeholder="[com]&#10;&#10;[unit]&#10;&#10;[name]様&#10;&#10;登録されたID・パスワードは以下になります。&#10;&#10;ID=[id]&#10;&#10;PW=[pw]"></textarea>
                                            </div>
                                        </div>
                                        <div class="mail-content-item">
                                            <div class="mail-content-item-left">
                                                タイマー配信日時
                                            </div>
                                            <div class="mail-content-item-right">
                                                <select name="year" id="">
                                                    @for ($i = 2022; $i <= (now()->year + 3); $i++)
                                                        @if ($i == now()->year)
                                                            <option value="{{ $i }}" selected>{{ $i }}年</option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}年</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="month" id="">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        @if ($i == now()->month)
                                                            <option value="{{ $i }}" selected>{{ $i }}月</option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}月</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="day" id="">
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        @if ($i == now()->day)
                                                        <option value="{{ $i }}" selected>{{ $i }}日</option>
                                                        @else
                                                        <option value="{{ $i }}">{{ $i }}日</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="hour" id="">
                                                    @for ($i = 0; $i <=23 ; $i++)
                                                        @if ($i == now()->hour)
                                                        <option value="{{ $i }}" selected>{{ $i }}時</option>
                                                        @else
                                                        <option value="{{ $i }}">{{ $i }}時</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="minute" id="" required>
                                                    @for ($i = 0; $i <=59 ; $i++)
                                                        @if ($i == now()->minute)
                                                        <option value="{{ $i }}" selected>{{ $i }}分</option>
                                                        @else
                                                        <option value="{{ $i }}">{{ $i }}分</option>
                                                        @endif
                                                    @endfor
                                                </select>                                       
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="admin-list-part">
                                    <div class="admin-list-title">
                                        配信先選択
                                    </div>
                                    <div class="mail-list-filter">
                                        <div class="mail-list-select-filter">
                                            <div class="mail-list-filter-name">絞り込み</div>
                                            <select name="select_prefecture" id="mail-prefecture-select">
                                                <option value="">県を選択</option>
                                                <option value="北海道">北海道</option>
                                                <option value="青森県">青森県</option>
                                                <option value="岩手県">岩手県</option>
                                                <option value="宮城県">宮城県</option>
                                                <option value="秋田県">秋田県</option>
                                                <option value="山形県">山形県</option>
                                                <option value="福島県">福島県</option>
                                                <option value="茨城県">茨城県</option>
                                                <option value="栃木県">栃木県</option>
                                                <option value="群馬県">群馬県</option>
                                                <option value="埼玉県">埼玉県</option>
                                                <option value="千葉県">千葉県</option>
                                                <option value="東京都">東京都</option>
                                                <option value="神奈川県">神奈川県</option>
                                                <option value="新潟県">新潟県</option>
                                                <option value="富山県">富山県</option>
                                                <option value="石川県">石川県</option>
                                                <option value="福井県">福井県</option>
                                                <option value="山梨県">山梨県</option>
                                                <option value="長野県">長野県</option>
                                                <option value="岐阜県">岐阜県</option>
                                                <option value="静岡県">静岡県</option>
                                                <option value="愛知県">愛知県</option>
                                                <option value="三重県">三重県</option>
                                                <option value="滋賀県">滋賀県</option>
                                                <option value="京都府">京都府</option>
                                                <option value="大阪府">大阪府</option>
                                                <option value="兵庫県">兵庫県</option>
                                                <option value="奈良県">奈良県</option>
                                                <option value="和歌山県">和歌山県</option>
                                                <option value="鳥取県">鳥取県</option>
                                                <option value="島根県">島根県</option>
                                                <option value="岡山県">岡山県</option>
                                                <option value="広島県">広島県</option>
                                                <option value="山口県">山口県</option>
                                                <option value="徳島県">徳島県</option>
                                                <option value="香川県">香川県</option>
                                                <option value="愛媛県">愛媛県</option>
                                                <option value="高知県">高知県</option>
                                                <option value="福岡県">福岡県</option>
                                                <option value="佐賀県">佐賀県</option>
                                                <option value="長崎県">長崎県</option>
                                                <option value="熊本県">熊本県</option>
                                                <option value="大分県">大分県</option>
                                                <option value="宮崎県">宮崎県</option>
                                                <option value="鹿児島県">鹿児島県</option>
                                                <option value="沖縄県">沖縄県</option>
                                            </select>
                                            <select name="select_industry" id="mail-industry-select">
                                                <option value="">業種を選択</option>
                                                <option value="自治体">自治体</option>
                                                <option value="観光協会">観光協会</option>
                                                <option value="各種団体">各種団体</option>
                                                <option value="運輸業">運輸業</option>
                                                <option value="宿泊業">宿泊業</option>
                                                <option value="旅行業">旅行業</option>
                                                <option value="観光施設">観光施設</option>
                                                <option value="飲食業">飲食業</option>
                                                <option value="土産品製造業">土産品製造業</option>
                                                <option value="土産品販売業">土産品販売業</option>
                                                <option value="広告業">広告業</option>
                                                <option value="メディア・制作">メディア・制作</option>
                                                <option value="その他">その他</option>
                                            </select>
                                        </div>
                                        <div class="mail-list-search-filter">
                                            <div class="mail-list-filter-name">フリーワード</div>
                                            <input type="text" name="select_free_word" id="mail-freeword-select">
                                            <button class="mail-list-search-filter-btn btn-primary">検索</button>
                                        </div>
                                    </div>
                                    <div class="mail-select-part">
                                        <div class="mail-select-all-count">
                                            登録人数{{ $all_user_count }}人
                                        </div>
                                        <div class="mail-select-search-count">
                                            検索結果{{ $searched_user_count }}人
                                            <div class="mail-all-select">
                                                <label>
                                                    絞り込んだ全員を選択<input type="checkbox" id="mail-all-select">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="admin-list-body">
                                        <table>
                                            <tr>
                                                <th>No</th>
                                                <th>企業/団体名</th>
                                                <th>氏名</th>
                                                <th>送信</th>
                                            </tr>
                                            <?php $i = 1; ?>
                                            @forelse($users as $user)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $user->company_name }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="user_mail[]" value="{{ $user }}" class="mail-individual-select">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @empty
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>  
                                            @endforelse
                                        </table>
                                        <div class="mail-select-btn-group">
                                            <button type="submit" name="action" class="mail-select-btn btn-primary" value="submit">メール内容・宛先</button>
                                            <button type="submit" name="action" class="mail-select-save-btn btn-extra" value="save">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form method="get" action="{{ route('userMailCreateSearchGet') }}" id="searchForm">
                            <input type="text" name="prefecture" id="real_prefecture">
                            <input type="text" name="industry" id="real_industry">
                            <input type="text" name="free_word" id="real_free_word">
                            <button type="type" class="mail-list-search-filter-hidden-btn btn-primary">検索</button>
                        </form>
                    </div>
                    <div id="code-modal" class="modal">
                        <div class="modal-content">
                            <h1>差込コード一覧</h1>
                            <div class="modal-part">
                                <div class="modal-part-item"><div class="modal-part-left">ID</div><div class="modal-part-middle">=</div><div class="modal-part-right">[id]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">パスワード</div><div class="modal-part-middle">=</div><div class="modal-part-right">[pw]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">会員企業/団体名</div><div class="modal-part-middle">=</div><div class="modal-part-right">[com]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">部署名</div><div class="modal-part-middle">=</div><div class="modal-part-right">[unit]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">役職</div><div class="modal-part-middle">=</div><div class="modal-part-right">[posi]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">氏名</div><div class="modal-part-middle">=</div><div class="modal-part-right">[name]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">メールアドレス</div><div class="modal-part-middle">=</div><div class="modal-part-right">[mail]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">電話番号</div><div class="modal-part-middle">=</div><div class="modal-part-right">[tel]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">郵便番号</div><div class="modal-part-middle">=</div><div class="modal-part-right">[post]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">住所1.（県）</div><div class="modal-part-middle">=</div><div class="modal-part-right">[add1]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">住所2.（市町村）</div><div class="modal-part-middle">=</div><div class="modal-part-right">[add2]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">住所3.</div><div class="modal-part-middle">=</div><div class="modal-part-right">[add3]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">住所4.（建物名）</div><div class="modal-part-middle">=</div><div class="modal-part-right">[add4]</div></div>
                                <div class="modal-part-item"><div class="modal-part-left">業種</div><div class="modal-part-middle">=</div><div class="modal-part-right">[add1]</div></div>
                            </div>
                            <a href="#" class="modal-close">&times;</a>
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
        document.addEventListener("click", function(event) {
                if (event.target.matches(".plugin-code-btn")) {
                    event.preventDefault();
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

        $(document).ready(function() {
            $('#mailSend').addClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#adminHome').removeClass('active');
        });
        $('#mail-all-select').click(function () {
            $('.mail-individual-select').prop('checked', !$('.mail-individual-select').prop('checked'));
        });

        $('.mail-list-search-filter-btn').on("click", function(e) {
            $('#real_prefecture').val($('#mail-prefecture-select').val());
            $('#real_prefecture').trigger("change");
            $('#real_industry').val($('#mail-industry-select').val());
            $('#real_industry').trigger("change");
            $('#real_free_word').val($('#mail-freeword-select').val());
            $('#real_free_word').trigger("change");

            $('.mail-list-search-filter-hidden-btn').click();
            return false;
        });
    </script>
@stop