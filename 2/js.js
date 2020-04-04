$(document).ready(function () { // вся мaгия пoслe зaгрузки стрaницы

    if ($('select').is('#change_price')) {

// при загрузке ставим ту цену которая выбрана
        var $th = $('#change_price');

        var $new_price = $th.find(":selected").attr('price');
        $('#now_price_rub').html($new_price);

        var $new_price_opt = $th.find(":selected").attr('nomer_opt');
        $('#now_price_option').val($new_price_opt);

// изменение варианта цены (выпадающий список)
        $('body #change_price').on('change', function () {

            var $th = $(this);

            var $now_item = $th.attr('id_item');
            
            var $new_price = $th.find(":selected").attr('price');
            $('#now_price_rub').html($new_price);
        
            $('#now_price').val($new_price);

            var $new_price_option = $th.find(":selected").attr('nomer_opt');
            $('#now_price_option').val($new_price_option);

            /*
             var $val = $(this).find(":selected").val();
             
             var $secret = $(this).find(":selected").attr('s');
             
             var $action = $(this).attr('action');
             var $table = $(this).attr('table');
             var $pole = $(this).attr('pole');
             
             // var $val = $(this).value;
             // alert( $table + '/' + $pole + '/' + $val + '/' + $action);
             var $id = $(this).attr('rev');
             */



        $.ajax({

            type: 'GET',
            url: "/module/myshop/2/ajax.web.php",
            
            dataType: 'json',
            data: 'action=check_item_in_cart&item='+$now_item+'&price_opt='+$new_price_option,
            
            // data: "type=" + $action + "&shop=" + $shop + "&item=" + $id + "&new_kolvo=" + $val + '&active_item=' + $vals,

            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                // $this.css({"border": "2px solid orange"});
                $('#di_bu_'+$now_item).hide();
                $('#di_bu_ok_'+$now_item).hide();

            },

            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'ok')
                {
                    $('#di_bu_ok_'+$now_item).show('slow');
                }
                // eсли всe прoшлo oк
                else
                {
                    $('#di_bu_'+$now_item).show('slow');

                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + ' // ' + thrownError); // и тeкст oшибки
            }

            // сoбытиe пoслe любoгo исхoдa
            // ,complete: function ($data) {
            // в любoм случae включим кнoпку oбрaтнo
            // $form.find('input[type="submit"]').prop('disabled', false);
            // }

        }); // ajax-






        });

    }





    /*
     var $refresh_itogo = function ()
     {
     var $we = 0;
     
     $('body').find('input.summa_cifra').each(function () { // прoбeжим пo кaждoму пoлю в фoрмe
     $we += Math.round($(this).val());
     });
     
     $('#korzina_summa').html($we);
     return $we;
     }
     */

    //$refresh_itogo();

    /**
     * удаление позиции в корзине
     * @param {type} $item
     * @returns {undefined}
     */
    var deleteItem = function ($item) {

        $.ajax({

            url: "/module/myshop/2/ajax.web.php",
            data: "type=remove_from_cart&id=" + $item,
            cache: false,
            dataType: "json",
            type: "post",

            beforeSend: function () {
                /*
                 if (typeof $div_hide !== 'undefined') {
                 $('#' + $div_hide).hide();
                 }
                 */
//                $("#ok_but_stat").html('<img src="/img/load.gif" alt="" border=0 />');
//                $("#ok_but_stat").show('slow');
//                $("#ok_but").hide();
            }
            ,

            success: function ($j) {

                return true;

                /*
                 // alert($j.html);
                 if (typeof $div_show !== 'undefined') {
                 $('#' + $div_show).show();
                 }
                 */
//                $('#form_ok').hide();
//                $('#form_ok').html($j.html + '<br/><A href="">Сделать ещё заявку</a>');
//                $('#form_ok').show('slow');
//                $('#form_new').hide();
//
//                $('.list_mag').hide();
//                $('.list_mag_ok').show('slow');

            }

        });

        return false;

    }

// 
    $('body .remove_item_from_cart').on('click', function (event) {

        event.preventDefault();

        var $this = $(this);
        var $item = $(this).attr('rel');

        deleteItem($item);

        $('#item_tr_' + $item).remove();

// <a href="" class="myshop_btn btn_buy trans1" rev="add_to_cart" rel="{$k}" hide="di_bu_{$k}" show="di_bu_ok_{$k}" >В корзину</a>

        refreshCart($('#shop_id').val());

        return false;

    });

