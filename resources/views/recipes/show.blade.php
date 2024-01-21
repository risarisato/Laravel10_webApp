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
  <!-- ログインしないとレビューできない機能 -->
  @guest
    <p class="text-center text-gray-500">レビューを投稿するには<a href="{{ route('login') }}" class="text-green-500">ログイン</a>してください。</p>
  @endguest
  @auth
  <!-- reviewsレビュー機能 -->
  <div class="w-10/12 p-4 mx-auto bg-white rounded mb-6">
    <form action="{{ route('review.store', ['id' => $recipe['id']]) }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">
          評価
        </label>
        <select name="rating" id="rating" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded">
          <option value="1">1点</option>
          <option value="2">2点</option>
          <option value="3" selected>3点</option>
          <option value="4">4点</option>
          <option value="5">5点</option>
        </select>
      </div>
    <div class="mb-4">
        <label for="comment" class="sr-only">コメント</label>
        <textarea name="comment" id="comment" cols="30" rows="10" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('comment') border-red-500 @enderror" placeholder="コメントを入力してください"></textarea>
      </div>
      <div>
        <button type="submit" class="bg-green-500 text-white px-4 py-3 rounded font-medium w-full">レビューを投稿する</button>
      </div>
    </form>
  </div>
  @endauth
    <!-- レビューの表示 -->
    <h4 class="text-2xl font-bold mb-2">レビュー</h4>
    <h6 class="text-gray-500 mb-4">show.blade.phpの&#64;guestから&#64;endauthを消せば誰でも投稿可能</h6>
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