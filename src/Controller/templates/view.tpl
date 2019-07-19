{include file="header.tpl"}
<div class="container">
    <h1 class="text-center">Добро пожаловать!</h1>
    <hr class="mt-4 mb-4">
    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="alertBox" style="display:none;">
        <strong>Спасибо за ваш отзыв!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="row">
        <div class="col" id="addBlock"><h4>Оставить свой отзыв</h4>
            <form action="/record" method="post" name="addRecord" id="addRecord">
                <div class="form-group">
                    <label for="inputUserName">Ваше имя</label>
                    <input type="text" class="form-control" name="inputUserName" id="inputUserName" placeholder="Имя"
                           aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text text-muted">Допускаются латинские буквы, цифра и точка.
                    </small>
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email"
                           aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Мы никогда и ни с кем не делимся вашим адресом
                        email.
                    </small>
                </div>
                <div class="form-group">
                    <label for="inputMessage">Сообщение</label>
                    <textarea class="form-control" name="inputMessage" id="inputMessage" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <img class="rounded float-left p-3" src="/captcha"/><br/><input type="text" class="form-control"
                                                                                    name="inputCAPTCHA"
                                                                                    id="inputCAPTCHA" placeholder=""
                                                                                    aria-describedby="CAPTCHAHelp">
                    <small id="CAPTCHAHelp" class="form-text text-muted">Проверка на человечность, введите текст с
                        картинки.
                    </small>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        <div id="recordsTable" class="col">
        </div>
    </div>
</div>
{include file="footer.tpl"}