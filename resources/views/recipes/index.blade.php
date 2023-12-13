<!-- レイアウトファイルの読み込み -->
<x-app-layout>
    <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2 bg-white rounded p-4">
            @foreach($recipes as $recipe)
                @include('recipes.partial.horizontal-card')
            @endforeach    
        </div>
        <div class="col-span-1 bg-white p-4">
            <form action="{{ route('recipe.index') }}" method="GET">
                <div class="flex"><!-- https://heroicons.com/からsvgをコピー -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>          
                    <h3 class="text-xl text-gray-800 font-bold mb-4">レシピ検索</h3>
                </div>
                <div class="mb-4 p-6 border border-gray600">
                    <label class="text-lange text-gray-800">評価</label>
                    <div>
                        <input type="radio" name="rating" value="0" id="rating0" checked/>
                        <label for="rating0">指定しない</label>
                    </div>
                    <div>
                        <input type="radio" name="rating" value="3" id="rating3"/>
                        <label for="rating3">3以上</label>
                    </div>
                    <div>
                        <input type="radio" name="rating" value="4" id="rating4"/>
                        <label for="rating4">4以上</label>
                    </div>
                </div>
                <div class="mb-4 p-6 border border-gray600">
                    <label class="text-lange text-gray-800">カテゴリー</label>
                    <div>
                        <input type="checkbox" name="rating" value="0" id="rating0"/>
                        <label for="rating0">指定しない</label>
                    </div>
                    <div>
                        <input type="checkbox" name="rating" value="3" id="rating3"/>
                        <label for="rating3">3以上</label>
                    </div>
                    <div>
                        <input type="checkbox" name="rating" value="4" id="rating4"/>
                        <label for="rating4">4以上</label>
                    </div>
                </div>
                <div>
                    <input type="text" name="title" value="" placeholder="レシピ名を入力" class="border border-gray-600 p-2 mb-4 w-full">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">検索</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>