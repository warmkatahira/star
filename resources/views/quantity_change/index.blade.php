@vite(['resources/js/quantity_change.js'])

<x-app-layout>
    <x-page-header content="数量交換"/>
    <form method="POST" action="{{ route('quantity_change.change') }}" id="quantity_change_form" class="m-0 ml-5">
        @csrf
        <!-- 交換元 -->
        <div class="flex flex-col bg-amber-100 border border-black pb-5 px-5 w-600px">
            <p class="mb-3 mt-2 text-xl"><i class="las la-angle-left"></i>交換元<i class="las la-angle-right"></i><span class="text-sm ml-2">※数量を減らす商品</span></p>
            <label for="source_item_code" class="mb-1"><i class="las la-star mr-1"></i>商品選択</label>
            <select id="source_item_code" name="source_item_code" class="text-xs">
                @foreach($items as $item)
                    <option value="{{ $item->item_code }}">{{ $item->item_name_1 . $item->item_name_2 . '(' . $item->item_code . ')' }}</option>
                @endforeach
            </select>
            <label for="source_quantity" class="mb-1 mt-5"><i class="las la-star mr-1"></i>数量</label>
            <input type="tel" id="source_quantity" name="source_quantity" class="text-xs w-20 text-right" value="1">
        </div>
        <!-- 交換先 -->
        <div class="flex flex-col bg-amber-100 border border-black pb-5 px-5 w-600px mt-5">
            <p class="mb-3 mt-2 text-xl"><i class="las la-angle-left"></i>交換先<i class="las la-angle-right"></i><span class="text-sm ml-2">※数量を増やす商品</span></p>
            <label for="target_item_code" class="mb-1"><i class="las la-star mr-1"></i>商品選択</label>
            <select id="target_item_code" name="target_item_code" class="text-xs">
                @foreach($items as $item)
                    <option value="{{ $item->item_code }}">{{ $item->item_name_1 . $item->item_name_2 . '(' . $item->item_code . ')' }}</option>
                @endforeach
            </select>
            <label for="target_quantity" class="mb-1 mt-5"><i class="las la-star mr-1"></i>数量</label>
            <input type="tel" id="target_quantity" name="target_quantity" class="text-xs w-20 text-right bg-gray-200" value="2" readonly>
            <p class="text-xs mt-1">※交換元の数量を更新すると自動で更新されます</span>
        </div>
        <button type="button" id="quantity_change_enter" class="mt-5 text-sm px-10 py-3 text-center bg-theme-main hover:bg-theme-sub w-600px">実行</button>
    </form>
</x-app-layout>