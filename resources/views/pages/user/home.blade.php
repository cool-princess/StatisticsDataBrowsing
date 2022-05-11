@extends('layouts.custom')

@section('content')
    <section id="user_top" class="top">
        <div class="container">
            <div class="header">
                <div class="navbar">
                    <h1>
                        ジブリパーク周遊観光促進事業<br>
                        <span>チケット購入統計データ提供サイト</span>
                    </h1>
                </div>
                <div class="menubar">
                    <div class="menubar-group">
                        <a href="#" class="menubar-tab active" data-rel="#topTab">
                            TOP
                        </a href="#">
                        <a href="#" class="menubar-tab" data-rel="#dataTab" id="dataAddTab">
                            DATA閲覧
                        </a href="#">
                        <a href="#" class="menubar-tab" data-rel="#reportTab" id="reportAddTab">
                            レポート
                        </a href="#">
                        <a href="#" class="menubar-tab" data-rel="#contactTab">
                            お問い合わせ
                        </a href="#">
                    </div>
                    <a href="{{ route('userLogout') }}" class="menubar-btn">
                        ログアウト
                    </a>
                </div>
            </div>
            <div class="wrap">
                <div class="wrapper active" id="topTab">
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
                                                {{$item->created_at->format('Y-m-d H:i')}}
                                            </div>
                                            <div class="news-item-title">
                                                {!! nl2br(e($item->title)) !!}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="news-item-none">
                                            お知らせかありません。
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="main-others-part">
                                <div class="main-others-item">
                                    <div class="main-others-item-title">
                                        DATA閲覧
                                    </div>
                                    <div class="main-others-item-content">
                                        Boo-Wooチケットの購入データをもとに、ジブリパークチケット購入者の属性を統計データで閲覧できるページです。
                                    </div>
                                    <a href="#" id="statisticsView">統計データを見る</a>
                                </div>
                                <div class="main-others-item">
                                    <div class="main-others-item-title">
                                        レポート
                                    </div>
                                    <div class="main-others-item-content">
                                        ジブリパーク来場者に向けての観光商品造成やPR活動戦略に役立つレポートをダウンロードできるページです。
                                    </div>
                                    <a href="#" id="reportView">統計データをダウンロードする</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper" id="dataTab">
                    <div class="navbar-main">
                        <div class="navbar-main-explanation">
                            Boo-Wooチケットの購入データをもとにしたチケット購入者属性を統計データで閲覧できます。<br><br>
                            ［使い方］<br>
                            来場期間やエリアを選択して、「データ表示」のボタンを押してください。<br>
                            チケット購入者の属性（性別・居住地など）の統計系データが表示されます。
                        </div>
                        <div class="navbar-main-search-part">
                            <div class="navbar-main-search-part-wrap">
                                <form method="get" action="{{ route('dataSearchGet') }}">
                                    <div class="navbar-main-search-title">
                                        SEARCH
                                    </div>
                                    <div class="navbar-main-search-date">
                                        <select name="start_year" id="start_year">
                                            @for ($i = 2022; $i <= now()->year; $i++)
                                                @if ($i == now()->year)
                                                    <option value="{{ $i }}" selected>{{ $i }}年</option>
                                                @else
                                                    <option value="{{ $i }}">{{ $i }}年</option>
                                                @endif
                                            @endfor
                                        </select>
                                        <select name="start_month" id="start_month">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}月</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="navbar-main-search-arrow"></div>
                                    <div class="navbar-main-search-date">
                                        <select name="end_year" id="end_year">
                                            @for ($i = 2022; $i <= now()->year; $i++)
                                                @if ($i == now()->year)
                                                    <option value="{{ $i }}" selected>{{ $i }}年</option>
                                                @else
                                                    <option value="{{ $i }}">{{ $i }}年</option>
                                                @endif
                                            @endfor
                                        </select>
                                        <select name="end_month" id="end_month">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}月</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button id="all-select" class="navbar-main-input-all-select" type="button">
                                        全てのエリアを選択
                                    </button>
                                    <label class="navbar-main-area-select custom-input">
                                        青春の丘エリア<input type="checkbox" name="select_area[]" class="select-area-input" value="青春の丘エリア">
                                        <span class="checkmark"></span>
                                    </label>
                                    <!-- <label class="navbar-main-area-select custom-input">
                                        もののけの里エリア<input type="checkbox" name="select_area[]" class="select-area-input" value="もののけの里エリア">
                                        <span class="checkmark"></span>
                                    </label> -->
                                    <label class="navbar-main-area-select custom-input">
                                        ジブリの大倉庫エリア<input type="checkbox" name="select_area[]" class="select-area-input" value="ジブリの大倉庫エリア">
                                        <span class="checkmark"></span>
                                    </label>
                                    <!-- <label class="navbar-main-area-select custom-input">
                                        魔女の谷里エリア<input type="checkbox" name="select_area[]" class="select-area-input" value="魔女の谷里エリア">
                                        <span class="checkmark"></span>
                                    </label> -->
                                    <label class="navbar-main-area-select custom-input">
                                        どんどこ森エリア<input type="checkbox" name="select_area[]" class="select-area-input" value="どんどこ森エリア">
                                        <span class="checkmark"></span>
                                    </label>
                                    <button type="submit" class="navbar-main-search-display">データ表示</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mainbar">
                        <div class="main-body">
                            <div class="main-title">DATA閲覧</div>
                            <div class="main-area-explanation">
                                ※数値は％です。
                            </div>
                            <div class="main-part01">
                                <div class="main-part01-ages">
                                    <div class="main-part-title">
                                        年代
                                    </div>
                                    <div class="main-part01-ages-body">
                                        <div class="main-part01-ages-item ages10">
                                            <div class="main-part01-ages-item-num01">10才<br>未満</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_10"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[0], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages20">
                                            <div class="main-part01-ages-item-num01">20才</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_20"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[1], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages30">
                                            <div class="main-part01-ages-item-num01">30才</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_30"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[2], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages40">
                                            <div class="main-part01-ages-item-num01">40才</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_40"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[3], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages50">
                                            <div class="main-part01-ages-item-num01">50才</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_50"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[4], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages60">
                                            <div class="main-part01-ages-item-num01">60才</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_60"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[5], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages70">
                                            <div class="main-part01-ages-item-num01">70才</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_70"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[6], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part01-ages-item ages80">
                                            <div class="main-part01-ages-item-num01">80才<br>以上</div>
                                            <div class="main-part01-ages-item-progressbar"><span id="ages_80"></span><div class="main-part01-ages-item-num02">{{ number_format((float)$age_rate[7], 1, '.', '') }}%</div></div>
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
                                                    {{ number_format((float)$sex_rate, 1, '.', '') }}%
                                                </div>
                                            </div>
                                            <div class="sex-item">
                                                <div class="sex-item-en">
                                                    Women
                                                </div>
                                                <div class="sex-item-pros">
                                                    {{ number_format((float)(100 - $sex_rate), 1, '.', '') }}%
                                                </div>
                                            </div>
                                            <div class="pie-wrapper-after"></div>
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
                                                購入枚数
                                            </div>
                                            <div class="main-part02-ticket-item ticket1">
                                                <div class="main-part02-ticket-item-num01">1</div>
                                                <div class="main-part02-ticket-item-progressbar"><span id="all_ticket1"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$all_ticket_rate[1], 1, '.', '') }}%</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket2">
                                                <div class="main-part02-ticket-item-num01">2</div>
                                                <div class="main-part02-ticket-item-progressbar"><span id="all_ticket2"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$all_ticket_rate[2], 1, '.', '') }}%</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket3">
                                                <div class="main-part02-ticket-item-num01">3</div>
                                                <div class="main-part02-ticket-item-progressbar"><span id="all_ticket3"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$all_ticket_rate[3], 1, '.', '') }}%</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket4">
                                                <div class="main-part02-ticket-item-num01">4</div>
                                                <div class="main-part02-ticket-item-progressbar"><span id="all_ticket4"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$all_ticket_rate[4], 1, '.', '') }}%</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket5">
                                                <div class="main-part02-ticket-item-num01">5</div>
                                                <div class="main-part02-ticket-item-progressbar"><span id="all_ticket5"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$all_ticket_rate[5], 1, '.', '') }}%</div></div>
                                            </div>
                                            <div class="main-part02-ticket-item ticket6">
                                                <div class="main-part02-ticket-item-num01">6</div>
                                                <div class="main-part02-ticket-item-progressbar"><span id="all_ticket6"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$all_ticket_rate[6], 1, '.', '') }}%</div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-part02-ticket-subpart ratio">
                                        <div class="main-part02-ticket-subpart-title">
                                            小人同時購入比率
                                        </div>
                                        <div class="main-part02-ticket-item">
                                            <div class="main-part02-ticket-item-progressbar"><span id="adult_young_rate"></span><div class="main-part02-ticket-item-num02">{{ number_format((float)$adult_young_rate, 1, '.', '') }}%</div></div>
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
                                            <div class="main-part03-area-item-progressbar"><span id="location1"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[0], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">青森県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location2"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[1], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">岩手県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location3"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[2], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">宮城県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location4"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[3], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">秋田県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location5"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[4], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">山形県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location6"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[5], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">福島県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location7"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[6], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">茨城県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location8"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[7], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">栃木県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location9"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[8], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">群馬県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location10"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[9], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">埼玉県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location11"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[10], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">千葉県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location12"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[11], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">東京都</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location13"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[12], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">神奈川県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location14"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[13], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">新潟県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location15"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[14], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">富山県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location16"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[15], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">石川県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location17"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[16], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">福井県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location18"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[17], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">山梨県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location19"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[18], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">長野県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location20"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[19], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">岐阜県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location21"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[20], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">静岡県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location22"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[21], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">愛知県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location23"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[22], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">三重県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location24"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[23], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">滋賀県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location25"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[24], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">京都府</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location26"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[25], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">大阪府</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location27"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[26], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">兵庫県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location28"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[27], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">奈良県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location29"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[28], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">和歌山県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location30"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[29], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">鳥取県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location31"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[30], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">島根県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location32"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[31], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">岡山県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location33"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[32], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">広島県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location34"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[33], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">山口県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location35"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[34], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">徳島県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location36"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[35], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">香川県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location37"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[36], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">愛媛県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location38"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[37], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">高知県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location39"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[38], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">福岡県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location40"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[39], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">佐賀県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location41"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[40], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">長崎県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location42"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[41], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">熊本県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location43"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[42], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">大分県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location44"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[43], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">宮崎県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location45"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[44], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">鹿児島県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location46"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[45], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                            <div class="main-part03-area-item-num01">沖縄県</div>
                                            <div class="main-part03-area-item-progressbar"><span id="location47"></span><div class="main-part03-area-item-num02">{{ number_format((float)$location_rate[46], 1, '.', '') }}%</div></div>
                                        </div>
                                        <div class="main-part03-area-item">
                                        </div>
                                    </div>
                                    <div class="main-part03-area-explanation">
                                        ※数値は％です。
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper" id="reportTab">
                    <div class="navbar-main">
                        <div class="navbar-main-explanation">
                            ジブリパーク来場者に向けての観光商品造成やPR活動戦略に役立つレポートをダウンロードできるページです。
                        </div>
                        <div class="navbar-main-download-part">
                            <div class="navbar-main-download-part-wrap">
                                <button class="file-download-btn">ファイルダウンロード</button>
                                <p>右からレポートを選んで、上のボタンを押してください。<br><br>
                                    一度に選択できるファイルは10個までです。<br>
                                    11個以上ダウンロードする場合は、複数回に分けてダウンロードして下さい。</p>
                            </div>
                        </div>
                    </div>
                    <div class="mainbar">
                        <div class="main-body custom-report-bg">
                            <div class="main-title">REPORT</div>
                            <div class="main-report-part">
                                <div class="main-report-filter">
                                    <!-- <div class="main-report-filter-item">
                                        絞り込みA
                                    </div>
                                    <div class="main-report-filter-item">
                                        絞り込みB
                                    </div>
                                    <div class="main-report-filter-item">
                                        絞り込みC
                                    </div> -->
                                </div>
                                <div class="main-report-body"> 
                                    <form method="post" action="{{ route('reportDownloadPost', ['download'=>'zip']) }}" enctype="multipart/form-data" id="reportCheckbox">
                                        @csrf
                                        @forelse($files as $file)
                                            <div class="main-report-item">
                                                <div class="main-report-item-wrap">
                                                    <div class="main-report-item-date">
                                                        {{$file->created_at->toDateString()}}
                                                    </div>
                                                    <div class="main-report-item-title">
                                                        {{$file->reporter}}
                                                    </div>
                                                </div>
                                                <label class="main-report-item-checkbox custom-input">
                                                    {{$file->display_name}}<input type="checkbox" name="fileId[]" value="{{$file->id}}">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        @empty
                                            <div class="main-report-none">
                                                レポートデータかありません。
                                            </div>
                                        @endforelse
                                        <button type="submit" id="reportDownloadBtn" style="display: none"></button>
                                    </form>
                                </div>
                                <div class="main-report-pagination main-pagination">
                                    @if($files->currentPage() != 1)
                                        <a href="{{ $files->previousPageUrl() }}" class="main-pagination-prev btn-primary">前のページへ</a>
                                    @endif
                                    @if($files->total() > 20)
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
                <div class="wrapper" id="contactTab">
                    <div class="navbar-main">
                        <div class="navbar-main-content">何かご不明点などがございましたら右記お問い合わせフォームよりお申しつけくださいませ。</div>
                    </div>
                    <div class="mainbar">
                        <div class="main-body">
                        <div class="main-title">CONTACT</div>
                            <div class="contact-part">
                                <form method="POST" action="{{route('contactPost')}}">
                                    @csrf
                                    <input type="text" name="subject" value="お問い合わせ" style="display: none;">
                                    <input type="text" required name="to" value="{{getenv('MAIL_FROM_ADDRESS')}}" style="display: none;">
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            姓（※）
                                        </div>
                                        <div class="contact-item-right">
                                            <input type="text" name="surname" required>
                                            @if ($errors->has('surname'))
                                                <span class="invalid-feedback">{{ $errors->first('surname') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            名
                                        </div>
                                        <div class="contact-item-right">
                                            <input type="text" name="name">
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            法人名
                                        </div>
                                        <div class="contact-item-right">
                                            <input type="text" name="company_name">
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            担当部署名
                                        </div>
                                        <div class="contact-item-right">
                                            <input type="text" name="department_name">
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            ご住所（※）
                                        </div>
                                        <div class="contact-item-right">
                                            <select name="address1" id="address1" required>
                                                <option value="">県を選択</option>
                                                <option value="北海道">北海道</option>
                                                <option value="青森県">青森県</option>
                                                <option value="岩手県">岩手県</option>
                                                <option value="宮城県">宮城県</option>
                                                <option value="秋田県">秋田県</option>
                                                <option value="山形県">山形県</option>
                                                <option value="福島県">福島県</option>
                                                <option value="茨城県">茨城県</option>
                                                <option value="栃木県">栃木県</option>
                                                <option value="群馬県">群馬県</option>
                                                <option value="埼玉県">埼玉県</option>
                                                <option value="千葉県">千葉県</option>
                                                <option value="東京都">東京都</option>
                                                <option value="神奈川県">神奈川県</option>
                                                <option value="新潟県">新潟県</option>
                                                <option value="富山県">富山県</option>
                                                <option value="石川県">石川県</option>
                                                <option value="福井県">福井県</option>
                                                <option value="山梨県">山梨県</option>
                                                <option value="長野県">長野県</option>
                                                <option value="岐阜県">岐阜県</option>
                                                <option value="静岡県">静岡県</option>
                                                <option value="愛知県">愛知県</option>
                                                <option value="三重県">三重県</option>
                                                <option value="滋賀県">滋賀県</option>
                                                <option value="京都府">京都府</option>
                                                <option value="大阪府">大阪府</option>
                                                <option value="兵庫県">兵庫県</option>
                                                <option value="奈良県">奈良県</option>
                                                <option value="和歌山県">和歌山県</option>
                                                <option value="鳥取県">鳥取県</option>
                                                <option value="島根県">島根県</option>
                                                <option value="岡山県">岡山県</option>
                                                <option value="広島県">広島県</option>
                                                <option value="山口県">山口県</option>
                                                <option value="徳島県">徳島県</option>
                                                <option value="香川県">香川県</option>
                                                <option value="愛媛県">愛媛県</option>
                                                <option value="高知県">高知県</option>
                                                <option value="福岡県">福岡県</option>
                                                <option value="佐賀県">佐賀県</option>
                                                <option value="長崎県">長崎県</option>
                                                <option value="熊本県">熊本県</option>
                                                <option value="大分県">大分県</option>
                                                <option value="宮崎県">宮崎県</option>
                                                <option value="鹿児島県">鹿児島県</option>
                                                <option value="沖縄県">沖縄県</option>
                                            </select>
                                            @if ($errors->has('address1'))
                                                <span class="invalid-feedback">{{ $errors->first('address1') }}</span>
                                            @endif
                                            <input type="text" name="address2" required>
                                            @if ($errors->has('address2'))
                                                <span class="invalid-feedback">{{ $errors->first('address2') }}</span>
                                            @endif
                                            <input type="text" name="address3">
                                            <input type="text" name="address4">
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            電話番号
                                        </div>
                                        <div class="contact-item-right">
                                            <input type="text" name="phone">
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            メールアドレス（※）
                                        </div>
                                        <div class="contact-item-right">
                                            <input type="email" name="email" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <div class="contact-item-left">
                                            お問い合わせ内容（※）
                                        </div>
                                        <div class="contact-item-right">
                                            <textarea name="comment" id="comment" required></textarea>
                                            <p>400文字入力できます</p>
                                            @if ($errors->has('comment'))
                                                <span class="invalid-feedback">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="contact-btn">送信する</button>
                                </form>
                            </div>
                        </div>
                    </di>
                </div>
            </div>
            <div class="footer">
                @include('includes.footer')
            </div>
            <div id="report-exceed" class="modal">
                <div class="modal-content">
                    <h1>一度に選択できるファイル数は10個までです。</h1>
                    <a href="#" class="modal-close">&times;</a>
                </div>
            </div>
        </div>
    </section>
    <script>
        var menubarTab = document.getElementsByClassName('menubar-tab');
        var newsItem = document.getElementsByClassName('news-item');

        $(".menubar-tab").click(function(e) {
            e.preventDefault();
            setContent($(this));
            localStorage.setItem('active-container', $(this).data('rel'));
        });

        $('#statisticsView').click(function (e) {
            e.preventDefault();
            setContent($('#dataAddTab'));
            localStorage.setItem('active-container', $('#dataAddTab').data('rel'));
        });

        $('#reportView').click(function (e) {
            e.preventDefault();
            setContent($('#reportAddTab'));
            localStorage.setItem('active-container', $('#reportAddTab').data('rel'));
        });

        localStorage.getItem('active-container') && setContent($('.menubar-tab[data-rel="' + localStorage.getItem('active-container') + '"]'));

        function setContent($el) {
            $('.menubar-tab').removeClass('active');
            $('.wrapper').removeClass('active');

            $el.addClass('active');
            $($el.data('rel')).addClass('active');
        }

        window.onload = function() {
            Array.prototype.forEach.call(newsItem, function(item){
                var items = item.parentElement.children;
                item.addEventListener('click', function(){
                    if (!item.classList.contains('active')) {
                        item.classList.add('active');
                    }
                    else {
                        item.classList.remove('active');
                    }
                });
            });
        };
        $('#all-select').click(function () {
            $('.select-area-input').prop('checked', !$('.select-area-input').prop('checked'));
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
            var ages_rate = {{ json_encode($age_rate) }};
            var max_ages_rate = Math.max(ages_rate[0], ages_rate[1], ages_rate[2], ages_rate[3], ages_rate[4], ages_rate[5], ages_rate[6], ages_rate[7]);
            $('#ages_10').css('width', 100 * ages_rate[0] / max_ages_rate + '%');
            $('#ages_20').css('width', 100 * ages_rate[1] / max_ages_rate + '%');
            $('#ages_30').css('width', 100 * ages_rate[2] / max_ages_rate + '%');
            $('#ages_40').css('width', 100 * ages_rate[3] / max_ages_rate + '%');
            $('#ages_50').css('width', 100 * ages_rate[4] / max_ages_rate + '%');
            $('#ages_60').css('width', 100 * ages_rate[5] / max_ages_rate + '%');
            $('#ages_70').css('width', 100 * ages_rate[6] / max_ages_rate + '%');
            $('#ages_80').css('width', 100 * ages_rate[7] / max_ages_rate + '%');
            var sex_rate = {{ json_encode($sex_rate) }};
            if(sex_rate < 50)
            {
                $('.pie-wrapper-after').addClass('active');
                $('.pie-wrapper-after').css('transform', 'rotate('+ (50 - sex_rate) * 3.6 +'deg)');
            }
            else {
                $('.pie-wrapper-after').removeClass('active');
                $('.pie-wrapper-after').css('transform', 'rotate(-'+ (180 - (50 - sex_rate) * 3.6) +'deg)');
            }
            var all_ticket_rate = {{ json_encode($all_ticket_rate) }};
            var max_all_ticket_rate = all_ticket_rate[0] || null;
            var all_ticket_number = null;
            for (var i = 0; i < all_ticket_rate.length; i++) {
                all_ticket_number = all_ticket_rate[i];
                max_all_ticket_rate = Math.max(max_all_ticket_rate, all_ticket_number);
            }
            var adult_young_rate = {{ json_encode($adult_young_rate) }};
            $('#all_ticket1').css('width', 100 * all_ticket_rate[1] / max_all_ticket_rate + '%');
            $('#all_ticket2').css('width', 100 * all_ticket_rate[2] / max_all_ticket_rate + '%');
            $('#all_ticket3').css('width', 100 * all_ticket_rate[3] / max_all_ticket_rate + '%');
            $('#all_ticket4').css('width', 100 * all_ticket_rate[4] / max_all_ticket_rate + '%');
            $('#all_ticket5').css('width', 100 * all_ticket_rate[5] / max_all_ticket_rate + '%');
            $('#all_ticket6').css('width', 100 * all_ticket_rate[6] / max_all_ticket_rate + '%');
            $('#adult_young_rate').css('width', adult_young_rate + '%');
            var location_rate = {{ json_encode($location_rate) }};
            var max_location_rate = location_rate[0] || null;
            var location_number = null;
            for (var i = 0; i < location_rate.length; i++) {
                location_number = location_rate[i];
                max_location_rate = Math.max(max_location_rate, location_number);
            }
            $('#location1').css('width', 100 * location_rate[0] / max_location_rate + '%');
            $('#location2').css('width', 100 * location_rate[1] / max_location_rate + '%');
            $('#location3').css('width', 100 * location_rate[2] / max_location_rate + '%');
            $('#location4').css('width', 100 * location_rate[3] / max_location_rate + '%');
            $('#location5').css('width', 100 * location_rate[4] / max_location_rate + '%');
            $('#location6').css('width', 100 * location_rate[5] / max_location_rate + '%');
            $('#location7').css('width', 100 * location_rate[6] / max_location_rate + '%');
            $('#location8').css('width', 100 * location_rate[7] / max_location_rate + '%');
            $('#location9').css('width', 100 * location_rate[8] / max_location_rate + '%');
            $('#location10').css('width', 100 * location_rate[9] / max_location_rate + '%');
            $('#location11').css('width', 100 * location_rate[10] / max_location_rate + '%');
            $('#location12').css('width', 100 * location_rate[11] / max_location_rate + '%');
            $('#location13').css('width', 100 * location_rate[12] / max_location_rate + '%');
            $('#location14').css('width', 100 * location_rate[13] / max_location_rate + '%');
            $('#location15').css('width', 100 * location_rate[14] / max_location_rate + '%');
            $('#location16').css('width', 100 * location_rate[15] / max_location_rate + '%');
            $('#location17').css('width', 100 * location_rate[16] / max_location_rate + '%');
            $('#location18').css('width', 100 * location_rate[17] / max_location_rate + '%');
            $('#location19').css('width', 100 * location_rate[18] / max_location_rate + '%');
            $('#location20').css('width', 100 * location_rate[19] / max_location_rate + '%');
            $('#location21').css('width', 100 * location_rate[20] / max_location_rate + '%');
            $('#location22').css('width', 100 * location_rate[21] / max_location_rate + '%');
            $('#location23').css('width', 100 * location_rate[22] / max_location_rate + '%');
            $('#location24').css('width', 100 * location_rate[23] / max_location_rate + '%');
            $('#location25').css('width', 100 * location_rate[24] / max_location_rate + '%');
            $('#location26').css('width', 100 * location_rate[25] / max_location_rate + '%');
            $('#location27').css('width', 100 * location_rate[26] / max_location_rate + '%');
            $('#location28').css('width', 100 * location_rate[27] / max_location_rate + '%');
            $('#location29').css('width', 100 * location_rate[28] / max_location_rate + '%');
            $('#location30').css('width', 100 * location_rate[29] / max_location_rate + '%');
            $('#location31').css('width', 100 * location_rate[30] / max_location_rate + '%');
            $('#location32').css('width', 100 * location_rate[31] / max_location_rate + '%');
            $('#location33').css('width', 100 * location_rate[32] / max_location_rate + '%');
            $('#location34').css('width', 100 * location_rate[33] / max_location_rate + '%');
            $('#location35').css('width', 100 * location_rate[34] / max_location_rate + '%');
            $('#location36').css('width', 100 * location_rate[35] / max_location_rate + '%');
            $('#location37').css('width', 100 * location_rate[36] / max_location_rate + '%');
            $('#location38').css('width', 100 * location_rate[37] / max_location_rate + '%');
            $('#location39').css('width', 100 * location_rate[38] / max_location_rate + '%');
            $('#location40').css('width', 100 * location_rate[39] / max_location_rate + '%');
            $('#location41').css('width', 100 * location_rate[40] / max_location_rate + '%');
            $('#location42').css('width', 100 * location_rate[41] / max_location_rate + '%');
            $('#location43').css('width', 100 * location_rate[42] / max_location_rate + '%');
            $('#location44').css('width', 100 * location_rate[43] / max_location_rate + '%');
            $('#location45').css('width', 100 * location_rate[44] / max_location_rate + '%');
            $('#location46').css('width', 100 * location_rate[45] / max_location_rate + '%');
            $('#location47').css('width', 100 * location_rate[46] / max_location_rate + '%');
            var $checkboxes = $('#reportCheckbox input[type="checkbox"]');
            $checkboxes.change(function(){
                var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                if(countCheckedCheckboxes > 10) {
                    document.querySelector(".modal").style.visibility = "visible";
                    document.querySelector(".modal").style.opacity = "1";
                }
            });

            function closeModal() {
                document.querySelector(".modal").style.visibility = "hidden";
                document.querySelector(".modal").style.opacity = "0";
            }

            document.addEventListener("click", function(event) {
                    if (event.target.matches(".modal-close") || !event.target.closest(".modal-content")) {
                        closeModal();
                    }
                },
                    false
            );

            var search_data = {{ json_encode($search_data) }};
            if(search_data[0] != 0) {
                $('#start_year').val(search_data[0]);
                $('#start_month').val(search_data[0]);
            }
            if(search_data[1] != 0) {
                $('#end_year').val(search_data[1]);
                $('#end_month').val(search_data[1]);
            }
            if(search_data[2] != 0) {
                // $('name="select_area[]"').val(search_data[2]);
            }
        });
        $('#comment').keypress(function(e) {
            var tval = $('#comment').val(),
                tlength = tval.length,
                set = 400,
                remain = parseInt(set - tlength);
            if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                $('#comment').val((tval).substring(0, tlength - 1));
                return false;
            }
        });
    </script>
@stop