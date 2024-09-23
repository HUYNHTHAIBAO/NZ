<div id="map-modal" class="modal  fade bd-example-modal-lg" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vị trí map</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div id="map"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btn-goole-map" data-dismiss="modal">Xem trên google map</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>

    .modal-body {
        margin-top: 20px;
        height: 400px;

    }
    #map {
        width: 100%;
        height: 100%;

    }



</style>
