<!-- Modal -->
<div id="{{$modal_id}}" class="modal fade" role="dialog">
     <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title mod_title"></h4>
            </div>
            <div class="modal-body">
                <!-- <p class="danger text-center">Error apa gitu</p> -->
           		@include($modal_content)
            </div>
        </div>
    </div>
</div>