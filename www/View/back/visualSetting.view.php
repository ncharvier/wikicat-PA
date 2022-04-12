<form action="" method="POST">
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
                    <option value="default">default</option>
                    <?php foreach ($themeList as $theme):?>
                    <option value="<?=$theme->name?>"><?=$theme->name?></option>
                    <?php endforeach?>
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <button name="select" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Selectionner</button>
                </div>
                <div class="col">
                    <input type="submit" name="modify" class="btn btn--sm btn--outline-primary d-block" style="width: 100%" value="Modifier">
                </div>
                <div class="col">
                    <button name="delete" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Supprimer</button>
                </div>
                <div class="col">
                    <button name="new" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Nouveau</button>
                </div>
                <div class="col">
                    <button name="duplicate" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Dupliquer</button>
                </div>
                <div class="col">
                    <button name="import" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Importer</button>
                </div>
                <div class="col">
                    <button name="export" class="btn btn--sm btn--outline-primary d-block" style="width: 100%">Exporter</button>
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
                            <input type="color" name="color-back-page" id="color-back-page" class="color-picker-input" value="#ff0000">
                            <label for="color-back-page" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Font de la page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page" id="color-title-page" class="color-picker-input" value="#ff0000">
                            <label for="color-title-page" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link" id="color-text-link" class="color-picker-input" value="#ff0000">
                            <label for="color-text-link" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link-bis" id="color-text-link-bis" class="color-picker-input" value="#ff0000">
                            <label for="color-text-link-bis" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-0">
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-back-page1" id="color-back-page1" class="color-picker-input" value="#ff0000">
                            <label for="color-back-page1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Font de la page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page1" id="color-title-page1" class="color-picker-input" value="#ff0000">
                            <label for="color-title-page1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link1" id="color-text-link1" class="color-picker-input" value="#ff0000">
                            <label for="color-text-link1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link-bis1" id="color-text-link-bis1" class="color-picker-input" value="#ff0000">
                            <label for="color-text-link-bis1" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-0">
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-back-page2" id="color-back-page2" class="color-picker-input" value="#ff0000">
                            <label for="color-back-page2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Font de la page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-title-page2" id="color-title-page2" class="color-picker-input" value="#ff0000">
                            <label for="color-title-page2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link2" id="color-text-link2" class="color-picker-input" value="#ff0000">
                            <label for="color-text-link2" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link-bis2" id="color-text-link-bis2" class="color-picker-input" value="#ff0000">
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
                            <input type="color" name="color-title-page3" id="color-title-page3" class="color-picker-input" value="#ff0000">
                            <label for="color-title-page3" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Titre des page</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-text-link3" id="color-text-link3" class="color-picker-input" value="#ff0000">
                            <label for="color-text-link3" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Text liens</span>
                    </div>
                    <div class="color-picker-bg">
                        <div class="color-picker">
                            <input type="color" name="color-back-separator" id="color-back-separator" class="color-picker-input" value="#ff0000">
                            <label for="color-back-separator" class="color-picker-info"></label>
                        </div>
                        <span class="color-picker-bg-text">Séparateur</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</form>
