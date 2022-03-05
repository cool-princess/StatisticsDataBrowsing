@extends('layouts.custom')

@section('content')
    <section id="user_top" class="top">
        <div class="container">
            <div class="header">
                <div class="navbar">
                    <h1>
                        ジブリパークチケット購入者<br>
                        <span>統計データ提供サイト</span>
                    </h1>
                </div>
                <div class="menubar">
                    <div class="menubar-group">
                        <div class="menubar-tab active" id="topTab">
                            TOP
                        </div>
                        <div class="menubar-tab" id="dataTab">
                            DATA閲覧
                        </div>
                        <div class="menubar-tab" id="reportTab">
                            レポート
                        </div>
                    </div>
                    <a class="menubar-btn">
                        お問い合わせ
                    </a>
                    <a href="{{ route('userLogout') }}" class="menubar-btn">
                        ログアウト
                    </a>
                </div>
            </div>
            <div class="wrap">
                <div class="wrapper active" id="topPage">
                    <div class="navbar-main">
                        <div class="navbar-main-content">このサイトは、愛知県ジブリパーク周遊促進事業の一環として、事前登録の観光関連事業者様へジブリパークチケット購入者の統計データを提供します。ジブリパーク来場者向けの観光商品造成やPR活動戦略の立案にご活用ください。提供データは、Boo-Wooチケットの購入者データをもとにした統計データで、1カ月ごとに更新されます。</div>
                    </div>
                    <div class="mainbar">
                        <div class="main-body">
                            <div class="main-title">ようこそ、統計データ提供サイトへ</div>
                            <div class="news-part">
                                <div class="news-title">
                                    お知らせ
                                </div>
                                <div class="news-body">
                                    @forelse($news as $item)
                                        <div class="news-item">
                                            <div class="news-item-date">
                                                {{$item->created_at}}
                                            </div>
                                            <div class="news-item-title">
                                                {{$item->title}}
                                            </div>
                                        </div>
                                    @empty
                                        お知らせかありません。
                                    @endforelse
                                </div>
                            </div>
                            <div class="main-others-part">
                                <div class="main-others-item">
                                    <div class="main-others-item-title">
                                        DATA閲覧
                                    </div>
                                    <div class="main-others-item-content">
                                        説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　
                                    </div>
                                    <a href="" id="statisticsView">統計データを見る</a>
                                </div>
                                <div class="main-others-item">
                                    <div class="main-others-item-title">
                                        レポート
                                    </div>
                                    <div class="main-others-item-content">
                                        説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　説明を記載　
                                    </div>
                                    <a href="" id="reportView">統計データをダウンロードする</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper" id="statisticsPage">
                    <div class="navbar-main">
                        <div class="navbar-main-explanation">
                            説明<br><br>テストテストテストテストテスト
                        </div>
                        <div class="navbar-main-search-part">
                            <div class="navbar-main-search-part-wrap">
                                <div class="navbar-main-search-title">
                                    SEARCH
                                </div>
                                <div class="navbar-main-search-date">
                                    <select name="" id="">
                                        <option value="">2022年</option>
                                        <option value="">2021年</option>
                                        <option value="">2020年</option>
                                        <option value="">2019年</option>
                                        <option value="">2018年</option>
                                        <option value="">2017年</option>
                                        <option value="">2016年</option>
                                        <option value="">2015年</option>
                                        <option value="">2014年</option>
                                        <option value="">2013年</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="">1月</option>
                                        <option value="">2月</option>
                                        <option value="">3月</option>
                                        <option value="">4月</option>
                                        <option value="">5月</option>
                                        <option value="">6月</option>
                                        <option value="">7月</option>
                                        <option value="">8月</option>
                                        <option value="">9月</option>
                                        <option value="">10月</option>
                                        <option value="">11月</option>
                                        <option value="">12月</option>
                                    </select>
                                </div>
                                <div class="navbar-main-search-arrow"></div>
                                <div class="navbar-main-search-date">
                                    <select name="" id="">
                                        <option value="">2022年</option>
                                        <option value="">2021年</option>
                                        <option value="">2020年</option>
                                        <option value="">2019年</option>
                                        <option value="">2018年</option>
                                        <option value="">2017年</option>
                                        <option value="">2016年</option>
                                        <option value="">2015年</option>
                                        <option value="">2014年</option>
                                        <option value="">2013年</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="">1月</option>
                                        <option value="">2月</option>
                                        <option value="">3月</option>
                                        <option value="">4月</option>
                                        <option value="">5月</option>
                                        <option value="">6月</option>
                                        <option value="">7月</option>
                                        <option value="">8月</option>
                                        <option value="">9月</option>
                                        <option value="">10月</option>
                                        <option value="">11月</option>
                                        <option value="">12月</option>
                                    </select>
                                </div>
                                <button id="all-select" class="navbar-main-input-all-select">
                                    全てのエリアを選択
                                </button>
                                <label class="navbar-main-area-select custom-input">
                                    青春の丘エリア<input type="checkbox" name="select-area" class="select-area-input">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="navbar-main-area-select custom-input">
                                    もののけの里エリア<input type="checkbox" name="select-area" class="select-area-input">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="navbar-main-area-select custom-input">
                                    ジブリの大倉庫エリア<input type="checkbox" name="select-area" class="select-area-input">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="navbar-main-area-select custom-input">
                                    魔女の谷里エリア<input type="checkbox" name="select-area" class="select-area-input">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="navbar-main-area-select custom-input">
                                    どんどこ森エリア<input type="checkbox" name="select-area" class="select-area-input">
                                    <span class="checkmark"></span>
                                </label>
                                <a href="" class="navbar-main-search-display">データ表示</a>
                            </div>
                        </div>
                    </div>
                    <div class="mainbar">
                        <div class="main-body">
                            <div class="main-title">DATA閲覧</div>
                            <div class="main-part01">
                                <div class="main-part01-ages">
                                    <div class="main-part-title">
                                        年代
                                    </div>
                                    <div class="main-part01-ages-body">
                                        <div class="main-part01-ages-item ages10">
                                            <div class="main-part01-ages-item-num01">10</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages20">
                                            <div class="main-part01-ages-item-num01">20</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">80</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages30">
                                            <div class="main-part01-ages-item-num01">30</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">70</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages40">
                                            <div class="main-part01-ages-item-num01">40</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">60</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages50">
                                            <div class="main-part01-ages-item-num01">50</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">50</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages60">
                                            <div class="main-part01-ages-item-num01">60</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">40</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages70">
                                            <div class="main-part01-ages-item-num01">70</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">30</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages80">
                                            <div class="main-part01-ages-item-num01">80</div>
                                            <div class="main-part01-ages-item-progressbar"><span></span><div class="main-part01-ages-item-num02">20</div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-part01-sex">
                                    <div class="main-part-title">
                                        性別
                                    </div>
                                    <div class="main-part01-sex-body">
                                        <div class="pie-wrapper pie-wrapper--solid">
                                            <div class="sex-item">
                                                <div class="sex-item-en">
                                                    Men
                                                </div>
                                                <div class="sex-item-pros">
                                                    65%
                                                </div>
                                            </div>
                                            <div class="sex-item">
                                                <div class="sex-item-en">
                                                    Women
                                                </div>
                                                <div class="sex-item-pros">
                                                    35%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-part02">
                                <div class="main-part02-ticket">
                                    <div class="main-part-title">
                                        チケット
                                    </div>
                                    <div class="main-part02-ticket-body">
                                        <div class="main-part02-ticket-subpart adult">
                                            <div class="main-part02-ticket-subpart-title">
                                                大人購入枚数
                                            </div>
                                            <div class="main-part02-ticket-item ticket1">
                                                <div class="main-part02-ticket-item-num01">1</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">90</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket2">
                                                <div class="main-part02-ticket-item-num01">2</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">99</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket3">
                                                <div class="main-part02-ticket-item-num01">3</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">80</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket4">
                                                <div class="main-part02-ticket-item-num01">4</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">60</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket5">
                                                <div class="main-part02-ticket-item-num01">5</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">50</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket6">
                                                <div class="main-part02-ticket-item-num01">6</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">40</div></div>
                                            </div>
                                        </div>
                                        <div class="main-part02-ticket-subpart young">
                                            <div class="main-part02-ticket-subpart-title">
                                                小人購入枚数
                                            </div>
                                            <div class="main-part02-ticket-item ticket1">
                                                <div class="main-part02-ticket-item-num01">1</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">90</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket2">
                                                <div class="main-part02-ticket-item-num01">2</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">99</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket3">
                                                <div class="main-part02-ticket-item-num01">3</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">80</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket4">
                                                <div class="main-part02-ticket-item-num01">4</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">60</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket5">
                                                <div class="main-part02-ticket-item-num01">5</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">50</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket6">
                                                <div class="main-part02-ticket-item-num01">6</div>
                                                <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">40</div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-part02-ticket-subpart ratio">
                                        <div class="main-part02-ticket-subpart-title">
                                            小人同時購入比率
                                        </div>
                                        <div class="main-part02-ticket-item">
                                            <div class="main-part02-ticket-item-progressbar"><span></span><div class="main-part02-ticket-item-num02">99</div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-part03">
                                <div class="main-part03-area">
                                    <div class="main-part-title">
                                        エリア
                                    </div>
                                    <div class="main-part03-area-body">
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">神奈川県</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">北海道</div>
                                            <div class="main-part03-area-item-progressbar"><span></span><div class="main-part03-area-item-num02">99</div></div>
                                        </div>
                                    </div>
                                    <div class="main-part03-area-explanation">
                                        ※数値は百分率
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper" id="reportPage">
                    <div class="navbar-main">
                        <div class="navbar-main-explanation">
                            一定期間のレポートやDMPを活用した分析レポートなどをダウンロードできます。
                        </div>
                        <div class="navbar-main-download-part">
                            <div class="navbar-main-download-part-wrap">
                                <button class="file-download-btn">ファイルダウンロード</button>
                                <p>右からレポートを選んで、上のボタンを押してください。</p>
                            </div>
                        </div>
                    </div>
                    <div class="mainbar">
                        <div class="main-body custom-report-bg">
                            <div class="main-title">REPORT</div>
                            <div class="main-report-part">
                                <div class="main-report-filter">
                                    <div class="main-report-filter-item">
                                        絞り込みA
                                    </div>
                                    <div class="main-report-filter-item">
                                        絞り込みB
                                    </div>
                                    <div class="main-report-filter-item">
                                        絞り込みC
                                    </div>
                                </div>
                                <div class="main-report-body"> 
                                    <form method="post" action="{{ route('reportDownloadPost', ['download'=>'zip']) }}" enctype="multipart/form-data">
                                        @csrf
                                        @forelse($files as $file)
                                            <div class="main-report-item">
                                                <div class="main-report-item-date">
                                                    {{$file->created_at}}
                                                </div>
                                                <div class="main-report-item-title">
                                                    {{$file->reporter}}
                                                </div>
                                                <label class="main-report-item-checkbox custom-input">
                                                    {{$file->display_name}}<input type="checkbox" name="fileId[]" value="{{$file->id}}">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        @empty
                                            レポートデータかありません。
                                        @endforelse
                                        <button type="submit" id="reportDownloadBtn" style="display: none"></button>
                                    </form>
                                </div>
                                <div class="main-report-pagination main-pagination">
                                    @if($files->currentPage() != 1)
                                        <a href="{{ $files->previousPageUrl() }}" class="main-pagination-prev btn-primary">前のページへ</a>
                                    @endif
                                    @if($files->total() > 5)
                                        <div class="main-pagination-pages">{{ $files->currentPage() }} / {{ $files->lastPage() }} </div>
                                    @endif
                                    @if($files->currentPage() != $files->lastPage())
                                        <a href="{{ $files->nextPageUrl() }}" class="main-pagination-next btn-primary">次のページへ</a>
                                    @endif
                                    <input type="text" name="tabValue" value="{{$tabValue}}" style="display: none;">
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
        var menubarTab = document.getElementsByClassName('menubar-tab');

        window.onload = function() {
            Array.prototype.forEach.call(menubarTab, function(item){
                var items = item.parentElement.children;
                var contents = item.parentElement.parentElement.parentElement.parentElement.children[1].children;
                item.addEventListener('click', function(){
                    if (!item.classList.contains('active')) {
                        item.classList.add('active');
                        for (i=0;i<items.length;i++) {
                            if (items[i]==item && !contents[i].classList.contains('active')) {
                                contents[i].classList.add('active');
                            }
                            if (items[i]!=item && items[i].classList.contains('active')) {
                                items[i].classList.remove('active');
                                contents[i].classList.remove('active');
                            }
                        }
                    }
                });
            });
        };
        $('#all-select').click(function () {
            $('.select-area-input').prop('checked', !$('.select-area-input').prop('checked'));
        });
        $('#statisticsView').click(function (e) {
            e.preventDefault();
            $('#topPage').removeClass('active');
            $('#topTab').removeClass('active');
            $('#statisticsPage').addClass('active');
            $('#dataTab').addClass('active');
        });
        $('#reportView').click(function (e) {
            e.preventDefault();
            $('#topPage').removeClass('active');
            $('#topTab').removeClass('active');
            $('#reportPage').addClass('active');
            $('#reportTab').addClass('active');
        });
        $('.file-download-btn').click(function (e) {
            e.preventDefault();
            $('#reportDownloadBtn').click();
            return false;
        });
        $(document).ready(function() {
            $('.file-download-btn').prop('disabled', true);
            $('.file-download-btn').css('cursor', 'not-allowed');
            $('input[type="checkbox"]').click(function() {
                var checked = $("form input[type=checkbox]:checked").length;
                if(checked > 0){
                    $('.file-download-btn').prop('disabled', false);
                    $('.file-download-btn').css('cursor', 'pointer');
                }
                else {
                    $('.file-download-btn').prop('disabled', true);
                    $('.file-download-btn').css('cursor', 'not-allowed');
                }
            });
            if($('input[name="tabValue"]').val() == 1) {
                $('#topPage').removeClass('active');
                $('#topTab').removeClass('active');
                $('#reportPage').addClass('active');
                $('#reportTab').addClass('active');
            }
        });
    </script>
@stop