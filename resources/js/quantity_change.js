// 実行ボタンが押下されたら
$('#quantity_change_enter').on("click",function(){
    const source_quantity = parseInt($('#source_quantity').val());
    const target_quantity = parseInt($('#target_quantity').val());
    try {
        // 同じ商品が選択されていないか
        if($('#source_item_code').val() == $('#target_item_code').val()){
            throw new Error('交換元と交換先が同じ商品になっています。');
        }
        // 交換元の数量が正しいか
        if(source_quantity < 1 || isNaN(source_quantity)){
            throw new Error('交換元の数量が正しくありません。');
        }
        // 交換先の数量が正しいか
        if(target_quantity < 1 || isNaN(target_quantity)){
            throw new Error('交換先の数量が正しくありません。');
        }
        if(target_quantity <= source_quantity){
            throw new Error('交換先の数量が交換元の数量より大きくありません。');
        }
        // 処理を実行するか確認
        const result = window.confirm("交換処理を実行しますか？");
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            $("#quantity_change_form").submit();
        }
    } catch (e) {
        alert(e.message);
    }
});

// 交換元の数量が変更されたら
$('#source_quantity').on("change",function(){
    const source_quantity = parseInt($('#source_quantity').val());
    // 数量であり、1以上の場合に実行
    if(!isNaN(source_quantity) && source_quantity > 0){
        // 交換元の数量を倍にする
        $('#target_quantity').val(source_quantity * 2);
    }
});