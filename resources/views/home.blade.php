<!-- x-app-layoutは全体 -->
<x-app-layout>
  <!-- gridはグリッドレイアウトのcolsは列数を指定 -->
  <div class="grid grid-cols-4">
    <!-- col-span-1は1列分の幅を指定 -->
    <div class="col-span-1 bg-white rounded p-4">
      <h3 class="text-2xl font-bold mb-2">レシピ検索</h3>
      <ul class="ml-6 mb-4">
        <li><a href="">すべてのレシピ</a></li>
        <li><a href="">人気のレシピ</a></li>
      </ul>
      <h3 class="text-2xl font-bold mb-2">レシピ投稿</h3>
      <ul class="ml-6 mb-4">
        <li><a href="">すべてのレシピ</a></li>
        <li><a href="">人気のレシピ</a></li>
      </ul>
    </div>
    <!-- col-span-2は2列分の幅を指定 -->
    <div class="col-span-2 bg-white rounded p-4">
      2
    </div>
    <!-- col-span-1は1列分の幅を指定 -->
    <div class="col-span-1 bg-gray ml-4">
      1
    </div>
  </div>
</x-app-layout>