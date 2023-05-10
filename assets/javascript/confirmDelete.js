'use strict';

let deleteButtons = document.querySelectorAll('#deleteButton');

handleClickDeleteButton(deleteButtons);

export function handleClickDeleteButton(deleteButtons) {
    deleteButtons.forEach(item => {
        item.addEventListener('click', (event) => {
            if (confirm("Do you want to delete?")) {
                let idForDelete = event.target.getAttribute('data-id');
                fetch(`/comment/delete/${idForDelete}?page=`).then(() => {
                    location.reload()
                });
            }
        })
    })
}
