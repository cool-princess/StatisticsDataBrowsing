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
                                            10
                                        </div>
                                    </div>
                                    <div class="mail-content-item">
                                        <div class="mail-content-item-left">
                                            タイトル
                                        </div>
                                        <div class="mail-content-item-right">
                                            <input type="text" placeholder="メールタイトルメールタイトル">
                                        </div>
                                    </div>
                                    <div class="mail-content-item">
                                        <div class="mail-content-item-left">
                                            本文<br>
                                            <a href="" class="plugin-code-btn btn-common">差込コード一覧</a>
                                        </div>
                                        <div class="mail-content-item-right">
                                            <textarea name="" id="" placeholder="[com]&#10;&#10;[unit]&#10;&#10;[name]様&#10;&#10;登録されたID・パスワードは以下になります。&#10;&#10;ID=[id]&#10;&#10;PW=[pw]"></textarea>
                                        </div>
                                    </div>
                                    <div class="mail-content-item">
                                        <div class="mail-content-item-left">
                                            タイマー配信日時
                                        </div>
                                        <div class="mail-content-item-right">
                                            <select name="year" id="">
                                                <option value="">年</option>
                                                @for ($i = 2022; $i <= 2040; $i++)
                                                    <option value="{{ $i }}">{{ $i }}年</option>
                                                @endfor
                                            </select>
                                            <select name="month" id="">
                                                <option value="">月</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $i }}月</option>
                                                @endfor
                                            </select>
                                            <select name="day" id="">
                                                <option value="">日</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }}日</option>
                                                @endfor
                                            </select>
                                            <select name="hour" id="">
                                                <option value="">時</option>
                                                @for ($i = 0; $i <= 23; $i++)
                                                    <option value="{{ $i }}">{{ $i }}時</option>
                                                @endfor
                                            </select>
                                            <select name="minute" id="">
                                                <option value="">分</option>
                                                @for ($i = 0; $i <= 59; $i++)
                                                    <option value="{{ $i }}">{{ $i }}分</option>
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
                                        <select name="" id="mail-prefecture-select">
                                            <option value="">県を選択</option>
                                            <option value="">All</option>
                                            <option value="">県を選択</option>
                                        </select>
                                        <select name="" id="mail-industry-select">
                                            <option value="">業種を選択</option>
                                            <option value="">All</option>
                                            <option value="">県を選択</option>
                                        </select>
                                    </div>
                                    <div class="mail-list-search-filter">
                                        <div class="mail-list-filter-name">フリーワード</div>
                                        <input type="text">
                                        <button class="mail-list-search-filter-btn btn-primary">検索</button>
                                    </div>
                                </div>
                                <div class="mail-select-part">
                                    <div class="mail-select-all-count">
                                        登録人数0,000人
                                    </div>
                                    <div class="mail-select-search-count">
                                        検索結果0,000人
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
                                                        <input type="checkbox" name="mail-individual-select" class="mail-individual-select">
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
                                        <button type="submit" class="mail-select-btn btn-primary">メール内容・宛先　確認画面へ</button>
                                        <a href="" class="mail-select-save-btn btn-extra">保存</a>
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
        $('#mail-all-select').click(function () {
            $('.mail-individual-select').prop('checked', !$('.mail-individual-select').prop('checked'));
        });
    </script>
@stop