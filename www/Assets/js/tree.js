$(document).ready(() => {
    $("body").on("click", ".tree-arrow", function (){
        $(this).parent().parent()
            .children('.tree-nested')
            .toggleClass('active')
        $(this).toggleClass('tree-down')
    });
})
