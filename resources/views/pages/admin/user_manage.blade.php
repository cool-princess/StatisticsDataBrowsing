@extends('layouts.custom')

@section('content')
    <section id="member_manage" class="top">
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
                            <div class="main-title">会員 管理</div>
                            <div class="member-add-part">
                                <div class="member-add-title">
                                    新規登録 / エクスポート
                                </div>
                                <div class="member-add-btn-group">
                                    <a href="{{ route('userRegister') }}" class="member-add-btn btn-primary">個別登録</a>
                                    <a href="{{ route('memberCsvFileRegister') }}" class="member-add-btn btn-primary">CSV一括登録</a>
                                    <a href="{{ route('memberCsvFileExport', ['extension' => 'csv']) }}" class="member-add-btn btn-primary">CSVエクスポート</a>
                                    <a href="{{ route('userCountDownload') }}" class="member-add-btn btn-primary">利用数ダウンロード</a>
                                </div>
                            </div>
                            <div class="member-list-part">
                                <div class="member-list-title">
                                    会員一覧
                                </div>
                                <div class="member-list-filter">
                                    <form method="get" action="{{ route('userSearchPost') }}">
                                        <div class="member-list-select-filter">
                                            <div class="member-list-filter-name">絞り込み</div>
                                            <select name="prefecture" id="member-prefecture-select">
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
                                            <select name="industry" id="member-industry-select">
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
                                        <div class="member-list-search-filter">
                                            <div class="member-list-filter-name">フリーワード</div>
                                            <input type="text" name="free_word">
                                            <button type="submit" class="member-list-search-filter-btn btn-primary">検索</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="member-list-body">
                                    <table>
                                        <tr>
                                            <th>No</th>
                                            <th>企業/団体名</th>
                                            <th>氏名</th>
                                            <th>DL</th>
                                            <th>休止</th>
                                            <th></th>
                                        </tr>
                                        <?php $i = 1; ?>
                                        @forelse($users as $user)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $user->company_name }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->download_count }}</td>
                                                @if($user->break == 1)
                                                    <td>ON</td>
                                                @else
                                                    <td>OFF</td>
                                                @endif
                                                <td><a href="{{ route('userGet', ['id' => $user->user_id]) }}" class="member-list-fix-btn btn-primary">修正</a></td>
                                            </tr>
                                            <?php $i++; ?>
                                        @empty
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>  
                                        @endforelse
                                    </table>
                                    <div class="member-list-pagination main-pagination">
                                        @if($users->currentPage() != 1)
                                            <a href="{{ $users->previousPageUrl() }}" class="main-pagination-prev btn-primary">前のページへ</a>
                                        @endif
                                        @if($users->total() > 5)
                                            <div class="main-pagination-pages">{{ $users->currentPage() }} / {{ $users->lastPage() }} </div>
                                        @endif
                                        @if($users->currentPage() != $users->lastPage())
                                            <a href="{{ $users->nextPageUrl() }}" class="main-pagination-next btn-primary">次のページへ</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
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
            $('#userManage').addClass('active');
            $('#adminHome').removeClass('active');
            $('#adminManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop