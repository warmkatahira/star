<x-guest-layout>
    <!-- バリデーションエラー -->
    <x-validation-error-msg />
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- ユーザー名 -->
        <x-auth.input id="user_name" label="ユーザー名" type="text" :db="null" />
        <!-- パスワード -->
        <x-auth.input id="password" label="パスワード" type="password" :db="null" />
        <div class="flex mt-4">
            <button type="submit" class="bg-black text-white text-center rounded-lg py-2 px-5 ml-auto">ログイン</button>
        </div>
    </form>
</x-guest-layout>