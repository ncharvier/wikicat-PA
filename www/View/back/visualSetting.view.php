<form action="" method="POST" enctype="multipart/form-data">
    <div class="col-12 p-0">
        <?php if (!empty($error)):?>
        <div class="alert alert--danger">
        <?=$error?>
        </div>
        <?php endif?>
        <section class="main-section">
            <h2>Choix du thème</h2>
            <div class="form-controller">
                <select class="form-input-back" name="selectThemeName">
                    <?php foreach ($themeList as $theme):?>
                    <option value="<?=$theme?>" <?=$selectedTheme == $theme ? "selected" : ""?>><?=$theme?></option>
                    <?php endforeach?>
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <input type="submit" name="apply" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Appliquer">
                </div>
                <div class="col">
                    <input type="submit" name="select" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Selectionner">
                </div>
                <div class="col">
                    <input type="submit" name="modify" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Modifier">
                </div>
                <div class="col">
                    <input type="submit" name="delete" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Supprimer">
                </div>
                <!--<div class="col">
                    <button name="duplicate" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Dupliquer</button>
                </div>-->
                <div class="col">
                    <input type="button" class="btn btn--sm btn--outline-primary d-block modal-open" data-target="#modal-rename" style="width: 100%" value="Renommer">
                </div>
                <div class="col">
                    <input type="button" class="btn btn--sm btn--outline-primary d-block modal-open" data-target="#modal-import" style="width: 100%" value="Importer">
                </div>
                <div class="col">
                    <input type="button" class="btn btn--sm btn--outline-primary d-block modal-open" data-target="#modal-export" style="width: 100%" value="Exporter">
                </div>
            </div>
            <div>
                Theme courrant : <?=$currentTheme?>
            </div>
        </section>
        <section class="main-section">
            <div class="row">
                <div class="col-9">
                    <div class="form-controller">
                        <input type="text" name="themeName" class="form-input-back" placeholder="Nom du thème">
                    </div>
                </div>
                <div class="col-3">
                    <input type="submit" name="submitTheme" class="btn btn--success" style="width: 100%" value="Enregistrer">
                </div>
            </div>
            <h3>Backoffice</h3>
            <hr/>
            <div class="row">
                <div class="col-12 col-lg-3 p-0">
                    <?php foreach ($cssAttributeCol1 as $attr):?>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="<?=$attr['name']?>" id="<?=$attr['name']?>" class="color-picker-input" value="<?=$content[$attr['name']] ?? '#ff0000'?>">
                            <label for="<?=$attr['name']?>" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text"><?=$attr['description']?></span>
                    </div>
                    <?php endforeach?>
                </div>
                <div class="col-12 col-lg-3 p-0">
                    <?php foreach ($cssAttributeCol2 as $attr):?>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="<?=$attr['name']?>" id="<?=$attr['name']?>" class="color-picker-input" value="<?=$content[$attr['name']] ?? '#ff0000'?>">
                            <label for="<?=$attr['name']?>" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text"><?=$attr['description']?></span>
                    </div>
                    <?php endforeach?>
                </div>
                <div class="col-12 col-lg-3 p-0">
                    <?php foreach ($cssAttributeCol3 as $attr):?>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="<?=$attr['name']?>" id="<?=$attr['name']?>" class="color-picker-input" value="<?=$content[$attr['name']] ?? '#ff0000'?>">
                            <label for="<?=$attr['name']?>" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text"><?=$attr['description']?></span>
                    </div>
                    <?php endforeach?>
                </div>
                <div class="col-12 col-lg-3 p-0">
                    <?php foreach ($cssAttributeCol4 as $attr):?>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="<?=$attr['name']?>" id="<?=$attr['name']?>" class="color-picker-input" value="<?=$content[$attr['name']] ?? '#ff0000'?>">
                            <label for="<?=$attr['name']?>" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text"><?=$attr['description']?></span>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
            <h3>Connexion / Inscription</h3>
            <hr/>
            <div class="row">
                <div class="col-12 col-lg-3 p-0">
                    <?php foreach ($cssAttributeCol5 as $attr):?>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="<?=$attr['name']?>" id="<?=$attr['name']?>" class="color-picker-input" value="<?=$content[$attr['name']] ?? '#ff0000'?>">
                            <label for="<?=$attr['name']?>" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text"><?=$attr['description']?></span>
                    </div>
                    <?php endforeach?>
                </div>
            </div>
        </section>
    </div>
    <div id="modal-import" class="modal">
        <div class="modal-content modal-content--sm modal-content-dark">
            <div class="modal-header modal-header-dark">
                <span class="modal-close modal-close-cross">&times;</span>
                <h2>Importer un theme</h2>
            </div>
            <div class="modal-body modal-body-dark">
                <p>Selectionner un theme à importer (fichier json)</p>
                <input type="file" name="fileTheme" id="importTheme">
            </div>
            <div class="modal-footer modal-footer-dark">
                <input type="button" class="btn btn--secondary modal-close" value="Fermer">
                <input type="submit" name="import" class="btn btn--primary" value="Importer">
            </div>
        </div>
    </div>
    <div id="modal-export" class="modal">
        <div class="modal-content modal-content--sm modal-content-dark">
            <div class="modal-header modal-header-dark">
                <span class="modal-close modal-close-cross">&times;</span>
                <h2>Exporter un theme</h2>
            </div>
            <div class="modal-footer modal-footer-dark">
                <input type="button" class="btn btn--secondary modal-close" value="Fermer">
                <input type="submit" name="export" class="btn btn--primary" value="Exporter">
            </div>
        </div>
    </div>
    <div id="modal-rename" class="modal">
        <div class="modal-content modal-content--sm modal-content-dark">
            <div class="modal-header modal-header-dark">
                <span class="modal-close modal-close-cross">&times;</span>
                <h2>Renommer un theme</h2>
            </div>
            <div class="modal-body modal-body-dark ">
                <div class="form-controller">
                    <input type="text" name="renameTheme" class="form-input-back" value="<?=$selectedTheme ?? ''?>">
                </div>
            </div>
            <div class="modal-footer modal-footer-dark">
                <input type="button" class="btn btn--secondary modal-close" value="Fermer">
                <input type="submit" name="rename" class="btn btn--primary" value="Renommer">
            </div>
        </div>
    </div>
</form>
