
$("[data-confirm]").click(function() {
    return confirm($(this).attr('data-confirm'));
});