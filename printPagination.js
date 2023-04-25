'use strict';

export async function getCountPagesAndPrintPagination() {
    removePagination();
    getCountComments().then(data => {
        let paginatorContainer = document.querySelector('#pagination');
        paginatorContainer.innerHTML = createHTMLPaginator(data);

    })
}

async function getCountComments() {
    let response = await fetch('/api/comments/count');
    return await response.json();
}

function createHTMLPaginator(countOfPage) {
    let html = '<div class="container">';
    for (let pageNumber = 1; pageNumber <= countOfPage; pageNumber++) {
        html +=
            `<div class="containerForLink">
                <a class="link" href="/?page=${pageNumber}">${pageNumber}</a>
            </div>`
    }
    html += '</div>'
    return html;
}

export function removePagination() {
    let pagination = document.getElementById('pagination').firstChild;
    pagination.remove();
}


