/**
 * script checks user forms for emptiness, password coincidence and email validation.
 * if field is empty it becomes red and error message appears. Also, of course, form doesnt submit till errors exist and user fix them.
 * there are few highlighter script files, difference is in checking fields only
 */
(function ($) {
    /**
     * as default gives all fields with name='rfield' class empty till the opposite proved.
     * then if value of field empty put the name of the field into error array, else remove empty class
     */
    $(function () {
        var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
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
                /**
                 * error display
                 */
                if (autoArray != 0) {
                    $("#error").text(autoArray + " не введены!");
                }
                if ($("input[name='repassword']").val() != $("input[name='password']").val()) {
                    $("#password_check").text("Пароли не совпадают!");
                }
                else {
                    $("#password_check").text('');
                }


                if (pattern.test($("#email").val()) || $("#email").val() == '') {
                    $('#email_check').text('');
                }
                else {
                    $('#email_check').text('Неверная форма записи почты!');
                }
            }

            /**
             * makes empty field red
             */
            // Функция подсветки незаполненных полей
            function lightEmpty() {
                form.find('.empty_field').css({'border': '3px solid #d8512d'});
            }

            /**
             *
             * @returns {boolean}
             * count amount of forms with class "empty" and add to submit button class disabled if amount > 0
             */
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

            /**
             * submit button scenario: if button disabled -> light fields and return false.
             */
            btn.click(function () {
                check()
                if ($(this).hasClass('disabled')) {
                    lightEmpty();
                    return false
                }
                else {

                    if (pattern.test($("#email").val()) && $("#password").val() == $("#repassword").val()) {
                        form.submit();
                    }
                    else {
                        return false
                    }
                }
            });

        });

    });

})(jQuery);