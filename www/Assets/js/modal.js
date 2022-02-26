$(document).ready(() => {
    const modal = $('.modal')
    const btn = $('.modal-open')
    const span = $('.modal-close')

    btn.click(function() {
        $($(this).data('target'))
            .css('display', 'block')
    })

    span.click(function() {
        $(this).parent().parent().parent()
            .css('display', 'none')
    })

    modal.click(function(event) {
        if ($(event.target).is(modal))
            modal.css('display', 'none')
    })
})
