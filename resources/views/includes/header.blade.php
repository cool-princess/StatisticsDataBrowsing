<div class="navbar">
    <h1>
        ジブリパーク周遊観光促進事業<br>
        <span>チケット購入統計データ提供サイト</span>
    </h1>
</div>
<div class="menubar">
    <div class="menubar-group">
        <div class="menubar-name">
            {{ \Auth::guard('admin')->user()->name}}さん
        </div>
    </div>
    <a href="{{ route('adminLogout') }}" class="menubar-btn">
        ログアウト
    </a>
    <!-- <form action="{{ route('adminLogout') }}" id="logout-form" method="post" style="display: none;">@csrf</form> -->
</div>