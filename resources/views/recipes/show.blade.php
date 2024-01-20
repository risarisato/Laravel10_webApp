<x-app-layout>
  <div class="w-10/12 p-4 mx-auto bg-white rounded">
    {{ Breadcrumbs::render('show', $recipe) }}
    <!-- レシピの詳細 -->
    <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
      <div class="col-span-1">
        <img class="object-cover w-full aspect-square" src="{{$recipe['image']}}" alt="{{$recipe['title']}}"> 
      </div>
      <div class="col-span-1 p-4">
        <p class="mb-4">{{ $recipe['description'] }}</p>  
        <p class="mb-4 text-gray-500">{{ $recipe['user']['name'] }}</p>
        <h4 class="text-2xl font-bold mb-2">材料</h4>
        <ul class="text-gray-500 ml-500">
      @foreach($recipe['ingredients'] as $ingredient)
        <li>{{ $ingredient['name']}}:{{$ingredient['quantity']}}</li>
      @endforeach
      </ul>
      </div>
    </div>
    <br>
    <div class="">
      <h4 class="text-2xl font-bold mb-6">作り方</h4>
        <div class="grid grid-cols-4 gap-4">
      @foreach($recipe['steps'] as $step)
          <div class="mb-2 background-color p-2">
            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full mr-4 mb-2">
            {{ $step['step_number'] }}
            </div>
            <p>{{ $step['description']}}</p>
          </div>
      @endforeach
        </div>
      </div>
    </div>
    <!-- 投稿者ならば編集ボタン表示 -->
  @if($is_my_recipe)
  <a href="{{ route('recipe.edit', ['id' => $recipe['id']]) }}" class="block w-2/12 p-4 my-4 mx-auto bg-white rounded text-center text-green-500 border border-green-500 hover:bg-green-500 hover:text-white">編集する</a>
  @endif
  <!-- reviews -->
  <div class="w-10/12 p-4 mx-auto bg-white rounded">
    <h4 class="text-2xl font-bold mb-2">レビュー</h4>
    @if( count($recipe['reviews']) === 0 )
      <p>レビューはまだありません。</p>
    @endif
    @foreach($recipe['reviews'] as $review)
      <div class="background-color rounded mb-4 p-4">
        <div class="flex mb-4">
      @for($i = 0; $i < $review['rating']; $i++) 
        <svg class="w-6 h-6 text-yellow-500 fill-current" viewBox="0 0 24 24">
          <path d="M12 2.69l2.76 6.3 6.22.54-4.72 4.47 1.4 6.2L12 17.77l-5.66 3.43 1.4-6.2L3.02 9.53l6.22-.54L12 2.69z"/> 
        {{ $review['rating'] }}
        </svg>
      @endfor
        <p class="ml-2">{{ $review['comment']}}</p>
      </div>
      <p class="text-gray-600 font-bold">{{ $review['user']['name'] }}</p>
    </div>
    @endforeach
  </div>
</x-app-layout>