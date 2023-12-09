<!-- ここのファイルをインポートする -->
<!-- flexは横並びのこと -->
<section class="flex bg-white shadow h-10 py-2 border-b-2">
  <!-- containerは、横幅のサイズが自動的に良い感じ調整される -->
  <div class="container mx-auto flex justify-between">
    <p class="">今日も料理が楽しみだ！</p>
    <div class="flex">
  @auth
      <!-- 波括弧２つはphp記述になる。route関数にするとpathが変わっても読み込める -->
      <a href="{{route('profile.edit')}}" class="ml-auto">マイページ</a>
      <!-- <a href="http://localhost/profile" class="ml-auto">マイページ</a> 同じ-->
  @endauth
  @guest
      <a href="{{route('register')}}" class="mr-2">ユーザー登録（無料）</a>
      <a href="{{route('login')}}" class="">ログイン</a>
  @endauth
    </div>
  </div>
</section>