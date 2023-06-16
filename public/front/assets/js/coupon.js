
(function($) {

    $('#coupon_apply').on('click',function(e){
        e.preventDefault();
      let code =  $('input[name="coupon_code"]').val()
        $.get("{{ route('coupons') }}?code=" + code, function(response){

            var v = response.discount
            var total = Number($('#subtotal').test());
            if(response.type == 'percent'){
                v = v * total /100
            }
            $('#discount').text(v)
            $('#total').text(total - v)
            $('#coupon_desc').text(response.name)

        }).fail();

    })



})(jQuery);