// отправка заказа
    $('body #cart_big_form').on('submit', function () {

        var $dd = $(this).serialize();

        $.ajax({

            type: 'POST',
            url: "/module/myshop/2/ajax.web.php",
            dataType: 'json',
            data: $dd,
            // data: "type=" + $action + "&shop=" + $shop + "&item=" + $id + "&new_kolvo=" + $val + '&active_item=' + $vals,

            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                // $this.css({"border": "2px solid orange"});
            },

            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {
                    // alert($data['error']); // пoкaжeм eё тeкст
                    //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                    // $this.css({"border": "2px solid red"});

                    alert($data.html);

                }
                // eсли всe прoшлo oк
                else
                {

                    $('#creat_order1').hide('slow');
                    $('#order_new').hide('slow');
                    $('#order_okey').html($data.html);
                    $('#order_okey').show('slow');

                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                    // $this.css({"border": "2px solid green"});
                    // refreshCart($shop);
                    $('#cart_kolvo_items').hide();
                    $('#cart_price').hide();
                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                alert(thrownError); // и тeкст oшибки
            }

            // сoбытиe пoслe любoгo исхoдa
            // ,complete: function ($data) {
            // в любoм случae включим кнoпку oбрaтнo
            // $form.find('input[type="submit"]').prop('disabled', false);
            // }

        }); // ajax-

        return false;

    });

    var searchRequest = false,
            reqDelay = 3000;

// редактирование поля с количеством
    $('body .carts_kolvo').on('keyup input', function () {
        // var $val = this.value;

        if (searchRequest !== false) {
            clearInterval(searchRequest);
        }

        var $this = $(this);
        var $val = Math.ceil($(this).val());

        if ($val < 0) {
            $(this).val(0);
            return false;
        }

        var $id = $(this).attr('rel');

        var $action = 'edit_kolvo_in_cart';
        var $shop = $('#shop_id').val();

        refreshCartItem($id);

//if(document.getElementById(id)){если есть этот элемент}
//else{если нет элемента};


        var $vals = []
        $("body .cart_check_my_items").each(function () {
            $vals.push($val)
        })

        // var $new = $vals.serialize();
        //alert($new);

        // var li_obj = document.getElementsByClassName("cart_check_my_items");
        // var $li_array = $.makeArray(li_obj).serialize();
        // li_array.reverse();
        // $(li_array).appendTo(".box");


        $.ajax({

            type: 'POST',
            url: "/module/myshop/2/ajax.web.php",
            dataType: 'json',
            // data: $all_form,
            data: "type=" + $action + "&shop=" + $shop + "&item=" + $id + "&new_kolvo=" + $val + '&active_item=' + $vals,

            // сoбытиe дo oтпрaвки
            beforeSend: function ($data) {
                // $div_res.html('<img src="/img/load.gif" alt="" border="" />');
                $this.css({"border": "2px solid orange"});
            },

            // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
            success: function ($data) {

                // eсли oбрaбoтчик вeрнул oшибку
                if ($data['status'] == 'error')
                {
                    // alert($data['error']); // пoкaжeм eё тeкст
                    //$div_res.html('<div class="warn warn">' + $data['html'] + '</div>');
                    $this.css({"border": "2px solid red"});
                }
                // eсли всe прoшлo oк
                else
                {
                    // $div_res.html('<div class="warn good">' + $data['html'] + '</div>');
                    $this.css({"border": "2px solid green"});
                    refreshCart($shop);

                }

            }
            ,
            // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                alert(thrownError); // и тeкст oшибки
            }

            // сoбытиe пoслe любoгo исхoдa
            // ,complete: function ($data) {
            // в любoм случae включим кнoпку oбрaтнo
            // $form.find('input[type="submit"]').prop('disabled', false);
            // }

        }); // ajax-


        searchRequest = setTimeout(function () {
            searchRequest = false;
        }, reqDelay);



        return false;

        // $elements.hide();
        // $elements.filter(':contains("' + value + '")').show();
    });

