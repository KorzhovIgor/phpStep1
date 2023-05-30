'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const select = document.querySelector('#db-type');
    select.addEventListener('change', (event) => {
        document.cookie = `database=${event.target.value}`;
    })
})