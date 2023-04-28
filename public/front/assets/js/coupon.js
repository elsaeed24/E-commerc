
(function($) {

    $('#coupon_apply').on('click',function(e){
        e.preventDefault();
      let code =  $('input[name="coupon_code"]').val()
        $.get("{{ route('coupons') }}?code=" + code, function(response){


        });

    })



})(jQuery);
