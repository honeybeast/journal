  (function($){
    $(document).ready(function(){
      
        $("select[name = 'status']").on('change', function() {
          console.log(this.value);
          if (this.value=="accepted_articles") {
            $('.m_price').prop("disabled", false);
          }else{
            $('.m_price').prop("disabled", true);
          }
        });

    });

  })(jQuery);