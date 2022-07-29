<?php
require_once 'include/inc.php';

$guestBookRepository = new \Kelnik\Repository\GuestBookRepository();
$result = $guestBookRepository->findNewRecords();
?>

<html lang="ru">
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 pb-5">
            <form class="js-guest_from" method="post" action="/public/api/add_comment.php">
                <div class="card border-primary rounded-0">
                    <div class="card-header p-0">
                        <div class="bg-info text-white text-center py-2">
                            <p class="m-0">Добавить запись</p>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" value="Тестовое Имя" placeholder="Имя" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                </div>
                                <input type="text" class="form-control" value="test@mail.ru" id="email" name="email" placeholder="test@gmail.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-comment text-info"></i></div>
                                </div>
                                <textarea name="body" class="form-control" placeholder="Сообщение" required>Тестовое сообщение</textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <input type="submit" value="Отправить" class="btn btn-info btn-block rounded-0 py-2">
                        </div>
                        <div class="js-notify" style="display: none"></div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default widget">
            <div class="panel-body">
                <ul class="list-group">
                    <?php foreach ($result as $guestBook):?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-xs-10 col-md-11">
                                    <div>
                                        <div class="mic-info">
                                            <?=htmlentities($guestBook->getName())?> | <?=$guestBook->getDateCreate()->format('Y-m-d H:i:s')?>
                                        </div>
                                    </div>
                                    <div class="comment-text">
                                        <?=htmlentities($guestBook->getBody())?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(function() {
        const formBlock = $('.js-guest_from');
        const notifyBlock = $('.js-notify');

        formBlock.submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let actionUrl = form.prop('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                success: function(data)
                {
                    notifyBlock.text('Сообщение успешно добавлено').show();
                },
                error: function (data) {
                    notifyBlock.text('Сообщение не добавлено: ' + data.responseJSON.error + '.').show();
                }
            });

        });
    });
</script>
</html>
