@extends('layouts.custom')

@section('content')
    <section id="admin_manage" class="top">
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
                            <div class="main-title">管理者 管理</div>
                            <div class="admin-add-part">
                                <div class="admin-add-title">
                                    新規登録
                                </div>
                                <a href="{{ route('adminRegister') }}" class="admin-add-btn btn-primary">登録</a>
                            </div>
                            <div class="admin-list-part">
                                <div class="admin-list-title">
                                    管理者一覧
                                </div>
                                <div class="admin-list-body">
                                    <table>
                                        <tr>
                                            <th>No</th>
                                            <th>氏名</th>
                                            <th>メールアドレス</th>
                                            <th>休止</th>
                                            <th></th>
                                        </tr>
                                        <?php $i = 1; ?>
                                        @forelse($admins as $admin)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                @if($admin->break == 1)
                                                    <td>ON</td>
                                                @else
                                                    <td>OFF</td>
                                                @endif
                                                <td><a href="{{ route('adminGet', ['id' => $admin->admin_id]) }}" class="admin-list-fix-btn btn-primary">修正</a></td>
                                            </tr>
                                            <?php $i++; ?>
                                        @empty
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>  
                                        @endforelse
                                    </table>
                                    <div class="admin-list-pagination main-pagination">
                                        @if($admins->currentPage() != 1)
                                            <a href="{{ $admins->previousPageUrl() }}" class="main-pagination-prev btn-primary">前のページへ</a>
                                        @endif
                                        @if($admins->total() > 5)
                                            <div class="main-pagination-pages">{{ $admins->currentPage() }} / {{ $admins->lastPage() }} </div>
                                        @endif
                                        @if($admins->currentPage() != $admins->lastPage())
                                            <a href="{{ $admins->nextPageUrl() }}" class="main-pagination-next btn-primary">次のページへ</a>
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
            $('#adminManage').addClass('active');
            $('#adminHome').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop