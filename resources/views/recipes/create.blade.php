<x-app-layout>

    <form action="{{ route('recipe.store') }}" method="POST" class="w-10/12 p-4 mx-aoto bg-white rounded" enctype="multipart/form-data">  
      @csrf
      {{ Breadcrumbs::render('create') }}      
      <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
        <div class="col-span-1">
          <img class="object-cover w-full aspect-video" src="\images\logo.jpg" alt="recip-image">
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
    </form>
</x-app-layout>