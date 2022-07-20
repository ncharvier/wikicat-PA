<div class="row">
    <div class="col p-0">
        <section class="main-section">
            <div class="form-controller">
                <input class="form-input-back" type="text" placeholder="Recherche">
            </div>
            <div class="btn btn--primary d-block">
                Ajouter un rôle
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
                        <td><?php var_dump($role);  ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-row">
                    <td style="color: #D22D3D;">Admin</td>
                    <td class="text-danger text-weight-700">3</td>
                    <td>2</td>
                    <td><button class="btn btn--primary">Editer</button></td>
                </tr>
                <tr class="table-row">
                    <td style="color: #FA8654;">Modérateur</td>
                    <td class="text-warning text-weight-700">2</td>
                    <td>9</td>
                    <td><button class="btn btn--primary">Editer</button></td>
                </tr>
                <tr class="table-row">
                    <td style="color: #2E8B77;">Editeur</td>
                    <td class="text-warning text-weight-700">2</td>
                    <td>15</td>
                    <td><button class="btn btn--primary">Editer</button></td>
                </tr>
                <tr class="table-row">
                    <td style="color: #625BC1;">Default</td>
                    <td class="text-success text-weight-700">1</td>
                    <td>114</td>
                    <td><button class="btn btn--primary">Editer</button></td>
                </tr>
                </tbody>
            </table>

        </section>
    </div>
</div>

