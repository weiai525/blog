/*module.exports = {
    form:function form(){
        $("form").submit(function(e){
            e.preventDefault();
            var url = $(this).attr("action");
            var data = $(this).serializeArray();
            var method = $this.attr('method');
            if (method == 'get') {};
            //$(this).find(".error-message").html('');
            $.post(url,data,function(data){
                if (data["error"]==0) {
                  location.reload();
                }else {
                        //$(this).find(".error-message").html(data['msg']);
                };
            });
        });
    }
}*/