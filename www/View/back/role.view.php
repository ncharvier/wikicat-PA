<div class="row">
    <div class="col p-0">
        <section class="main-section">
            <div class="form-controller">
                <input class="form-input-back" type="text" placeholder="Recherche">
            </div>
            <button class="btn btn--primary modal-open" data-target="#newRole">Nouveau Role</button>
            <div id="newRole" class="modal">
                <div class="modal-content modal-content-dark">
                    <div class="modal-header modal-header-dark">
                        <span class="modal-close modal-close-cross">&times;</span>
                        <h2>Création de rôle</h2>
                    </div>
                    <div class="modal-body modal-body-dark">
                        <?php $this->includePartial("form", $role->getFormCreateRole()) ?>
                    </div>
                </div>
            </div>
            <table class="table table--hover table--dark">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Couleur</th>
                    <th>Ajout de page</th>
                    <th>Modification de page</th>
                    <th>Suppression de page</th>
                    <th>Ajout de commentaires</th>
                    <th>Droits Admin</th>
                    <!--<th>Membres</th>-->
                </tr>
                </thead>
                <tbody>
                <?php foreach($roleList as $role): ?>
                    <tr class="table-row">
                        <td style="color: #<?= $role->getColour();?>">   <?= $role->getName();  ?></td>
                        <td style="color: #<?= $role->getColour();?>">   #<?= $role->getColour();  ?></td>
                        <td><?= $role->getCreatePage() ? "Oui" : "Non" ?></td>
                        <td><?= $role->getModifyPage() ? "Oui" : "Non" ?></td>
                        <td><?= $role->getDeletePage() ? "Oui" : "Non" ?></td>
                        <td><?= $role->getAddComment() ? "Oui" : "Non" ?></td>
                        <td><?= $role->getAdminRights() ? "Oui" : "Non" ?></td>
                        <td><button class="btn btn--primary modal-open" data-target="#infoRoles-<?= $role->getId() ?>">Editer</button></td>
                        <div id="infoRoles-<?= $role->getId() ?>" class="modal">
                            <div class="modal-content modal-content-dark">
                                <div class="modal-header modal-header-dark">
                                    <span class="modal-close modal-close-cross">&times;</span>
                                    <h2>Modifier le rôle : <?= $role->getName(); ?></h2>
                                </div>
                                <div class="modal-body modal-body-dark">
                                    <?php $this->includePartial("form", $role->getFormUpdateRole()) ?>
                                    <?php $this->includePartial("form", $role->getDeleteRole()) ?>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>