// обновление надписи на корзине на верху
    var refreshCartItem = function ($item) {

        var $res = $('#summa_item_' + $item);
        var $price = $('#price_' + $item).val();
        var $kolvo = Math.ceil($('#kolvo_' + $item).val());

        var $summa = $price * $kolvo;

        $($res).html($summa + ' Р');

    }

    $('body .cart_check_my_items').on('click', function () {
        refreshCart($('#shop_id').val());
    });

    // обновление надписи на корзине на верху
    var refreshCart = function ($shop) {

/*
        var $vals = []
        $("body .cart_check_my_items").each(function () {

            if ($(this).prop("checked")) {
                $vals.push(this.value)
            }

        })
*/
        var $data = $(this).serialize();

        $.ajax({

            url: "/module/myshop/2/ajax.web.php",
            // data: "type=get_nadpis_for_cart&shop=" + shop + '&active_items=' + $vals,
            data: "type=get_nadpis_for_cart&shop=" + $shop + '&' + $data,
            cache: false,
            dataType: "json",
            type: "post"
            ,

            beforeSend: function () {

                $('#cart_kolvo_items').html('<img src="/img/load.gif" alt="" border="0" />');

//                if (typeof $div_hide !== 'undefined') {
//                    $('#'+$div_hide).hide();
//                }
////                $("#ok_but_stat").html('<img src="/img/load.gif" alt="" border=0 />');
////                $("#ok_but_stat").show('slow');
////                $("#ok_but").hide();
            }
            ,

            success: function ($j) {

                $('#cart_kolvo_items').html($j.nadpis);
                $('#cart_price').html($j.summa);

                var $div_sum_order = $('#summ_for_pay');

                if (typeof $div_sum_order !== 'undefined') {
                    $div_sum_order.html($j.summa);
                }

//                // alert($j.html);
//                if (typeof $div_show !== 'undefined') {
//                    $('#'+$div_show).show();
//                }
//                
//                refreshCart();

//                $('#form_ok').hide();
//                $('#form_ok').html($j.html + '<br/><A href="">Сделать ещё заявку</a>');
//                $('#form_ok').show('slow');
//                $('#form_new').hide();
//
//                $('.list_mag').hide();
//                $('.list_mag_ok').show('slow');

            }

        });



        return false;

    };

    refreshCart($('#shop_id').val());

