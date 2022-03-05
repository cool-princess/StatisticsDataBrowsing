@extends('layouts.custom')

@section('content')
    <section id="visitor_data" class="top">
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
                            <div class="main-title">チケット購入者データ</div>
                            <div class="visitor-register-part">
                                <div class="visitor-register-title">
                                    登録
                                </div>
                                <a href="{{ route('visitorCsvRegister') }}" class="visitor-register-btn btn-primary">CSV登録</a>
                            </div>
                            <div class="admin-list-part">
                                <div class="admin-list-title">
                                    チケット購入者データ一覧
                                </div>
                                <div class="admin-list-body">
                                    <table>
                                        <tr>
                                            <th>No</th>
                                            <th>登録日時</th>
                                            <th>ファイル名</th>
                                            <th>削除</th>
                                        </tr>
                                        <?php $i = 1; ?>
                                        @forelse($files as $file)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $file->created_at }}</td>
                                                <td>{{ $file->name }}</td>
                                                <td><a href="{{ route('visitorDataDelete', ['no' => $file->id]) }}" class="admin-list-fix-btn btn-primary">削除</a></td>
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
                                    <div class="visitor-list-pagination main-pagination">
                                        @if($files->currentPage() != 1)
                                            <a href="{{ $files->previousPageUrl() }}" class="main-pagination-prev btn-primary">前のページへ</a>
                                        @endif
                                        @if($files->total() > 5)
                                            <div class="main-pagination-pages">{{ $files->currentPage() }} / {{ $files->lastPage() }} </div>
                                        @endif
                                        @if($files->currentPage() != $files->lastPage())
                                            <a href="{{ $files->nextPageUrl() }}" class="main-pagination-next btn-primary">次のページへ</a>
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
            $('#visitorData').addClass('active');
            $('#adminHome').removeClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop