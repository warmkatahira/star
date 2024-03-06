@vite(['resources/sass/navigation.scss'])

<nav id="navigation">
    <a href="{{ route('top.index') }}" class="logo">スターデザイン管理システム</a>
    <ul class="links flex">
        <li class="dropdown"><a href="{{ route('management.index') }}" class="trigger-drop">管理</a></li>
        <li class="dropdown"><a href="#" class="trigger-drop">発注</a></li>
        <li class="dropdown"><a href="#" class="trigger-drop">数量交換</a></li>
    </ul>
    <ul class="user_info">
        <li class="dropdown"><a href="#" class="trigger-drop">{{ Auth::user()->user_name.'さん' }}</a>
            <ul class="drop">
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="">ログアウト</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- アラート表示 -->
<x-alert/>