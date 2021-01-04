$(document).ready(function () {
    $('li[name=add_amount]').on('click', function(){
         var $price = $(this).data('val');

         var $first_value = $('#first_value').val();
        var added = $price*1 + $first_value*1;
        $('#first_value').val(added);

        $tot = added;
        $total_price = parseInt($tot * 1.1);

        $('#price').text($total_price);
        $num_send = Math.round(added/price_per_msg);
        $("#num_send").text($num_send);


        $("#total_price").text(" | 부가세 10% 포함 결제금액 "+$total_price+"원");
    });

    $('li[name=clear]').on('click', function(){
        $total_price = 0;
        $('#price').text(0);
        $("#num_send").text(0);
        $("#total_price").text(" | 부가세 10% 포함 결제금액 0원");
    })

    $('#order_btn').on('click', function(){
        if($total_price==0){
            alert("충전금액을 선택해주세요");
            return false;
        }
        var $el = $('#ordered-layer');

        $('#ordered-dim-layer').fadeIn();

        var $elWidth = ~~($el.outerWidth()),
            $elHeight = ~~($el.outerHeight()),
            docWidth = $(document).width(),
            docHeight = $(document).height();

        // 화면의 중앙에 레이어를 띄운다.
        if ($elHeight < docHeight || $elWidth < docWidth) {
            $el.css({
                marginTop: -$elHeight /2,
                marginLeft: -$elWidth/2
            })
        } else {
            $el.css({top: 0, left: 0});
        }

        $el.find('a.btn-layerClose').click(function(){
            $('#ordered-dim-layer').fadeOut();
            return false;
        });

        $el.find('a.btn-layerOrderClose').click(function(){
            $('#ordered-dim-layer').fadeOut();
            $.ajax({
                type: "POST",
                data: {'total_price':$total_price, 'num_send':$num_send},
                url: "/users/smsAddSend",
                cache: false,
                dataType:'html',
                async: true,
                success: function (data) {
                    alert('충전요청에 성공하였습니다.');

                    //console.log(data);
                    location.reload();
                }
            });
            return false;
        });
    })
});
