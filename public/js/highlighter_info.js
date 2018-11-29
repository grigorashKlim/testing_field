(function ($) {
    $(function () {
        $('.rf').each(function () {
            var form = $(this),
                btn = form.find('.btn_submit');

            form.find('.rfield').addClass('empty_field');

            // Функция проверки полей формы
            function checkInput() {
                var autoArray = [];
                var i = 0;
                var b;
                form.find('.rfield').each(function () {

                    if ($(this).val() != '') {
                        $(this).css({'border': '3px solid orange'});
                        $(this).removeClass('empty_field');
                    } else {
                        $(this).addClass('empty_field');
                        var form = $(this).attr('name');
                    }
                    if (typeof form != 'undefined') {
                        autoArray[i] = form;
                        i++;
                    }
                    ;

                });
                console.log(autoArray);
                if (autoArray != 0) {
                    $("#error").text(autoArray + " не введены!");
                }
            }

            // Функция подсветки незаполненных полей
            function lightEmpty() {
                form.find('.empty_field').css({'border': '3px solid #d8512d'});
                /*var login = $(this).attr("name");
                var autoArray = [];
                autoArray.push(login);
                console.log (autoArray);dhrhrhti*/
            }

            function check() {
                checkInput();
                var sizeEmpty = form.find('.empty_field').length;

                if (sizeEmpty > 0) {
                    if (btn.hasClass('disabled')) {
                        return false
                    }
                    else {
                        btn.addClass('disabled');
                    }
                }
                else {
                    btn.removeClass('disabled');
                }
            }

            btn.click(function () {
                check()
                if ($(this).hasClass('disabled')) {
                    lightEmpty();
                    return false
                }
                else {
                    form.submit();
                }
            });

        });


    });


})(jQuery);