<div class="row">
    <div class="col p-0">
        <section class="main-section">
            <div class="btn-group">
                <button class="btn btn--outline-primary">Mode arborescence</button>
                <button class="btn btn--primary">Mode liste</button>
            </div>
            <div class="form-controller">
                <input class="form-input-back" type="text" placeholder="Recherche">
            </div>
            <table class="table table--hover table--dark">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Nombre de visites</th>
                        <th>Version actuelle</th>
                        <th>Page mère</th>
                        <th>  </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($pageList as $page): ?>
                    <tr class="table-row">
                        <td style="text-decoration: underline"><?=$page->getTitle();?></td>
                        <td>8064</td>
                        <td class="text-italic text-weight-200"><?=$page->versionNumber?></td>
                        <td> 
                        <?php if ($page->getParentPageId()): ?>
                            <?=$page->getParentPage()->getTitle()?>
                        <?php else:?>
                            -
                        <?php endif?>
                        </td>
                        <td><button class="btn btn--primary">Editer</button></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

