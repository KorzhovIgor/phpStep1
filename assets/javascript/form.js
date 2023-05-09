'use strict';

let form = document.querySelector('#ddd');
form.addEventListener('submit', (event) => {
    if (!validateForm()) {
        event.preventDefault();
    }
})

function validateForm() {
    let title = document.forms["commentsForm"]["title"].value;
    let content = document.forms["commentsForm"]["content"].value;
    if (title === "") {
        alert("Fill title!!!");
        return false;
    }
    if (content.length < 5) {
        alert("too short content!!!");
        return false;
    }
    return true;
}