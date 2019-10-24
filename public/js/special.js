  (function($){
    $(document).ready(function(){

    var meta = $(".meta_tag").html();

      
        $("select[name = 'status']").on('change', function() {
          console.log(this.value);
          if (this.value=="accepted_articles") {
            $('.m_price').prop("disabled", false);
          }else{
            $('.m_price').prop("disabled", true);
          }
        });

      $(document).on("click", "#add_meta", function(){
        $(".meta_tag").append(meta);
      });

      $(document).on("click", "#add_meta_cur", function(){
        var meta_content = '<div class="meta-item-cur"><div style="position: relative;"><input type="hidden" class="meta_tag_id" name="meta_tag_id[]"><input required="required" type="text" name="meta_tag_name[]" placeholder="Meta Tag Name" value="" class="form-control" style="margin-bottom: 10px;"> <input required="required" type="text" name="meta_tag_des[]" placeholder="Meta Tag Description" value="" class="form-control" style="margin-bottom: 10px;"> <span class="sj-addbtn sj-delbtn meta_del_cur" style="float: right; margin-bottom: 10px;"><i class="fa fa-plus"></i></span><div style="clear:both;"></div></div>';
        $(".meta-cur").append(meta_content);
      });

      $(document).on("click", ".meta_del", function() {
        $(this).parents(".meta-item").remove();
      });

      $(document).on("click", ".meta_del_cur", function() {
        $(this).parents(".meta-item-cur").remove(); 
      });


    });

  })(jQuery);