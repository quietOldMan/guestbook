{include file="header.tpl"}
<div class="container">
    <h1 class="text-center">Добро пожаловать!</h1>
    <hr class="mt-4 mb-4">
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="successBox" style="display:none;">
        <strong>Спасибо за ваш отзыв!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger" style="display:none;" role="alert" id="errorBox">
        <strong>Ошибка при записи данных! Проверьте поля на недопустимые значения.</strong>
    </div>
    <div class="row">
        <div class="col" id="addBlock"><h4>Оставить свой отзыв</h4>
            <form action="/record" method="post" name="addRecord" id="addRecord">
                <div class="form-group">
                    <label for="inputUserName">Ваше имя</label>
                    <input type="text" class="form-control" name="inputUserName" id="inputUserName" placeholder="Имя"
                           aria-describedby="nameHelp" required>
                    <small id="nameHelp" class="form-text text-muted">Допускаются латинские буквы, цифры и точка.
                    </small>
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email"
                           aria-describedby="emailHelp" required>
                    <small id="emailHelp" class="form-text text-muted">Мы никогда и ни с кем не делимся вашим адресом
                        email.
                    </small>
                </div>
                <div class="form-group">
                    <label for="inputMessage">Сообщение</label>
                    <textarea class="form-control" name="inputMessage" id="inputMessage" rows="3"
                              aria-describedby="messageHelp" required></textarea>
                    <small id="messageHelp" class="form-text text-muted" style="display:none;">HTML тэги недопустимы!
                    </small>
                </div>
                <div class="custom-file">
                    <label class="custom-file-label" for="inputFile">Прикрепить файл: текст или изображение</label>
                    <input type="file" class="custom-file-input" name="inputFile" id="inputFile"
                           accept=".jpg,.jpeg,.gif,.png,.txt">
                </div>
                <div class="form-group">
                    <img class="rounded float-left p-3" src="/captcha" id="captcha" name="captcha"/><br/>
                    <input type="text" class="form-control"
                           name="inputCAPTCHA"
                           id="inputCAPTCHA" placeholder=""
                           aria-describedby="CAPTCHAHelp" autocomplete="off" required>
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