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
                    <td><?=$user->login?></td>
                    <td><span style="color: #D22D3D;">Admin</span>, <span style="color: #625BC1;">Defaut</span></td>
                    <td class="text-success">
                    <?php
                    switch ($user->status) {
                        case 0:
                            echo "non activer";
                            break;
                        case 1:
                            echo "activer";
                            break;
                        case 2:
                            echo "banni";
                            break;
                    }
                    ?>
                    </td>
                    <td><?=$user->email?></td>
                    <td><button class="btn btn--primary modal-open" data-target="#modal-edit-<?=$user->id?>">Editer</button></td>
                </tr>
                <div id="modal-edit-<?=$user->id?>" class="modal" style="color:#000;">
                    <div class="modal-content modal-content--sm">
                        <div class="modal-header">
                            <span class="modal-close modal-close-cross">&times;</span>
                            <h2>Editer un utilisateur</h2>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="/admin/editUser">
                                <input type="hidden" name="userId" value="<?=$user->id?>">
                                <input type="submit" name="activeUser" class="btn btn--primary d-block" style="width: 100%" value="Activer">
                                <input type="submit" name="banUser" class="btn btn--primary d-block" style="width: 100%" value="Bannir">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-controller">
                                            <input type="password" placeholder="mot de passe" name="newPassword" id="newPassword" class="form-input-back">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <input type="submit" name="resetPassword" class="btn btn--primary d-block" value="Réinitialiser">
                                    </div>
                                </div>
                                <input type="submit" name="deleteUser" class="btn btn--primary d-block" style="width: 100%" value="Supprimer">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn--secondary modal-close" value="Fermer">
                        </div>
                    </div>
                </div>
                <?php endforeach?>
                </tbody>
            </table>
        </section>
    </div>
</div>
