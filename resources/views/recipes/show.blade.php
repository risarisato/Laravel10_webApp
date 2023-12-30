<x-app-layout>
  <div class="w-10/12 p-4 mx-auto bg-white rounded">
    {{ Breadcrumbs::render('show', $recipe) }}
    <!-- レシピの詳細 -->
    <div class="grid grid-cols-2 rounded border-black">
      <div class="col-span-1">
        <img class="object-cover rounded-t-lg h-40 w-full mrounded-none rounded-l-lg" src="{{$recipe['image']}}" alt="{{$recipe['title']}}"> 
      </div>
      <div class="col-span-1">
        <p>{{ $recipe['description'] }}</p>  
        <p>{{ $recipe['user']['name'] }}</p>
        <h4 class="text-2xl font-bold mb-2">材料</h4>
        <ul>
      @foreach($recipe['ingredients'] as $ingredient)
        <li>{{ $ingredient['name']}}:{{$ingredient['quantity']}}</li>
      @endforeach
      </ul>
      </div>
    </div>
    <br>
    <div class="">
      <h4 class="text-2xl font-bold mb-2">作り方</h4>
      @foreach($recipe['steps'] as $step)
      <div class="flex items-center mb-2">
        <div class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full mr-4">
        {{ $step['step_number'] }}
        </div>
        <p>{{ $step['description']}}</p>
      </div>
      @endforeach
    </div>
  </div>
  <!-- reviews -->
  <div class="w-10/12 p-4 mx-auto bg-white rounded">
    <h4 class="text-2xl font-bold mb-2">レビュー</h4>
    @if( count($recipe['reviews']) === 0 )
      <p>レビューはまだありません。</p>
    @endif
    @foreach($recipe['reviews'] as $review)
      <div class="background-color rounded mb-4">
        <div class="flex">
      @for($i = 0; $i < $review['rating']; $i++) 
        <svg class="w-6 h-6 text-yellow-500 fill-current" viewBox="0 0 24 24">
          <path d="M12 2.69l2.76 6.3 6.22.54-4.72 4.47 1.4 6.2L12 17.77l-5.66 3.43 1.4-6.2L3.02 9.53l6.22-.54L12 2.69z"/> 
        {{ $review['rating'] }}
        </svg>
      @endfor
        <p>{{ $review['comment']}}</p>
      </div>
      <p>{{ $review['user']['name'] }}</p>
    </div>
    @endforeach
  </div>
</x-app-layout>