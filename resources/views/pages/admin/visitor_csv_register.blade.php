@extends('layouts.custom')

@section('content')
    <section id="visitor_csv_register" class="top">
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
                            <div class="main-title">チケット購入者データ　CSV登録</div>
                            <div class="csv-register-id">
                                No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ $file_no }}</span>
                            </div>
                            <form action="{{route('visitorCsvUpload')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="csv-register-part">
                                    <label class="csv-file-label" for="chooseFile">CSVファイル選択</label>
                                    <input type="file" name="file" id="chooseFile">
                                    <input type="text" name="fileName" id="fileName" readonly="readonly">
                                    <button type="submit" class="csv-register-btn btn-primary">登録</button>
                                </div>
                            </form>
                            <div class="csv-register-explanation">
                                ※チケット購入者データを登録する際に、個人情報の列を自動的に削除します。
                            </div>
                            <div class="csv-register-status">
                                <div class="csv-register-status-title">
                                    登録状況
                                </div>
                                <div class="csv-register-status-report">
                                    @if(session()->has('success'))
                                        <span class="csv-register-date">{{ \Carbon\Carbon::now()->toDateTimeString() }}</span><br>
                                        {{ session()->get('success') }}
                                    @endif
                                </div>
                                <div class="csv-register-status-error">
                                    @if($errors->any())
                                        <span class="csv-register-date">{{ \Carbon\Carbon::now()->toDateTimeString() }}</span><br>
                                        登録に失敗しました。<br>
                                        <div class="alert alert-danger">
                                            <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            </ul>
                                            csvファイルを修正して再度登録ください。
                                        </div>
                                    @endif
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
            $('#visitorData').addClass('active');
            $('#adminHome').removeClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop