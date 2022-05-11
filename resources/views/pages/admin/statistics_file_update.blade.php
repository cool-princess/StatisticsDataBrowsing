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
                            <form action="{{route('statisticsFileUpdatePost', ['id' => $data[0]->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="statistics-file-register-part">
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                No
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            {{ $data[0]->id }}
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                登録日
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <select name="year" id="year">
                                                <option value="">年</option>
                                                @for ($i = 2022; $i <= (now()->year + 3); $i++)
                                                    @if ($i == now()->year)
                                                        <option value="{{ $i }}" selected>{{ $i }}年</option>
                                                    @else
                                                        <option value="{{ $i }}">{{ $i }}年</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <select name="month" id="month">
                                                <option value="">月</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    @if ($i == now()->month)
                                                        <option value="{{ $i }}" selected>{{ $i }}月</option>
                                                    @else
                                                        <option value="{{ $i }}">{{ $i }}月</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <select name="day" id="day">
                                                <option value="">日</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    @if ($i == now()->day)
                                                        <option value="{{ $i }}" selected>{{ $i }}日</option>
                                                    @else
                                                        <option value="{{ $i }}">{{ $i }}日</option>
                                                    @endif
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
                                            <select name="category" id="cat" required>
                                                <option value="">カテゴリ選択</option>
                                                <option value="カテゴリ1">カテゴリ1</option>
                                                <option value="カテゴリ2">カテゴリ2</option>
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
                                            <input type="text" name="reporter" placeholder="◯◯◯◯◯レポート" value="{{$data[0]->reporter}}" required>
                                        </div>
                                    </div>
                                    <div class="statistics-file-register-item">
                                        <div class="statistics-file-register-item-left">
                                            <div>
                                                表示ファイル名
                                            </div>
                                        </div>
                                        <div class="statistics-file-register-item-right">
                                            <input type="text" name="fileName" id="fileName" placeholder="◯◯◯◯◯統計.xlsx" readonly="readonly" value="{{$data[0]->display_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="statistics-file-register-btn-group">
                                    <button type="submit" class="statistics-file-register-btn btn-primary">新規登録・修正</button>
                                    <a href="{{ route('statisticsFileDelete', ['id' => $data[0]->id]) }}" class="statistics-file-delete-btn btn-danger">登録を削除</a>
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
            $('#year').val('{{ $data[0]->created_at->year; }}');
            $('#month').val('{{ $data[0]->created_at->month; }}');
            $('#day').val('{{ $data[0]->created_at->day; }}');
            $('#cat').val('{{ $data[0]->category; }}');
        });
    </script>
@stop