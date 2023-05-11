$(document).ready(function () {
    $("#delete-setter").click(function () {
        let deleteCheckboxes = $(".delete-checkbox");
        deleteCheckboxes.prop('checked', true);
    });

    $("#delete-unsetter").click(function () {
        let deleteCheckboxes = $(".delete-checkbox");
        deleteCheckboxes.prop('checked', false);
    });

    $("#delete-chosen-comments").click(function () {
        if (confirm("Do you want to delete chosen comments?")) {
            let commentsId = Array.from($(".delete-checkbox:checked").map(function () {
                return this.id;
            }));
            $.ajax({
                url: '/comments/deleteFewComments',
                method: 'POST',
                dataType: 'json',
                data: {
                    request: JSON.stringify(commentsId),
                }
            });
            $(document).ajaxStop(function () {
                window.location.reload();
            });
        }
    });

});