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
                    <td><button class="btn btn--primary">Editer</button></td>
                </tr>
                <?php endforeach?>
                </tbody>
            </table>
        </section>
    </div>
</div>

