<!-- x-app-layoutは全体 -->
<x-app-layout>
  <!-- gridはグリッドレイアウトのcolsは列数を指定 -->
  <div class="grid grid-cols-4 mb-6">
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
      <h2 class="text-2xl font-bold mb-2">新着レシピ</h2>
      <!-- foreachで配列を回す -->
  @foreach($recipes as $recipe)
      <!-- flexはflexboxを使うという意味 -->
      <a href="{{ route('recipe.show',['id' => $recipe['id']]) }}" class="flex flex-col items-center bg-white mb-6 border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100">
        <!-- object-coverは画像を縦横比を維持したまま親要素いっぱいに表示する -->
        <img class="object-cover rounded-t-lg h-40 w-40 mrounded-none rounded-l-lg" src="{{$recipe->image}}" alt="{{$recipe->title}}">
        <!-- flex-growはflexboxの要素を伸ばす -->
        <div class="flex flex-col justify-between p-4 leading-normal">
          <!-- mbはmargin-bottomの略 -->
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">{{$recipe->title}}</h5>
          <p class="mb-3 font-normal">{{ $recipe->description }}</p>
          <div class="flex">
            <p class="font-bold mr-2">{{$recipe->name}}</p>
            <!-- text-gray-500は文字色をグレーにする、formatは日付をフォーマットする -->
            <p class="text-gray-500">{{$recipe->created_at->format('Y年m月d日')}}</p>
          </div>
        </div>
      </a>
  @endforeach
      <a href="{{ route('recipe.index') }}" class="text-gray-600 block text-right">すべてのレシピへ ></a>
    </div>
    <div class="col-span-1 bg-gray ml-4">
      <img src="/images/ad002.jpg" alt="広告002">
      <img src="/images/ad.jpg" alt="広告">
    </div>
  </div>
  <div class="grid grid-cols-4">
    <div class="col-span-3 bg-white rounded p-4">
    <h2 class="text-2xl font-bold mb-2">人気レシピ</h2>
      <div class="flex justify-between items-center mb-6">
  @foreach($popular as $populars)
        <a herf="{{ route('recipe.show', ['id' => $recipe['id']]) }}" class="max-12 rounded overflow-hidden shadow-lg mx-4">
          <img class="max-h-44 h-44 w-full object-cover" src="{{$populars->image}}" alt="{{$populars->title}}">
          <div class="px-6 py-4">
            <div class="font-bold text-large mb-2">{{$populars->title}}</div>
            <p class="text-gray-700 text-base">{{$populars->description}}</p>
          </div>
        </a>
  @endforeach
      </div>
      <a href="" class="text-gray-600 block text-right">すべての人気レシピへ ></a>
    </div>
    <div class="col-span-1"></div>
  </div>
</x-app-layout>