<div class="first_block test_page test_ready">
    <div class="container">
        <div class="row">
            <a href="" class="logo">
                <img src="/images/logo.png" alt="">
            </a>
            <div class="form_block">
                <form>
                    <h1>Здесь Вы можете задать <br> интересующий Вас вопрос</h1>
                    <div class="wrapper">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="phone">Номер телефона</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="title">Тип вопроса</div>
                                <ul>
                                    <li>
                                        <label for="tex">
                                            <input checked class="radio_btn" type="radio" name="type" id="tex">
                                            <span>технический</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="about">
                                            <input class="radio_btn" type="radio" name="type" id="about">
                                            <span>об акции</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="title">Ваш вопрос</div>
                                <textarea class="form-control" placeholder="Напишите текст вопроса…" name="" id="" cols="30" rows="7"></textarea>
                                <button type="submit" class="btn btn_orange submit">Отправить</button>
                                <a class="btn btn_orange">Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS

        $(function () {

    $(function($){
        $("#phone").inputmask("+7 (999) 999-99-99");
    });

    $('.form_block .submit').click(function () {
        var count = 0;
        var input = $('.form_block input:not("#accept"):not(".radio_btn")');
        input.removeClass('has-error').removeClass('has-success');
        input.each(function () {
            if($(this).val()==""){
                $(this).parent().addClass('has-error');
                $(this).parent().removeClass('has-success');
                count++;
            }else{
                if($(this).attr('id')=='email_conf'){
                    if($(this).val()!=$('#email').val()){
                        $(this).parent().addClass('has-error');
                        count++;
                    }
                }else{
                    $(this).parent().addClass('has-success');
                    $(this).parent().removeClass('has-error');
                }

            }
        });
        if(count!=0){
            return false;
        }
    });
    $('.form_block input:not("#accept")').keydown(function () {
        $('.form_block input:not("#accept")').parent().removeClass('has-error');
    });
});

JS;
$this->registerJs($script);
?>