<x-app-layout>
    {{--
      <!--  $headerという変数でレイアウトファイルに渡される -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("あなたはログイン中ですよー！") }}
            <table>
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>パスワード</th>
                </tr>
                <tr>
                    <td>田中 太郎</td>
                    <td>test@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>鈴木 次郎</td>
                    <td>suzuki@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>佐藤 三郎</td>
                    <td>sato@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>高橋 四郎</td>
                    <td>takahashi@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>小林 五郎</td>
                    <td>kobayashi@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>吉田 六郎</td>
                    <td>yoshida@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>伊藤 七郎</td>
                    <td>ito@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>渡辺 八郎</td>
                    <td>watanabe@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>加藤 九郎</td>
                    <td>kato@example.com</td>
                    <td>password</td>
                </tr>
                <tr>
                    <td>山田 十郎</td>
                    <td>yamada@example.com</td>
                    <td>password</td>
                </tr>
            </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
