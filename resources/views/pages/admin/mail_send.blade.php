@extends('layouts.custom')

@section('content')
    <section id="mail_send" class="top">
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
                            <div class="main-title">メール配信</div>
                            <div class="visitor-register-part">
                                <div class="visitor-register-title">
                                    新規メール作成
                                </div>
                                <a href="{{ route('mailCreate') }}" class="mail-send-btn btn-primary">メール作成</a>
                            </div>
                            <div class="admin-list-part">
                                <div class="admin-list-title">
                                    配信済み・予約・保存メール
                                </div>
                                <div class="mail-send-filter">
                                    <div class="mail-send-name">
                                        絞り込み
                                    </div>
                                    <input type="text">
                                    <a href="" class="mail-send-filter-btn btn-primary">検索</a>
                                </div>
                                <div class="admin-list-body">
                                    <table>
                                        <tr>
                                            <th>No</th>
                                            <th>状態</th>
                                            <th>配信日時</th>
                                            <th>タイトル</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>保</td>
                                            <td>2022.10.22 13:00</td>
                                            <td>□□□□◯□□□□◆□□□□◯□□□□◆□□・・・</td>
                                            <td><a href="" class="mail-send-reuse-btn btn-primary">再利用</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>予</td>
                                            <td>2022.10.22 13:00</td>
                                            <td>□□□□◯□□□□◆□□□□◯□□□□◆□□・・・</td>
                                            <td><a href="" class="mail-send-reuse-btn btn-primary">再利用</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>保</td>
                                            <td>2022.10.22 13:00</td>
                                            <td>□□□□◯□□□□◆□□□□◯□□□□◆□□・・・</td>
                                            <td><a href="" class="mail-send-reuse-btn btn-primary">再利用</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>送</td>
                                            <td>2022.10.22 13:00</td>
                                            <td>□□□□◯□□□□◆□□□□◯□□□□◆□□・・・</td>
                                            <td><a href="" class="mail-send-reuse-btn btn-primary">再利用</a></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>保</td>
                                            <td>2022.10.22 13:00</td>
                                            <td>□□□□◯□□□□◆□□□□◯□□□□◆□□・・・</td>
                                            <td><a href="" class="mail-send-reuse-btn btn-primary">再利用</a></td>
                                        </tr>
                                    </table>
                                    <div class="mail-send-pagination main-pagination">
                                        <button class="main-pagination-prev btn-primary">前のページへ</button>
                                        <div class="main-pagination-pages">１ / 4 </div>
                                        <button class="main-pagination-next btn-primary">次のページへ</button>
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
            $('#mailSend').addClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#adminHome').removeClass('active');
        });
    </script>
@stop