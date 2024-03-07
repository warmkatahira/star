// 実行ボタンが押下されたら
$('#order_confirm_enter').on("click",function(){
    try {
        // 処理を実行するか確認
        const result = window.confirm("発注を確定しますか？");
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            $("#order_confirm_form").submit();
        }
    } catch (e) {
        alert(e.message);
    }
});