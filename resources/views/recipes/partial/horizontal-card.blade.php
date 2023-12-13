<!-- flexはflexboxを使うという意味 -->
<a href="" class="flex flex-col items-center bg-white mb-6 border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100">
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
