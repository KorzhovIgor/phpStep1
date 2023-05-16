'use strict';

document.addEventListener('DOMContentLoaded', () => {
    if (getCookie("database") !== "") {
        document.cookie = "database=Default database";
    }
    const select = document.querySelector('#db-type');
    select.addEventListener('change', (event) => {
        document.cookie = `database=${event.target.value}`;
    })
})

function getCookie(cname) {
    let name = cname + "=";
    let cookie = document.cookie;
    let arrayOfCookie = cookie.split(';');
    for(let i = 0; i < arrayOfCookie.length; i++) {
        let cookie = arrayOfCookie[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}