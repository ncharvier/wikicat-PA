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
        echo "supprimer";
        break;
}
?>
                    </td>
                    <td><?=$user->email?></td>
                    <td><button class="btn btn--primary modal-open" data-target="#modal-edit">Editer</button></td>
                </tr>
                <?php endforeach?>
                </tbody>
            </table>
        </section>
    </div>
</div>
<div id="modal-edit" class="modal" style="color:#000;">
    <div class="modal-content modal-content--sm">
        <div class="modal-header">
            <span class="modal-close modal-close-cross">&times;</span>
            <h2>modal de test</h2>
        </div>
        <div class="modal-body">
            TODO : ban, reset, force confirm email, delete
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn--secondary modal-close" value="Fermer">
        </div>
    </div>
</div>
