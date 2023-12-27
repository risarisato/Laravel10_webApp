<x-app-layout>
    {{ Breadcrumbs::render('show', $recipe) }}
    <div class="p-4 mx-auto bg-white rounded">
        <div class="grid grid-cols-2 rounded border-black">
            <div class="col-span-1"></div>
                <img class="object-cover rounded-t-lg h-40 w-40 mrounded-none rounded-l-lg" src="{{$recipe->image}}" alt="{{$recipe['title']}}"> 
        </div>
    <div class="col-span-1">
        <p>{{ $recipe['description'] }}</p>  
        <p>ユーザー名</p>
        <h4 class="text-2xl font-bold mb-2">材料</h4>
    </div>
</x-app-layout>