<div class="row">
    <div class="col p-0">
        <section class="main-section">
            <div class="btn-group">
                <button class="btn btn--primary">Mode arborescence</button>
                <a href="/back/pageList" class="btn btn--outline-primary">Mode liste</a>
            </div>
            <section id="pageTree"></section>
            <script>
                $( document ).ready(function (){
                    $.ajax({
                        url: "/tree/getPageTree",
                        success: function (tree){
                            $("#pageTree").html(tree);
                        }
                    });
                });
            </script>
        </section>
    </div>
</div>


