<div id="pageContent">

</div>

<script>
    let tempCont = document.createElement("div");
    (new Quill(tempCont)).setContents(<?=$config?>);
    $("#pageContent").html(tempCont.getElementsByClassName("ql-editor")[0].innerHTML);
</script>