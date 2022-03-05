@extends('layouts.custom')

@section('content')
<section id="statistics_file_register" class="top">
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
                            <div class="main-title">統計ファイル　登録</div>
                            <form action="{{route('statisticsFileRegisterPost')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="statistics-file-register-part">
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                No
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            {{ $file_no }}
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                登録日
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <select name="year" id="">
                                                <option value="">年</option>
                                                @for ($i = 2012; $i <= 2030; $i++)
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
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                カテゴリ
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <select name="category" id="">
                                                <option value="">カテゴリ選択</option>
                                                <option value="カテゴリ1">カテゴリ選択</option>
                                                <option value="カテゴリ2">カテゴリ選択</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                ファイル
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <label class="csv-file-label" for="chooseFile">ファイル選択</label>
                                            <input type="file" name="file" id="chooseFile">
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                レポート名
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <input type="text" name="reporter" placeholder="◯◯◯◯◯レポート">
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                表示ファイル名
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <input type="text" name="fileName" id="fileName" placeholder="◯◯◯◯◯統計.xlsx" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="statistics-file-register-btn-group">
                                    <button type="submit" class="statistics-file-register-btn btn-primary">新規登録・修正　確認画面へ</button>
                                </div>
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
        $('#chooseFile').change(function() {
            var i = $(this).prev('label').clone();
            console.log($('#chooseFile')[0].files[0].name);
            var file = $('#chooseFile')[0].files[0].name;
            $('#fileName').val(file);
        });
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