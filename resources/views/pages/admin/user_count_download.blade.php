@extends('layouts.custom')

@section('content')
    <section id="member_count_download" class="top">
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
                            <div class="main-title">会員 利用者数ダウンロード</div>
                            <form action="{{ route('downloadCountExport') }}" method="POST">
                                @csrf
                                <div class="member-count-download-part">
                                    <div class="member-count-download-item">
                                        <div class="member-count-download-item-title">
                                            期間
                                        </div>
                                        <div class="member-count-download-item-body">
                                            <div class="member-count-download-item-date">
                                                <select name="from_date_year" id="" required>
                                                    <option value="">年</option>
                                                    @for ($i = 2012; $i <= 2030; $i++)
                                                        <option value="{{ $i }}">{{ $i }}年</option>
                                                    @endfor
                                                </select>
                                                <select name="from_date_month" id="" required>
                                                    <option value="">月</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">{{ $i }}月</option>
                                                    @endfor
                                                </select>
                                                <select name="from_date_day" id="" required>
                                                    <option value="">日</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}日</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div>~</div>
                                            <div class="member-count-download-item-date">
                                                <select name="end_date_year" id="" required>
                                                    <option value="">年</option>
                                                    @for ($i = 2012; $i <= 2024; $i++)
                                                        <option value="{{ $i }}">{{ $i }}年</option>
                                                    @endfor
                                                </select>
                                                <select name="end_date_month" id="" required>
                                                    <option value="">月</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}">{{ $i }}月</option>
                                                    @endfor
                                                </select>
                                                <select name="end_date_day" id="" required>
                                                    <option value="">日</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}">{{ $i }}日</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="member-count-download-item">
                                        <div class="member-count-download-item-title">
                                            絞り込み
                                        </div>
                                        <div class="member-count-download-item-body">
                                            <div class="member-count-download-item-date">
                                                <select name="address1" id="">
                                                    <option value="">県を選択</option>
                                                    <option value="1">県を選択</option>
                                                    <option value="2">県を選択</option>
                                                    <option value="3">県を選択</option>
                                                </select>
                                                <select name="sectors" id="">
                                                    <option value="">業種を選択</option>
                                                    <option value="4">業種を選択</option>
                                                    <option value="5">業種を選択</option>
                                                    <option value="6">業種を選択</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="member-count-download-btn btn-primary">ダウンロード</button>
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
            $('#userManage').addClass('active');
            $('#adminHome').removeClass('active');
            $('#adminManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop