@extends('layouts.custom')

@section('content')
    <section id="admin_top" class="top">
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
                            <div class="main-title">管理者サイト　トップページ</div>
                            <div class="news-add-part">
                                <div class="news-add-title">
                                    お知らせ｜新規入力
                                </div>
                                <div class="news-add-body">
                                    <form method="POST" action="{{ route('newsRegisterPost') }}">
                                        @csrf
                                        <div class="news-add-date">
                                            <span>日時</span>
                                            <select name="year" id="" required>
                                                @for ($i = 2022; $i <= (now()->year + 3); $i++)
                                                    @if ($i == now()->year)
                                                        <option value="{{ $i }}" selected>{{ $i }}年</option>
                                                    @else
                                                        <option value="{{ $i }}">{{ $i }}年</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <select name="month" id="" required>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    @if ($i == now()->month)
                                                        <option value="{{ $i }}" selected>{{ $i }}月</option>
                                                    @else
                                                        <option value="{{ $i }}">{{ $i }}月</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <select name="day" id="" required>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    @if ($i == now()->day)
                                                    <option value="{{ $i }}" selected>{{ $i }}日</option>
                                                    @else
                                                    <option value="{{ $i }}">{{ $i }}日</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <select name="hour" id="" required>
                                                @for ($i = 0; $i <=23 ; $i++)
                                                    @if ($i == now()->hour)
                                                    <option value="{{ $i }}" selected>{{ $i }}時</option>
                                                    @else
                                                    <option value="{{ $i }}">{{ $i }}時</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            <select name="minute" id="" required>
                                                @for ($i = 0; $i <=59 ; $i++)
                                                    @if ($i == now()->minute)
                                                    <option value="{{ $i }}" selected>{{ $i }}分</option>
                                                    @else
                                                    <option value="{{ $i }}">{{ $i }}分</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="news-add-content">
                                            <textarea name="news" id="" placeholder="ここに入力すると、利用者のトップページに掲載されます。&#10;また、下に表示さますので後から修正できます。
                                            " required></textarea>
                                        </div>
                                        <button type="submit" class="news-add-btn btn-primary">新規保存</button>
                                    </form>
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="news-add-part">
                                <div class="news-add-title">
                                    お知らせ｜更新
                                </div>
                                @if ( !empty($newsInfo) )
                                    @foreach ($newsInfo as $items)
                                    <div class="news-add-body">
                                        <form method="POST" action="{{ route('newsUpdatePost', ['no' => $items->id]) }}">
                                            @csrf
                                            <div class="news-add-date">
                                                <span>日時</span>
                                                <select name="year" id="" required>
                                                    @for ($i = 2022; $i <= (now()->year + 3); $i++)
                                                        @if ($i == now()->year)
                                                            <option value="{{ $i }}" selected>{{ $i }}年</option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}年</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="month" id="" required>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        @if ($i == now()->month)
                                                            <option value="{{ $i }}" selected>{{ $i }}月</option>
                                                        @else
                                                            <option value="{{ $i }}">{{ $i }}月</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="day" id="" required>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        @if ($i == now()->day)
                                                        <option value="{{ $i }}" selected>{{ $i }}日</option>
                                                        @else
                                                        <option value="{{ $i }}">{{ $i }}日</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="hour" id="" required>
                                                    @for ($i = 0; $i <=23 ; $i++)
                                                        @if ($i == now()->hour)
                                                        <option value="{{ $i }}" selected>{{ $i }}時</option>
                                                        @else
                                                        <option value="{{ $i }}">{{ $i }}時</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <select name="minute" id="" required>
                                                    @for ($i = 0; $i <=59 ; $i++)
                                                        @if ($i == now()->minute)
                                                        <option value="{{ $i }}" selected>{{ $i }}分</option>
                                                        @else
                                                        <option value="{{ $i }}">{{ $i }}分</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                                <div class="news-update-time">{{ $items->created_at }}</div>
                                            </div>
                                            <div class="news-add-content">
                                                    <textarea name="updated_news" id="updated_news" placeholder="ここに入力すると、利用者のトップページに掲載されます。&#10;また、下に表示さますので後から修正できます。
                                                    ">{{ $items->title }}</textarea>
                                                </div>
                                            <div class="news-fix-btn-group">
                                                <button type="submit" class="news-fix-btn btn-primary">更新を保存</button>
                                                <a href="{{ route('newsDelete', ['no' => $items->id]) }}" class="news-delete-btn btn-danger">削除</a>
                                            </div>
                                        </form>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="news-add-body">
                                        追加されたお知らせはありません。
                                    </div>
                                @endif
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
            $('#adminHome').addClass('active');
            $('#adminManage').removeClass('active');
            $('#userManage').removeClass('active');
            $('#visitorData').removeClass('active');
            $('#statisticsFile').removeClass('active');
            $('#mailSend').removeClass('active');
        });
    </script>
@stop