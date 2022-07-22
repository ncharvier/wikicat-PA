<div class="row">
    <div class="col p-0">
        <section class="main-section">
            <div class="btn-group">
                <a href="/admin/pageTree" class="btn btn--outline-primary">Mode arborescence</a>
                <button class="btn btn--primary">Mode liste</button>
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
                        <td style="text-decoration: underline"><a href="/w/<?=$page->getTitle();?>"><?=$page->getTitle();?></a></td>
                        <td>-</td>
                        <td class="text-italic text-weight-200"><?=$page->versionNumber?></td>
                        <td> 
                        <?php if ($page->getParentPageId()): ?>
                            <a href="/w/<?=$page->getParentPage()->getTitle();?>"><?=$page->getParentPage()->getTitle()?></a>
                        <?php else:?>
                            -
                        <?php endif?>
                        </td>
                        <td><a href="/w/edit/<?=$page->getTitle();?>" class="btn btn--primary">Editer</a></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

