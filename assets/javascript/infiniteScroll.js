'use strict';

import {handleClickDeleteButton, removeEventForDeleteButtons} from './confirmDelete.js';

document.addEventListener('DOMContentLoaded', () => {
    let page = 2;
    let tbody = document.querySelector("#bodyForInsert");
    document.addEventListener(
        'scroll',
        (event) => {
            if ((window.innerHeight + window.scrollY) + 1 > document.body.offsetHeight) {
                requestAndPrintComments(page, tbody).then(() => {
                    let deleteButtons = document.querySelectorAll('#deleteButton');
                    removeEventForDeleteButtons(deleteButtons);
                    handleClickDeleteButton(deleteButtons);
                });
                page++;

            }
        },
        { passive: true }
    );
});

async function requestAndPrintComments(page, tbody) {
   let response = await fetch(`/api/comments/?page=${page}`);
   let comments = await response.json();
   let commentsHTML = createHTMLTable(comments);
   tbody.innerHTML += commentsHTML;
}

function createHTMLTable(data) {
    let html = '';
    data.forEach(item => {
        html +=
        `<tr>
            <td>
                 ${item['id']}
            </td>
            <td>
                ${item['title']}
            </td>
            <td class="text-break">
                 ${item['content']}
            </td>
            <td>
                ${item['created_at']}
            </td>
            <td>
                <a class="btn btn-primary" href="/comment/${item['id']}">Open</a>
                <button id="deleteButton" class="btn btn-primary" data-id="${item['id']}"
                                type="button">Delete</button>
            </td>  
        </tr>`
    })
    return html;
}
