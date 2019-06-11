<head>
    <meta http-equiv="Cache-Control" content="no-store" />
    <title>Chat</title>
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/global.css">
</head>
<div id="youtube" class="modal">
    <div class="modalContent">
        <div class="modalHeader">
            <span class="modalClose" data-close="true" title="Close">&times;</span>
            <BR>
        </div>
        <div class="modalBody">
            <form name="youtube">
                <label>Добавьте ссылку на Youtube-ролик:</label>
                <input type="text" name="datum" class="form-control">
            </form>
        </div>
        <div class="modalFooter">
            <div>
                <button type="button" class="btn" data-close="true">Закрыть</button>
                <button type="button" id="submit" class="btn btnPrimary" onclick="add_attachment('youtube');">Сохранить</button>
            </div>
            <BR>
        </div>
    </div>
</div>


<div id="url" class="modal">
    <div class="modalContent">
        <div class="modalHeader">
            <span class="modalClose" data-close="true" title="Close">&times;</span>
            <BR>
        </div>
        <div class="modalBody">
            <form name="url">
                <label>Добавьте адрес ссылки:</label>
                <input type="text" name="datum" class="form-control">
            </form>
        </div>
        <div class="modalFooter">
            <div>
                <button type="button" class="btn" data-close="true">Закрыть</button>
                <button type="button" id="submit" class="btn btnPrimary" onclick="add_attachment('url');">Сохранить</button>
            </div>
            <BR>
        </div>
    </div>
</div>


<div id="img" class="modal">
    <div class="modalContent">
        <div class="modalHeader">
            <span class="modalClose" data-close="true" title="Close">&times;</span>
            <BR>
        </div>
        <div class="modalBody">
            <form name="upload">
                <input type="file" accept="image/*"/>
            </form>
        </div>
        <div class="modalFooter">
            <div>
                <button type="button" class="btn" data-close="true">Закрыть</button>
                <button type="button" id="submit" class="btn btnPrimary" onclick="upload_file();">Загрузить</button>
            </div>
            <BR>
        </div>
    </div>
</div>

<div id="chat">
    CHAT:
</div>



    <div class="row">Отправьте сообщение:</div>
<form
    <div><?= $data ?>:<textarea rows="10" cols="60" id="message" name="message"></textarea></div>
    <input type="hidden" id="username" name="name" value="<?= $data ?>">
    <div class="row">
        <button type="button" onclick="modal('youtube')">Youtube</button>
        <button type="button" onclick="modal('url')">Ссылки</button>
        <button type="button" onclick="modal('img')">Картинки</button>
    </div>
    <div class="row">
        <button type="button" onclick="send_message();">Отправить сообщение</button>
    </div>
</form>
<BR><BR>
<a href="?r=login/logout">(Выход)</a>
<script src="js/chat.js"></script>