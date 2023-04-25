'use strict';
import {getCommentsAndPrintTable} from '/printTable.js';
import {getCountPagesAndPrintPagination} from '/printPagination.js';
import {eventForSubmitButton, printForm} from '/printCommnentForm.js';

document.addEventListener('DOMContentLoaded', () => {
    basicLogic().then(resolve => {
        eventForSubmitButton(getCommentsAndPrintTable,  getCountPagesAndPrintPagination);
    });
})

async function basicLogic() {
    await getCommentsAndPrintTable(getCountPagesAndPrintPagination);
    await getCountPagesAndPrintPagination();
    await printForm();
}
