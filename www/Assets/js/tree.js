$(document).ready(() => {
    const toggler = $('.tree-arrow')
    toggler.each((i, elem) => {
        $(elem).click(function() {
            $(this).parent().parent()
                .children('.tree-nested')
                .toggleClass('active')
            $(this).toggleClass('tree-down')
        })
    })
})
