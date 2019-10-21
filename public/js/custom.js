  (function($){
    $(document).ready(function(){
      var abs = $(".abstract").html();

      $("#comment_submit").click(function() {
        if($.trim($(".comment").val()) == "")
        {
          setTimeout(function() { $(".provider-site-wrap").hide(); }, 100);
        }
      });

      $(document).on("click", "#add_abs", function(){
        $(".abstract").append(abs);
      });

      $(document).on("click", "#add_abs_cur", function(){
        var content = '<div class="abstract-item-cur"><div style="position: relative;"><input type="hidden" class="abstract-id" name="abstract_id[]" value="-1"><input type="hidden" name="logo_img_changed[]" value="0" class="logo-img-flag"> <input type="file" name="logo_img[]" class="form-control file_input" style="margin-bottom: 10px; position: absolute; z-index: 2; opacity: 0;"> <span class="file_val" style="display: block; height: 42px; background-color: white; border: 1px solid rgb(219, 219, 219); border-radius: 6px; margin-bottom: 10px; padding: 10px;">choose file</span></div> <input required="required" type="" name="abstract_title[]" placeholder="Input Title" value="" class="form-control" style="margin-bottom: 10px;"> <input required="required" type="" name="abstract_url[]" placeholder="Input Url" value="" class="form-control valid_url" style="margin-bottom: 10px;"> <span class="sj-addbtn sj-delbtn abs_del_cur" style="float: right; margin-bottom: 10px;"><i class="fa fa-plus"></i></span><div style="clear:both;"></div></div>';
        $(".abstract-cur").append(content);
      });

      $(document).on("click", ".abs_del", function() {
        $(this).parents(".abstract-item").remove();
      });

      $(document).on("click", ".abs_del_cur", function() {
        $(this).parents(".abstract-item-cur").remove(); 
      });

      $(document).on("change", ".file_input", function() {
        var url = $(this).val();
        var filename = url.match(/[-_\w]+[.][\w]+$/i)[0];
        $(this).siblings('.file_val').text(filename);
        $(this).siblings(".logo-img-flag").val(1);
      });

      $(document).on('submit','.edit_form',function(){

        var allowed_extension = ['jpg', 'jpeg', 'png', ''];
        var file_flag = 0;
        var url_flag = 0;
        var allow_1 = 0;
        var allow_2 = 0;

        $(".file_input").each(function(){

          if (file_flag ==0) {
            var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            var logo_extension = filename.split('.').pop();
            var allow_1 = jQuery.inArray(logo_extension, allowed_extension);

            if (allow_1<0) {
              file_flag = -1;
              return false;
            };
          }
        });        

        $(".file").each(function(){

          if (file_flag ==0) {
            var add_filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            var add_logo_extension = add_filename.split('.').pop();
            var allow_3 = jQuery.inArray(add_logo_extension, allowed_extension);
            console.log("NONE");
            console.log(add_logo_extension);
            console.log(allow_3);
            if (allow_3<0) {
              file_flag = -1;
              return false;
            };
          }    
        });

        var cat_image = $("span.uploaded_slider_image_name").last().text();
        var cat_extension = cat_image.split('.').pop();
        var allow_2 = jQuery.inArray(cat_extension, allowed_extension);

        if (allow_2<0) {
          swal("Warning!", "Allowed file extensions are 'JPG, JPEG, PNG'.");
          return false;
        };

        $(".valid_url").each(function(){
          if (url_flag ==0) {
            var url = $(this).val();
            if(!(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(url))&&url!=''){
              url_flag = -1;
              return false;
            }
          }
        });

        $(".add_url").each(function(){
          if (url_flag ==0) {
            var url = $(this).val();
            if(!(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(url))&&url!=''){
              url_flag = -1;
              return false;
            }
          }
        });

        $("select[name = 'status']").on('change', function() {
          console.log(this.value);
          if (this.value=="accepted_articles") {
            $('.m_price').prop("disabled", false);
          }else{
            $('.m_price').prop("disabled", true);
          }
        });

        console.log(file_flag);
        console.log(url_flag);
        
        if (file_flag !=0) {
          swal("Warning!", "Allowed file extensions are 'JPG, JPEG, PNG'.");
          return false;
        }

        if (url_flag !=0) {
          swal("Warning!", "Please input valid URL.");
          return false;
        }

      });

    });

  })(jQuery);