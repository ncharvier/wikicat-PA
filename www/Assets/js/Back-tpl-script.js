$(".main-nav-choice[data-wc-target]").click(function (){
    $("#" + $(this).data("wc-target")).slideToggle(300);
});

$(".comment-open-up[data-wc-target]").click(function (){
    $("#" + $(this).data("wc-target")).slideToggle(300);
});