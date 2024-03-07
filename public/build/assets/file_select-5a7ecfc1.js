$(".select_file input[type=file]").on("change",function(){let e=$(this).closest(".select_file");e.find(".select_file_name").html(""),$.each($(this).prop("files"),function(n,i){e.find(".select_file_name").append(i.name+"<br>")})});$(".select_file input[type=file]").on("change",function(){const e=this.files[0].name;window.confirm(`アップロードを実行しますか？

ファイル名: `+e)==!0&&$("#upload_form").submit(),$("#select_file").val(null)});
