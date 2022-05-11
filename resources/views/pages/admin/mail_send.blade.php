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
                                    <form method="get" action="{{ route('mailSearchGet') }}">
                                        <div class="mail-send-name">
                                            絞り込み
                                        </div>
                                        <input type="text" name="keyword">
                                        <button type="submit" class="mail-send-filter-btn btn-primary">検索</button>
                                    </form>
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
                                        <?php $i = 1; ?>
                                            @forelse($mails as $mail)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    @if($mail->delivered == '送')
                                                        <td style="color: blue;">{{ $mail->delivered }}</td>
                                                    @elseif($mail->delivered == '予')
                                                        <td style="color: red;">{{ $mail->delivered }}</td>
                                                    @else
                                                        <td>{{ $mail->delivered }}</td>
                                                    @endif
                                                    <td>{{ $mail->reserve_date }}</td>
                                                    <td>{{ $mail->title }}</td>
                                                    <td><a href="{{ route('mailResend', ['id' => $mail->id]) }}" class="mail-send-reuse-btn btn-primary">再利用</a></td>
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
                                    <div class="mail-send-pagination main-pagination">
                                        @if($mails->currentPage() != 1)
                                            <a href="{{ $mails->previousPageUrl() }}" class="main-pagination-prev btn-primary">前のページへ</a>
                                        @endif
                                        @if($mails->total() > 5)
                                            <div class="main-pagination-pages">{{ $mails->currentPage() }} / {{ $mails->lastPage() }} </div>
                                        @endif
                                        @if($mails->currentPage() != $mails->lastPage())
                                            <a href="{{ $mails->nextPageUrl() }}" class="main-pagination-next btn-primary">次のページへ</a>
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
            $('#mailSend').addClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#adminHome').removeClass('active');
        });
    </script>
@stop