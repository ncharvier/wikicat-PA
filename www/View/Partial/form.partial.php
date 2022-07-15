<form id="<?= $config["config"]["form-id"]?>" method="<?= $config["config"]["method"]??"POST" ?>" action="<?= $config["config"]["action"]??"" ?>">
    <?php foreach ($config["inputs"] as $name=>$input):?>
        <div class="form-controller">
        <?php if ($input["type"] == "file"): ?>
            <input name="<?=$name?>"
                   type="file"
                   id="<?=$input["id"]?>"
                   accept="<?=$input["accept"]?>"
                   size="<?=$input["size"]?>"
                <?= (!empty($input["required"]))?'required="required"':'' ?>
            >
        <?php elseif($input["type"]== "radio"):?>
            <input type="hidden" value="null" name="<?=$name?>">
            <?php foreach ($input["options"]as $option):?>
                <input type="radio"
                       name="<?=$name?>"
                       id="<?=$option["id"]??""?>"
                       value="<?=$option["value"]??""?>">
            <?php endforeach?>
        <?php elseif ($input["type"] == "checkbox"): ?>
            <input type="hidden" value="null" name="<?=$name?>">
            <input name="<?=$name?>"
                   type="<?=$input["type"]?>"
                   id="<?=$input["id"]?>"
                   value="<?=$input["value"]?>"
            >
        <?php elseif($input["type"] == "textarea"): ?>
            <textarea name="<?=$name?>"
                      id="<?=$input["id"]?>"
                      class="<?=$input["class"]?>"
                      placeholder="<?=$input["placeholder"]?>"
                      rows="<?=$input["rows"] ?? 5 ?>"
                      cols="<?=$input["cols"] ?? 30 ?>"></textarea>
        <?php elseif($input["type"] == "select"):?>
            <select name="<?=$name?>"
                    id="<?=$input["id"]?>"
                    class="<?=$input["class"]?>">
                <?= (!empty($input["noSelection"]))?("<option value='null'>".$input["noSelection"]."</option>"):'' ?>

                <?php foreach ($input["options"] as $option):?>
                    <option value="<?=$option["value"]??$option["text"]?>" <?=(!empty($option["selected"]) && $option["selected"])?'selected="selected"':''?>>
                        <?=$option["text"]?>
                    </option>
                <?php endforeach;?>
            </select>
        <?php elseif($input["type"] == "quill"):?>
            <input id="<?=$input["id"]?>" name="<?=$name?>" type="hidden">

            <div id="<?=$input["id"]?>Quill"></div>

            <script>
                const toolbarOptions = [
                    [{ 'header': [2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'size': ['small', false, 'large', 'huge'] }],

                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],

                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],

                    ['clean']
                ];

                const quill = new Quill('#<?=$input["id"]?>Quill', {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    theme: 'snow'
                });

                quill.setContents(JSON.parse("<?=addslashes($input["default-value"]!=""?$input["default-value"]:"{}")?>"));

                $("#<?=$config["config"]["form-id"]?>").on("submit", function() {
                    $("#<?=$input["id"]?>").val(JSON.stringify(quill.getContents()));
                });
            </script>
        <?php else:?>
            <input name="<?=$name?>"
                   id="<?=$input["id"]??""?>"
                   type="<?=$input["type"]?>"
                   class="<?=$input["class"]??""?>"
                   placeholder="<?=$input["placeholder"]??""?>"
                   value="<?=$input["value"]??""?>"
                <?= (!empty($input["required"]))?'required="required"':'' ?>
            >
        <?php endif;?>
        <?php if (!empty($input["label"])):?>
            <label for="<?=$input["id"]?>" class="<?=$input["labelClass"]?>"><?=$input["label"]?></label>
        <?php endif;?>
        </div>
    <?php endforeach;?>

    <input class="<?=$config["config"]["submit-class"]??""?>" type="submit" value="<?= $config["config"]["submit"]??"Valider" ?>">
</form>
