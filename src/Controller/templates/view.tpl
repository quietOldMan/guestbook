{include file="header.tpl"}
<div class="container">
    <h1 class="text-center">Добро пожаловать!</h1>
    <hr class="mt-4 mb-4">
    <div class="row">
        <div class="col"><h4>Оставить свой отзыв</h4>
            <form>
                <div class="form-group">
                    <label for="inputUserName">Ваше имя</label>
                    <input type="text" class="form-control" id="inputUserName" placeholder="Имя" aria-describedby="nameHelp">
                    <small id="nameHelp" class="form-text text-muted">Допускаются латинские буквы, цифра и точка.</small>
                </div>
                <div class="form-group">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Мы никогда и ни с кем не делимся вашим адресом email.</small>
                </div>
                <div class="form-group">
                    <label for="inputMessage">Сообщение</label>
                    <textarea class="form-control" id="inputMessage" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        <div id="recordsTable" class="col">
        </div>
    </div>
</div>
{include file="footer.tpl"}