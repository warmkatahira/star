<x-app-layout>
    <x-page-header content="履歴"/>
    <table class="text-xs block whitespace-nowrap">
        <thead>
            <tr class="text-left text-white bg-gray-600 sticky top-0">
                <th class="font-thin py-1 px-2">日付</th>
                <th class="font-thin py-1 px-2">時間</th>
                <th class="font-thin py-1 px-2">カテゴリ</th>
                <th class="font-thin py-1 px-2">商品コード</th>
                <th class="font-thin py-1 px-2">JANコード</th>
                <th class="font-thin py-1 px-2">商品名1</th>
                <th class="font-thin py-1 px-2">商品名2</th>
                <th class="font-thin py-1 px-2">数量</th>
                <th class="font-thin py-1 px-2">コメント</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($histories as $history)
                <tr class="text-left hover:bg-theme-sub cursor-default">
                    <td class="py-1 px-2 border">{{ CarbonImmutable::parse($history->date)->isoFormat('Y年MM月DD日') }}</td>
                    <td class="py-1 px-2 border">{{ CarbonImmutable::parse($history->time)->isoFormat('HH時mm分ss秒') }}</td>
                    <td class="py-1 px-2 border">{{ $history->category }}</td>
                    <td class="py-1 px-2 border">{{ $history->item_code }}</td>
                    <td class="py-1 px-2 border">{{ $history->item->jan_code }}</td>
                    <td class="py-1 px-2 border">{{ $history->item->item_name_1 }}</td>
                    <td class="py-1 px-2 border">{{ $history->item->item_name_2 }}</td>
                    <td class="py-1 px-2 border text-right">{{ $history->quantity }}</td>
                    <td class="py-1 px-2 border">{{ $history->comment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>