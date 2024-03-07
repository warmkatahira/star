@vite(['resources/js/order.js'])

<x-app-layout>
    <x-page-header content="発注"/>
    <div class="ml-5 mt-5">
        <p class="border-l-8 border-theme-main pl-3 my-3">発注ファイルアップロード</p>
        <div class="flex">
            <form method="POST" action="{{ route('order.upload') }}" id="upload_form" enctype="multipart/form-data" class="m-0 mr-10">
                @csrf
                <div class="flex select_file">
                    <label class="text-sm hover:cursor-pointer bg-theme-sub hover:bg-theme-main p-5">
                        <i class="las la-upload mr-1"></i>アップロード
                        <input type="file" id="select_file" name="csvFile" class="hidden">
                    </label>
                </div>
            </form>
        </div>
        <p class="border-l-8 border-theme-main pl-3 my-3 mt-10">発注データ</p>
        <table class="text-xs block whitespace-nowrap">
            <thead>
                <tr class="text-left text-white bg-gray-600 sticky top-0">
                    <th class="font-thin py-1 px-2">アップロード日付</th>
                    <th class="font-thin py-1 px-2">発注ファイル名</th>
                    <th class="font-thin py-1 px-2">商品コード</th>
                    <th class="font-thin py-1 px-2">JANコード</th>
                    <th class="font-thin py-1 px-2">商品名1</th>
                    <th class="font-thin py-1 px-2">商品名2</th>
                    <th class="font-thin py-1 px-2">数量</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($order_imports as $order_import)
                    <tr class="text-left hover:bg-theme-sub cursor-default">
                        <td class="py-1 px-2 border">{{ CarbonImmutable::parse($order_import->created_at)->isoFormat('Y年MM月DD日 HH時mm分ss秒') }}</td>
                        <td class="py-1 px-2 border">{{ $order_import->order_file_name }}</td>
                        <td class="py-1 px-2 border">{{ $order_import->item_code }}</td>
                        <td class="py-1 px-2 border">{{ is_null($order_import->item) ? '' : $order_import->item->jan_code }}</td>
                        <td class="py-1 px-2 border">{{ is_null($order_import->item) ? '' : $order_import->item->item_name_1 }}</td>
                        <td class="py-1 px-2 border">{{ is_null($order_import->item) ? '' : $order_import->item->item_name_2 }}</td>
                        <td class="py-1 px-2 border text-right">{{ $order_import->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex">
            <form method="POST" action="{{ route('order.confirm') }}" id="order_confirm_form" class="m-0">
                @csrf
                <button type="button" id="order_confirm_enter" class="mt-5 text-sm px-10 py-3 text-center bg-theme-sub hover:bg-theme-main">発注確定<button>
            </form>
        </div>
    </div>
</x-app-layout>