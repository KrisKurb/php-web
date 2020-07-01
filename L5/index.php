<?php
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="header">
    <nav class="header__nav">
        <a class="header__link" href="#">FORM</a>
    </nav>
</header>
<section class="main">
    <div class="container container_1">
        <div id="block__form" class="block__form">
            <h1 class="main__title">Введите ваши данные!</h1>
            <form id="ajax_form" class="main__form" method="post" action="">
                <div class="form__row">
                    <label for="inputName" class="form__label">Имя:</label>
                    <input type="text" name="name" class="form__input" id="inputName" placeholder="Кристина">
                </div>
                <div class="form__row">
                    <label for="inputSurname" class="form__label">Фамилия:</label>
                    <input type="text" name="surname" class="form__input" id="inputSurname" placeholder="Курбатова">
                </div>
                <div class="form__row">
                    <label for="inputPatronymic" class="form__label">Отчество:</label>
                    <input type="text" name="patronymic" class="form__input" id="inputPatronymic" placeholder="Александровна">
                </div>
                <div class="form__row">
                    <label for="inputEmail" class="form__label">E-mail:</label>
                    <input type="email" name="email" class="form__input" id="inputEmail" placeholder="kris@mail.ru">
                </div>
                <div class="form__row">
                    <label for="inputPhone" class="form__label">Телефон:</label>
                    <input type="tel" name="num" class="form__input" id="inputPhone" placeholder="+7(940)452-12-25">
                </div>
                <div class="form__button">
                    <button type="submit" id="btn" class="button">Отправить</button>
                </div>
            </form>
        </div>

        <div id="new_view" class="block__result display_none">
            <h1 class="main__title">Мы с вами свяжемся!</h1>
            <div id="message" class="message">
                <p id="textMessage" class="message__text"></p>
            </div>
            <div id="result_form" class="font_default"></div>
        </div>
    </div>
</section>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="js/js.js"></script>
</html>