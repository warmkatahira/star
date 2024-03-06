<x-app-layout>
    <x-page-header content="進捗管理"/>
    <table class="text-xs block whitespace-nowrap">
        <thead>
            <tr class="text-left text-white bg-gray-600 sticky top-0">
                <th class="font-thin py-1 px-2">商品コード</th>
                <th class="font-thin py-1 px-2">JANコード</th>
                <th class="font-thin py-1 px-2">商品名1</th>
                <th class="font-thin py-1 px-2">商品名2</th>
                <th class="font-thin py-1 px-2">初回パッケージ数量</th>
                <th class="font-thin py-1 px-2">発注済み数量</th>
                <th class="font-thin py-1 px-2">初回パッケージ残数</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($items as $item)
                @php
                    // 初回パッケージ数量 - 発注数の合計
                    $first_package_remaining = $item->first_package_quantity - $item->total_order_quantity;
                    // マイナスであれば、0に交換
                    if($first_package_remaining < 0){
                        $first_package_remaining = 0;
                    }
                @endphp
                <tr class="text-left hover:bg-theme-sub cursor-default">
                    <td class="py-1 px-2 border">{{ $item->item_code }}</td>
                    <td class="py-1 px-2 border">{{ $item->jan_code }}</td>
                    <td class="py-1 px-2 border">{{ $item->item_name_1 }}</td>
                    <td class="py-1 px-2 border">{{ $item->item_name_2 }}</td>
                    <td class="py-1 px-2 border text-right">{{ $item->first_package_quantity }}</td>
                    <td class="py-1 px-2 border text-right">{{ $item->total_order_quantity }}</td>
                    <td class="py-1 px-2 border text-right">{{ $first_package_remaining }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>