"use strict";

export async function getCommentsAndPrintTable(callback) {
    removeTable();
    getComments().then((comments) => {
        let tableContainer = document.querySelector('#table');
        tableContainer.innerHTML = createHTMLTable(comments);
        let deleteButtons = document.querySelectorAll('#deleteButton');
        deleteButtons.forEach( deleteButton => {
            deleteButton.addEventListener('click', (event) => {
                event.preventDefault();
                let idForDelete = event.target.getAttribute('data-id');
                fetch(`/api/comments/delete/?id=${idForDelete}`).then(() => {
                    getCommentsAndPrintTable(callback);
                }).then(callback);
            })
        })
    })
}

export function removeTable() {
    let table = document.getElementById('table').firstChild;
    table.remove();
}

async function getComments() {
    let query = window.location.search;
    let response = await fetch(`/api/comments/${query}`);
    return await response.json();
}

function createHTMLTable(data) {
    let html =
        `<table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>title</th>
                    <th>content</th>
                    <th>created at</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>`
    data.forEach(item => {
        html +=
        `<tr>
            <td>
                 ${item['id']}
            </td>
            <td>
                ${item['title']}
            </td>
            <td>
                 ${item['content']}
            </td>
            <td>
                ${item['created_at']}
            </td>
            <td>
                <button id="deleteButton" data-id="${item['id']}" type="button">Delete</button>
            </td>  
        </tr>`
    })
    html += `</tbody></table>`
    return html;
}

