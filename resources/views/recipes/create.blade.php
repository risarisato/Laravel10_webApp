<x-app-layout>

    <form class="w-10/12 p-4 mx-aoto bg-white rounded">  
      {{ Breadcrumbs::render('create') }}      
      <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
        <div class="col-span-1">
          <img class="object-cover w-full aspect-video" src="\images\logo.jpg" alt="recip-image">
        </div>
        <div class="col-span-1 p-4">
          <input type="text" name="title" border-gray-300 rounded placeholder="レシピ名" class="border border-gray-300 p-2 mb-4 w-full">
          <textarea name="description" border-gray-300 rounded placeholder="レシピの説明" class="border border-gray-300 p-2 mb-4 w-full"></textarea>
        </div>
    </form>
</x-app-layout>