@extends('layouts.custom')

@section('content')
    <section id="statistics_file" class="top">
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
                            <div class="main-title">統計ファイル</div>
                            <div class="admin-add-part">
                                <div class="admin-add-title">
                                    登録
                                </div>
                                <a href="{{ route('statisticsFileRegister') }}" class="statistics-file-add-btn btn-primary">ファイル登録</a>
                            </div>
                            <div class="admin-list-part">
                                <div class="admin-list-title">
                                    統計ファイル一覧
                                </div>
                                <div class="admin-list-body">
                                    <table>
                                        <tr>
                                            <th>No</th>
                                            <th>日時</th>
                                            <th>レポート名</th>
                                            <th>ダウンロード</th>
                                            <th>修正</th>
                                        </tr>
                                        <?php $i = 1; ?>
                                        @forelse($files as $file)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $file->created_at }}</td>
                                                <td>{{ $file->reporter }}</td>
                                                <td><a href="{{ route('statisticsFileExport', ['id' => $file->id]) }}" class="admin-list-fix-btn btn-primary">PDF</a></td>
                                                <td><a href="{{ route('statisticsFileUpdate', ['id' => $file->id]) }}" class="admin-list-fix-btn btn-primary">修正</a></td>
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
                                    <div class="admin-list-pagination main-pagination">
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
            $('#statisticsFile').addClass('active');
            $('#adminHome').removeClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop