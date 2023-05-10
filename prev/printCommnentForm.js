"use strict";
export async function printForm() {
    let formContainer = document.querySelector('#form');
    formContainer.innerHTML = createHTMLForm();
}

export function eventForSubmitButton(callback1, callback2) {
    let submitButton = document.querySelector('#submitComment');
    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        if (validateForm()) {
            let titleFrom = document.querySelector('#title');
            let contentForm = document.querySelector('#content');
            fetch('/storeComments', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded',
                },
                body: `title=${titleFrom.value}&content=${contentForm.value}`
            }).then(() => {
                titleFrom.value = '';
                contentForm.value = '';
                callback1(callback2);
            }).then(callback2);
        }
    })
}

function createHTMLForm() {
    let html =
        `<form name="commentsForm" id="ddd">
            <div>
                <label for="title">Title:</label>
            </div>
            <input id="title" name="title" type="text"/>
            <div>
                <label for="content">Content:</label>
            </div>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
            <div>
                <button id="submitComment" type="submit">Submit</button>
            </div>
        </form>`;
    return html;
}

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