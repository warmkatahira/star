$("#order_confirm_enter").on("click",function(){try{window.confirm("発注を確定しますか？")==!0&&$("#order_confirm_form").submit()}catch(r){alert(r.message)}});
