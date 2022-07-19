<form method="<?= $config["config"]["method"]??"POST" ?>" action="<?= $config["config"]["action"]??"" ?>">

    <?php foreach ($config["inputs"] as $name=>$input):?>
        <?php if ($input["type"] == "file"): ?>
            <input name="<?=$name?>"
                   type="<?=$input["type"]?>"
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
                       id="<?=$option["id"]?>"
                       value="<?=$option["value"]?>">
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
        <?php elseif($input["type"] == "submit" || $input["type"] == "button"):?>
            <input name="<?=$name?>"
                id="<?=$input["id"]?>"
                type="<?=$input["type"]?>"
                class="<?=$input["class"]?>"
                value="<?=$input["value"]?>"
                style="<?=$input["style"]?>"
            >
        <?php elseif($input["type"] == "hidden"):?>
            <input name="<?=$name?>"
                type="<?=$input['type']?>"
                value="<?=$input['value']?>"
            >
        <?php else:;?>
            <input name="<?=$name?>"
                   id="<?=$input["id"]?>"
                   type="<?=$input["type"]?>"
                   class="<?=$input["class"]?>"
                   placeholder="<?=$input["placeholder"]?>"
                <?= (!empty($input["required"]))?'required="required"':'' ?>
            >
        <?php endif;?>
        <br>
    <?php endforeach;?>

    <input type="submit" value="<?= $config["config"]["submit"]??"Valider" ?>">
</form>
