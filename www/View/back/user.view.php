<div class="row">
    <div class="col p-0">
        <section class="main-section">
            <table class="table table--hover table--dark">
                <thead>
                <tr>
                    <th>Pseudo </th>
                    <th>Rôles</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($userList as $user):?>
                <tr class="table-row">
                    <td><?=$user->getLogin()?></td>
                    <td><span style="color: #D22D3D;">Admin</span>, <span style="color: #625BC1;">Defaut</span></td>
                    <?php
                    switch ($user->getStatus()) {
                        case 0:
                            echo '<td class="text-warning">non activer</td>';
                            break;
                        case 1:
                            echo '<td class="text-success">activer</td>';
                            break;
                        case 2:
                            echo '<td class="text-danger">banni</td>';
                            break;
                    }
                    ?>
                    <td><?=$user->getEmail()?></td>
                    <td><button class="btn btn--primary modal-open" data-target="#modal-edit-<?=$user->getId()?>">Editer</button></td>
                </tr>
                <div id="modal-edit-<?=$user->getId()?>" class="modal">
                    <div class="modal-content modal-content--sm modal-content-dark">
                        <div class="modal-header modal-header-dark">
                            <span class="modal-close modal-close-cross">&times;</span>
                            <h2>Editer un utilisateur</h2>
                        </div>
                        <div class="modal-body modal-body-dark">
                            <?php $this->includePartial("form", $user->formAdminActiveUser()) ?>
                            <?php $this->includePartial("form", $user->formAdminBanUser()) ?>
                            <?php $this->includePartial("form", $user->formAdminResetPasswordUser()) ?>
                            <?php $this->includePartial("form", $user->formAdminDeleteUser()) ?>
                        </div>
                        <div class="modal-footer modal-footer-dark">
                            <button class="btn btn--secondary modal-close">Fermer</button>
                        </div>
                    </div>
                </div>
                <?php endforeach?>
                </tbody>
            </table>
        </section>
    </div>
</div>
