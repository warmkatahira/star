// 選択したファイル名を表示する
$('.select_file input[type=file]').on("change",function(){
    let parent = $(this).closest(".select_file")
    parent.find(".select_file_name").html("")
    $.each($(this).prop('files'),function(index,file){
        parent.find(".select_file_name").append(file.name+"<br>")
    })
})

// ファイルが選択されたら
$('.select_file input[type=file]').on("change",function(){
    // 選択したファイル名を取得
    const fileName = this.files[0].name;
    // 処理を実行するか確認
    const result = window.confirm("アップロードを実行しますか？" +
                                  "\n\nファイル名: " + fileName);
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        $("#upload_form").submit();
    }
    // 要素をクリア
    $('#select_file').val(null);
});