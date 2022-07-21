<div class="row">
    <div class="col-12 col-lg-6 p-0">
        <section class="main-section">
            <section>
                <h2>Statistiques utilisateur :</h2>
                <div class="row">
                    <div class="col-6 my-1 d-flex align-items-center">
                        <i class="fas fa-user-friends fa-2x"></i>
                        <div class="badge badge--pill badge--success ml-3"> + <?=$nbUser?></div>
                    </div>
                    <div class="col-6 my-1 d-flex align-items-center">
                        <i class="fas fa-user-plus fa-2x"></i>
                        <div class="badge badge--pill badge--success ml-3"> + <?=$nbCreatedUser?></div>
                    </div>
                    <div class="col-6 my-1 d-flex align-items-center">
                        <i class="fas fa-comment fa-2x"></i>
                        <div class="badge badge--pill badge--warning ml-3"> + 6</div>
                    </div>
                    <div class="col-6 my-1 d-flex align-items-center">
                        <i class="fas fa-comment-slash fa-2x"></i>
                        <div class="badge badge--pill badge--danger ml-3"> + 63</div>
                    </div>
                </div>
            </section>
            <hr>
            <section>
                <h2>Historique des visites :</h2>
                <canvas class="my-2" id="dashboardChart" width="400" height="200"></canvas>
            </section>
        </section>
    </div>
    <div class="col-12 col-lg-6 p-0">
        <section class="main-section">
            <h2>État du serveur :</h2>
            <section class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-space-between align-items-center">
                        <i class="fas fa-hdd fa-2x"></i>
                        <div class="d-flex flex-col" style="width: 90%">
                            <span>Stockage</span>
                            <div class="progress">
                                <div class="progress-bar progress--degradee-success" style="width: 21%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-space-between align-items-center">
                        <i class="fas fa-microchip fa-2x"></i>
                        <div class="d-flex flex-col" style="width: 90%">
                            <span>CPU</span>
                            <div class="progress">
                                <div class="progress-bar progress--degradee-danger" style="width: 98%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-space-between align-items-center">
                        <i class="fas fa-memory fa-2x"></i>
                        <div class="d-flex flex-col" style="width: 90%">
                            <span>RAM</span>
                            <div class="progress">
                                <div class="progress-bar progress--degradee-warning" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    Fluidité du site :
                </div>
            </section>
        </section>
        <section class="main-section">
            <div class="row">
                <div class="col-6">
                    <h2>Nouvelles Pages</h2>
                    <span><?=$nbCreatedPage?></span>
                </div>
                <div class="col-6">
                    <h2>Total Pages</h2>
                    <span><?=$nbPage?></span>
                </div>
                <div class="col-6">
                    <h2>Pages supprimé</h2>
                </div>
                <div class="col-6">
                    <h2>Pages mise à jour</h2>
                </div>
            </div>
        </section>
    </div>
</div>


