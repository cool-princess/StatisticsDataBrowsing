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
                                                <option value="1">県を選択</option>
                                                <option value="2">県を選択</option>
                                            </select>
                                            <select name="industry" id="member-industry-select">
                                                <option value="">業種を選択</option>
                                                <option value="3">業種を選択</option>
                                                <option value="4">業種を選択</option>
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
                                                <td>5</td>
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