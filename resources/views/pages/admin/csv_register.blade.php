@extends('layouts.custom')

@section('content')
    <section id="csv_register" class="top">
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
                            <div class="main-title">会員 CSV一括登録</div>
                            <form action="{{route('memberCsvFileUpload')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="csv-register-part">
                                    <label class="csv-file-label" for="chooseFile">CSVファイル選択</label>
                                    <input type="file" name="csv_file" id="chooseFile">
                                    <input type="text" name="fileName" id="fileName" readonly="readonly">
                                    <button type="submit" class="csv-register-btn btn-primary">登録</button>
                                </div>
                            </form>
                            <div class="csv-register-status">
                                <div class="csv-register-status-title">
                                    登録状況
                                </div>
                                <div class="csv-register-status-report">
                                    <span class="csv-register-date">2022.10.25　13：32</span><br>
                                    登録を完了しました
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="csv-register-status-error">
                                    <span class="csv-register-date">2022.10.25　13：32</span><br>
                                    登録されませんでした
                                    3行目にエラーがあります
                                    12行目にエラーがあります
                                    25行目にエラーがあります
                                    CSVファイルを修正して再度ご登録ください
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
        $('#chooseFile').change(function() {
            var i = $(this).prev('label').clone();
            console.log($('#chooseFile')[0].files[0].name);
            var file = $('#chooseFile')[0].files[0].name;
            $('#fileName').val(file);
        });
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