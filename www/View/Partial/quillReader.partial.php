<div id="pageContent" style="height: auto">

</div>

<script>
    var quill = new Quill('#pageContent', {
        modules: { toolbar: false }
    });

    quill.setContents(JSON.parse("<?=addslashes($config!=""?$config:"{}")?>"));
    quill.disable();
</script>
