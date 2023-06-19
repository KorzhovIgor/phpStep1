'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const select = document.querySelector('#db-type');
    document.cookie = `database=${select.value}`;
    select.addEventListener('change', (event) => {
        document.cookie = `database=${event.target.value}`;
    })
})