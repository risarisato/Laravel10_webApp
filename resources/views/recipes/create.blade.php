<x-app-layout>
  <x-slot name="script">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
    <script src="/js/recipe/create.js"></script>
  </x-slot>
  <form action="{{ route('recipe.store') }}" method="POST" class="w-10/12 p-4 mx-aoto bg-white rounded" enctype="multipart/form-data">  
    @csrf
    {{ Breadcrumbs::render('create') }}      
    <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
      <div class="col-span-1">
        <img class="object-cover w-full aspect-video" src="/images/logo.jpg" alt="recip-image">
        <!-- ここじゃない！<input type="file" name="image" class="border border-gray-300 p-2 mb-4 w-full" rounded enctype="multipart/form-data"> -->
        <input type="file" name="image" class="border border-gray-300 p-2 mb-4 w-full rounded">
      </div>
      <div class="col-span-1 p-4">
        <input type="text" name="title" border-gray-300 rounded placeholder="レシピ名" class="border border-gray-300 p-2 mb-4 w-full">
        <textarea name="description" border-gray-300 rounded placeholder="レシピの説明" class="border border-gray-300 p-2 mb-4 w-full"></textarea>
        <select name="category" class="border border-gray-300 p-2 mb-4 w-full rounded">
          <option value="">カテゴリーを選択</option>
          @foreach($categories as $category)
            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
          @endforeach
        </select>
        <div class="flex justify-end">
          <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">レシピを投稿する</button>
        </div>
      </div>
    </div>
    <hr class="my-4">
    <h4 class="text-bold text-xl mb-4">作り方を入力してください</h4>
    <!-- HTMLタグの「id属性」とは、1ページの中で必ず一つしか存在しない要素にこのIDを付けます -->
    <div id="steps">
    @for($i = 1; $i < 5; $i++)
      <div class="step flex justify-between">
        @include('components.bars-3')
        <p class="step-number">順番{{$i}}</p>
        <input type="text" name="steps[]" placeholder="手順を入力" class="border border-gray-300 p-2 mb-4 w-full rounded">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
      </div>
    @endfor
    </div>
  </form>
</x-app-layout>