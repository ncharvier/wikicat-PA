$(document).ready(() => {
    $('.color-picker').each((i, elem) => {
        const colorPickerInput = $(elem).children('.color-picker-input')
        const colorPickerInfo = $(elem).children('.color-picker-info')
        colorPickerInfo.text(colorPickerInput.val())

        $(elem).change(function() {
            colorPickerInfo.text(colorPickerInput.val())
        })
    })
})
