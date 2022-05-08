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
                    <input type="submit" name="select" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Selectionner">
                </div>
                <div class="col">
                    <input type="submit" name="modify" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Modifier">
                </div>
                <div class="col">
                    <input type="submit" name="delete" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Supprimer">
                </div>
                <!--<div class="col">
                    <button name="new" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Nouveau</button>
                </div>-->
                <div class="col">
                    <button name="duplicate" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Dupliquer</button>
                </div>
                <div class="col">
                    <input type="button" class="btn btn--sm btn--outline-primary d-block modal-open" data-target="#modal-import" style="width: 100%" value="Importer">
                </div>
                <div class="col">
                    <input type="button" class="btn btn--sm btn--outline-primary d-block modal-open" data-target="#modal-export" style="width: 100%" value="Exporter">
                </div>
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
            <h3>Front end</h3>
            <hr/>
            <div class="row">
                <div class="col-12 col-lg-4 p-0">
                    <div class="color-picker-bg">
                        <div class="color-picker">
                        <input type="color" name="color-back-page" id="color-back-page" class="color-picker-input" value="<?=$content['color-back-page'] ?? '#ff0000'?>">
                            <label for="color-back-page" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Font de la page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page" id="color-title-page" class="color-picker-input" value="<?=$content['color-title-page'] ?? '#ff0000'?>">
                            <label for="color-title-page" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link" id="color-text-link" class="color-picker-input" value="<?=$content['color-text-link'] ?? '#ff0000'?>">
                            <label for="color-text-link" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link-bis" id="color-text-link-bis" class="color-picker-input" value="<?=$content['color-text-link-bis'] ?? '#ff0000'?>">
                            <label for="color-text-link-bis" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-0">
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-back-page1" id="color-back-page1" class="color-picker-input" value="<?=$content['color-back-page1'] ?? '#ff0000'?>">
                            <label for="color-back-page1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Font de la page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page1" id="color-title-page1" class="color-picker-input" value="<?=$content['color-title-page1'] ?? '#ff0000'?>">
                            <label for="color-title-page1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link1" id="color-text-link1" class="color-picker-input" value="<?=$content['color-text-link1'] ?? '#ff0000'?>">
                            <label for="color-text-link1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link-bis1" id="color-text-link-bis1" class="color-picker-input" value="<?=$content['color-text-link-bis1'] ?? '#ff0000'?>">
                            <label for="color-text-link-bis1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-0">
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-back-page2" id="color-back-page2" class="color-picker-input" value="<?=$content['color-back-page2'] ?? '#ff0000'?>">
                            <label for="color-back-page2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Font de la page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page2" id="color-title-page2" class="color-picker-input" value="<?=$content['color-title-page2'] ?? '#ff0000'?>">
                            <label for="color-title-page2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link2" id="color-text-link2" class="color-picker-input" value="<?=$content['color-text-link2'] ?? '#ff0000'?>">
                            <label for="color-text-link2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link-bis2" id="color-text-link-bis2" class="color-picker-input" value="<?=$content['color-text-link-bis2'] ?? '#ff0000'?>">
                            <label for="color-text-link-bis2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                </div>
            </div>
            <h3>Connexion / Inscription</h3>
            <hr/>
            <div class="row">
                <div class="col-12 col-lg-4 p-0">
                    <label for="picture">
                        <div class="picture-picker">
                            <img class="picture-picker-img" src="http://localhost/Assets/images/WAP.jpeg">
                            <input type="file" name="picture" id="picture" class="picture-picker-input" value="">
                            <label for="picture" class="picture-picker-info">Font de la page</label>
                        </div>
                    </label>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page3" id="color-title-page3" class="color-picker-input" value="<?=$content['color-title-page3'] ?? '#ff0000'?>">
                            <label for="color-title-page3" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link3" id="color-text-link3" class="color-picker-input" value="<?=$content['color-text-link3'] ?? '#ff0000'?>">
                            <label for="color-text-link3" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-back-separator" id="color-back-separator" class="color-picker-input" value="<?=$content['color-back-separator'] ?? '#ff0000'?>">
                            <label for="color-back-separator" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Séparateur</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="modal-import" class="modal" style="color:#000;">
        <div class="modal-content modal-content--sm">
            <div class="modal-header">
                <span class="modal-close modal-close-cross">&times;</span>
                <h2>Importer un theme</h2>
            </div>
            <div class="modal-body">
                <p>Selectionner un theme à importer</p>
                <input type="file" name="importTheme" id="importTheme">
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn--secondary modal-close" value="Fermer">
                <input type="submit" name="import" class="btn btn--primary" value="Importer">
            </div>
        </div>
    </div>
    <div id="modal-export" class="modal" style="color:#000;">
        <div class="modal-content modal-content--sm">
            <div class="modal-header">
                <span class="modal-close modal-close-cross">&times;</span>
                <h2>Exporter un theme</h2>
            </div>
            <div class="modal-body">
                <!--<a href="<?php//$file?>.css"><?php//$fileName?>.css</a>
                <a href="<?php//$file?>.json"><?php//$fileName?>.json</a>-->
                <a target="_Blanck" href="<?=$exportRoute?>.css"><?=$fileName?>.css</a>
                <a target="_Blanck" href="<?=$exportRoute?>.json"><?=$fileName?>.json</a>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn--secondary modal-close" value="Fermer">
                <input type="submit" name="export" class="btn btn--primary" value="Exporter">
            </div>
        </div>
    </div>
</form>
