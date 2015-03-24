<div class="modal fade bs-edit-profile-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-4 upload-photo">
                            <form method="post" action="edit_data.php" enctype="multipart/form-data">
                                <div class="input-group">
                                    <img src="img/profile/<?php 
                                            $file = "img/profile/".$patient_id.".jpg";
                                            if(file_exists($file)){
                                                echo $patient_id;
                                            }else{
                                                echo 'profile_patient';
                                            } ?>.jpg" class="img-responsive">
                                        
                                    <input type="file" class="file-upload" name="profile_pic">
                                    <input type="hidden" value="<?php echo $patient_id?>" name="patient_id">
                                    <input type="submit" class="btn btn-default upload-btn btn-noborder" class="btn btn-default login-btn btn-noborder"  value="Save" name="submit">
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-12 col-md-5 col-md-offset-2 profile-data-edit">
                            <h1 class="text-center row-header">Edit Data</h1>
                            <form method='post' action="edit_this.php">
                                <div class="input-group">
                                        <input type="text" class="form-control" name="name" placeholder="Name" required="" value="<?php echo $patient_n?>"/>
                                        <input type="text" class="form-control" name="contact" placeholder="Contact Number" required="" value="<?php echo $row['patient_contact']?>" />
                                        <input type="text" class="form-control" name="occupation" placeholder="Occupation" required="" value="<?php echo $row['occupation']?>" />
                                        <input type="hidden" value="<?php echo $patient_id ?>" name="patient_id">
                                        <input class="btn btn-default login-btn btn-noborder" type="submit" value="Submit" name="submit"/>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <?php
                        echo '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
                    ?>
                </div>

        </div>
    </div>
</div> <!-- /modal -->