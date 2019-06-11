function send_message() {
    message = document.getElementById("message").value;
    username = document.getElementById("username").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "?r=api/insert");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("username=" + username + '&message=' + message);
    document.getElementById("message").value = "";
}

function delete_message(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "?r=api/delete");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            var data = xhr.responseText;
        }
    }
}

function refreshChat(jcount) {
    if (jcount == undefined) {
        jcount=-1;
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState != 4) return;

        if (this.status == 200) {
            if (this.responseText) {
                var data = this.responseText;
                var json = JSON.parse(data);
                var json_count = json.length;

                //Вывод сообщений
                for (i in json) {
                    if (i>jcount-1) {
                        showMessage(json[i]);
                    }
                }

                //Формируем массив удаленных сообщений, но еще отображаемых на экране
                var array = [];
                var messages = document.querySelectorAll('div[id^="m_"]');
                for (var k = 0; k < messages.length; k++) {
                    array.push(messages[k].id);
                }
                for (i in json) {
                    //Убираем из массива сообщения, которые должны остаться
                    array.splice( array.indexOf('m_' + json[i]['id']), 1 );

                    //Проверка изменилось ли количество лайков
                    var elemLike = document.querySelector('[id="m_' + json[i]['id'] + '"] .likes');
                    var likes_number = elemLike.innerText;
                    if (json[i]['likes'] != likes_number) {
                        elemLike.innerText= json[i]['likes'];
                    }
                    //
                }

                //Остался массив с удаленными сообщениями. Убираем их.
                for (var k = 0; k<array.length; k++) {
                    elemDel = document.getElementById(array[k]);
                    elemDel.parentNode.removeChild(elemDel);
                }
            }
            setTimeout(function () {refreshChat(json_count);}, 5000);
        } else {
            setTimeout(function () {refreshChat(json_count);}, 20000);
        }
    }
    xhr.open("GET", "?r=api/data", true);
    xhr.send();
}
refreshChat();


function showMessage(data) {
    elem = document.getElementById("chat");
    var messageElem = document.createElement('div');
    messageElem.id = "m_" + data['id'];
    messageElem.classList.add("message");
    messageElem.innerHTML += '<p><span class="time-left">' + data['datetime'] + '</span></p><p>' + data['name'] + ' : ' + data['message'] + '</p><p><button onclick="add_like(' + data['id'] + ')">\t&#9829;</button> <span class="likes">' + data['likes'] + '</span></p><BR>';

    //Обработка пробелов и русского языка в куках
    var nospace = data['name'].replace(" ", "+");

    //Если это автор сообщения, то выводим кнопку Удалить
    if ((nospace == decodeURIComponent(getCookie('username')))) {
        messageElem.classList.add("my");
        messageElem.innerHTML += '<button onclick="delete_message(' + data['id'] + ');">Удалить</button>';
    }
    elem.appendChild(messageElem);
}


function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

function add_like(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "?r=api/like");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("id=" + id);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            var data = xhr.responseText;
        }
    }
}


function modal(id) {
//Загрузка модального окна
    var modal = document.getElementById(id);
    var close = document.querySelectorAll('[data-close="true"]');
    modal.style.display = 'block';
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            modal.style.display = 'none';
        }
    }
    window.onclick = function(e){
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    };
    document.onkeydown = function(e) {
        if (e.keyCode == 27) {
            modal.style.display = 'none';
        }
    };
}

function add_attachment(type) {
    if (type == 'img') {

    } else {
        var datum = document.forms[type][0].value;
    }
    if (datum != '') {
        if (type == 'youtube') {
            document.getElementById("message").value += '\n[youtube]' + datum + '[/youtube]';
        }
        if (type == 'url') {
            document.getElementById("message").value += '\n[url]' + datum + '[/url]';
        }
        //Очищаем данные формы
        var allElements= document.forms[type].querySelectorAll('input');
        for(i=0;i<allElements.length;i++) {
            allElements[i].value="";
        }
        document.getElementById(type).style.display = 'none';
    } else {
        alert("empty!");
    }
}

function upload_file() {

    var file = document.forms.upload[0].files[0];

    if (file != undefined) {
        var contentbody = document.getElementById('img').childNodes[1].childNodes[3];
        var fd = new FormData();
        fd.append("myimg", file);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "?r=api/file");
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                contentbody.innerHTML += percentComplete + '% uploaded<BR>';
            }
        };

        xhr.send(fd);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                var data = xhr.responseText;
                contentbody.innerHTML += data + '<BR>';
                document.getElementById("message").value += '\n[img]' + file.name + '[/img]';
            }
        }
    } else {
        alert('empty!');
    }
}