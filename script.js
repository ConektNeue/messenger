const msgBox = document.querySelector('.msg-box');
const msgUrl = './data.json';
let jsonData = null;

function findProp(obj, prop, defval){
    if (typeof defval == 'undefined') defval = null;
    prop = prop.split('.');
    for (var i = 0; i < prop.length; i++) {
        if(typeof obj[prop[i]] == 'undefined')
            return defval;
        obj = obj[prop[i]];
    }
    return obj;
}

function sendRequest() {
    let request = new XMLHttpRequest();
    request.open('GET', msgUrl);
    request.responseType = 'json';
    request.send();
    request.onload = function () {
        jsonData = request.response;

        for (let i = jsonData.length - 1; i >= 0; i--) {
            console.log(jsonData[i].content);
            let msgItem = document.createElement('div');
            msgItem.classList.add('msg-item');
            let star = '';
            if (jsonData[i].username == 'ConektNeue') {
                star = '<img src="./img/star-filled.png">';
            }
            msgItem.innerHTML = `
                <p class="username">${jsonData[i].username} ${star} <span>${jsonData[i].time}</span></p>
                <p class="content">${jsonData[i].content}</p>
            `;
            msgBox.appendChild(msgItem);
            if (i%2 == 0) {
                msgItem.style.backgroundColor = 'white';
            }
        }

    }
}

msgBox.innerHTML = '';
jsonData = null;
sendRequest();

setInterval(() => {
    msgBox.innerHTML = '';
    jsonData = null;
    sendRequest(); 
}, 5000);