// добавляем товар в корзину, убираем от туда
    $('body .myshop_btn').on('click', function (event) {

// <a href="" class="myshop_btn btn_buy trans1" rev="add_to_cart" rel="{$k}" hide="di_bu_{$k}" show="di_bu_ok_{$k}" >В корзину</a>

        event.preventDefault();

        // console.log("Хрясь!");

        var $action = $(this).attr('rev');
        var $id = $(this).attr('rel');
        var $s = $(this).attr('s');
        var $div_hide = $(this).attr('hide');
        var $div_show = $(this).attr('show');

        var $go_to_cart = $(this).attr('go_to_cart');

        var $mi = $(this).attr('mini');

        if( $mi == 'y' ){
        var $price_now = $(this).attr('price');
        }else{
        var $price_now = $('#now_price').val();
        }
        
        var $price_now_opt = $('#now_price_option').val();

        var $ar = [];

        $('select.select_option').each(function ($i, $elem) {

            var $e = $($elem).attr('id_option');
            var $e1 = $($elem).val();

            var $str = '[select_option]' + $e + '=' + $e1;
            //alert( str );
            $ar.push($str);
        });

        //var aa = ar.join("&");
        //alert( aa );
        //alert( ar.join("&") );

        /*
         if ($(this).hasClass("stop")) {
         alert("Остановлено на " + i + "-м пункте списка.");
         return false;
         } else {
         alert(i + ': ' + $(elem).text());
         }
         */
        //});        

        //return false;

        $.ajax({

            url: "/module/myshop/2/ajax.web.php",
            data: "type=" + $action + "&id=" + $id + "&price="+ $price_now +"&price_opt=" + $price_now_opt + "&s=" + $s + '&' + $ar.join("&"),
            cache: false,
            dataType: "json",
            type: "post"
            ,

            beforeSend: function () {
                if (typeof $div_hide !== 'undefined') {
                    $('#' + $div_hide).hide();
                }
//                $("#ok_but_stat").html('<img src="/img/load.gif" alt="" border=0 />');
//                $("#ok_but_stat").show('slow');
//                $("#ok_but").hide();
            }
            ,

            success: function ($j) {

                // alert($j.html);
                if (typeof $div_show !== 'undefined') {
                    $('#' + $div_show).show();
                }
//                $('#form_ok').hide();
//                $('#form_ok').html($j.html + '<br/><A href="">Сделать ещё заявку</a>');
//                $('#form_ok').show('slow');
//                $('#form_new').hide();
//
//                $('.list_mag').hide();
//                $('.list_mag_ok').show('slow');

                if ($action == 'add_to_cart' && typeof $go_to_cart !== 'undefined') {
                    document.location = $go_to_cart;
                    /* location.replace($go_to_cart); */
                }

            }

        });

        var $shop = $('#shop_id').val();
        refreshCart($shop);

        return false;

    });

    $('#form_order2').on('submit', function (event) {

        event.preventDefault();

        var $data = $(this).serialize();

        $.ajax({

            url: "/module/myshop/2/ajax.php",
            data: "types=send_order&" + $data,
            cache: false,
            dataType: "json",
            type: "post"

            ,

            beforeSend: function () {
                $("#ok_but_stat").hide();
                $("#ok_but_stat").html('<img src="/img/load.gif" alt="" border=0 />');
                $("#ok_but_stat").show('slow');
                $("#ok_but").hide();
            }

            ,

            success: function ($j) {

                $('.list_head').hide();
                $('#row_filtr').hide();
                $('#form_ok').hide();
                $('#form_ok').html($j.html + '<br/><A href="">Сделать ещё заявку</a>');
                $('#form_ok').show('slow');
                $('#form_new').hide();

                $('.list_mag').hide();
                $('.list_mag_ok').show('slow');

            }

        });

        return false;

    });





    $.refresh_summ = function () {

        $('#form_order').show('slow');
        $('#ok_but').show('slow');

        // pause(100);
        // document.getElementById("form_order").style.bottom = "50px"; 

        $('#form_order').addClass('form_bottom');
        $('#form_order').removeClass('form_top');


        $s = 0;
        $('.summa_cifra').each(function () {
            $s += parseInt($(this).val());
        });
        // $('#finsumm30').val($s);
        $q = number_format($s, 0, ',', '`');
        $('#fin_itog').html($q);
    };

    $('form#orm').on('submit', function () {

        var q1 = $('#tel').val();
        var q2 = $('#mail').val();
        var q3 = $('#fio').val();
        // alert( q1 );
        $('#warn').html('');
        if (q1.length < 5) {
            $('#warn').append('Найдена ошибка: Укажите контактный телефон<br>');
        }

        if (q2.length < 5) {
            $('#warn').append('Найдена ошибка: Укажите контактный E-mail<br>');
        }

        if (q3.length < 5) {
            $('#warn').append('Найдена ошибка: Укажите как вас зовут');
        }

        var rf = $('#warn').html();

        if (rf.length > 5) {
            alert('В форме заказа найдены ошибки');
            $('#warn').show('slow');
            return false;
        } else {
            $('#warn').hide();
        }

    });

    // 

    $('.but_bay .minus2').click(function () {

        // $('#form_order2').addClass('fixed_bottom');
        var $idd = $(this).attr('rel');
        var $input = $("#kolvo" + $idd);

        var $count = parseInt($input.val()) - 1;
        $count = (($count >= 0) ? $count : 0);
        $input.val($count);
        $input.change();
        $("#kolvo2_" + $idd).val($count);
        $("#kolvo2_" + $idd).change();

        var $price = $(this).attr('rev');
        // alert($price);
        var $summ = $count * $price;
        // alert($summ);

        //$('#summa' + $idd).val($summ.toFixed(2));

        $qwe = $summ.toFixed(0);
        $('#summa' + $idd).val($qwe);
        $('#summa' + $idd).change();



        $qwe2 = number_format($qwe, 2, ',', '`');
        $('#summa_show' + $idd).html($qwe2 + 'р');

        $.refresh_summ();
        //$refresh_itogo();
        return false;
    });

    $('.but_bay .plus2').click(function () {

        // $('#form_order2').addClass('fixed_bottom');
        var $idd = $(this).attr('rel');
        var $input = $("#kolvo" + $idd);

        var $count = parseInt($input.val()) + 1;
        $input.val($count);
        $input.change();

        $("#kolvo2_" + $idd).val($count);
        $("#kolvo2_" + $idd).change();

        var $price = $(this).attr('rev');
        // alert($price);
        var $summ = $count * $price;
        // alert($summ);

        //$('#summa' + $idd).val($summ.toFixed(2));

        $qwe = $summ.toFixed(0);
        $('#summa' + $idd).val($qwe);
        $('#summa' + $idd).change();

        $qwe2 = number_format($qwe, 2, ',', '`');
        $('#summa_show' + $idd).html($qwe2 + 'р');

        $.refresh_summ();
        //$refresh_itogo();
        return false;

    });
    /*
     // $(".kolvo").prop("disabled", true);
     // $('#loading').hide();
     
     // alert('123123');
     */

});
