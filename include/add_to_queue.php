<div class="modal fade bs-walk-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form class="form-input"  method="post" action="walk.php">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Patient</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 add-walkin-form">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="First name" name="firstname">
                                <input type="text" class="form-control" placeholder="Last name" name="lastname">
                                <input type="hidden" value="" name="doctor_id" id="doc_id"> 
                                <input type="hidden" value="" name="clinic_id" id="cli_id"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                    echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                    echo "<button type=\"submit\" class=\"btn btn-primary\" name=\"submit\">Save</button>";
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>