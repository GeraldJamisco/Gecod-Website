<?php 
include 'config.php';
include 'sessionizr.php';
include 'includes/header.php';
include 'includes/sidebar.php';



?>

<div class="content-body">
    <div class="container-fluid mt-3">
         <!-- End Row -->
                                            <!-- Modal -->
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <button type="button" class="btn btn-secondary align-items-right" data-toggle="modal" data-target="#basicModal">Add Beneficiary</button></li>
        </ol>
    </div>
</div>
         <div class="row">
                    <div class="col-12 m-b-30">
                        <h4 class="d-inline">Gecod Beneficiaries</h4>
                        <p class="text-muted">Gecod Beneficiaries that are viewable on your website</p>
                        
                <!-- row Modal -->
                    
 
                                    <div class="modal fade" id="basicModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input Beneficiary details</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="basic-form">
                                    <form action="addbenefic.php" method="POST" enctype="multipart/form-data">
                                        <!-- Board member Names -->
                                        <div class="form-group">
                                            <P class="text-muted">Names</P>
                                            <input type="text" class="form-control input-default" placeholder="Beneficiary Names" name="benefNames" required>
                                        </div>
                                          <!-- beneficiary  birthday -->
                                          <div class="form-group">
                                            <P class="text-muted">Birthday</P>
                                            <input type="date" class="form-control input-default" placeholder="Beneficiary Birthday" name="dob" max="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                         <!-- beneficiary  gender -->
                                         <div class="form-group">
                                            <P class="text-muted">Gender</P>
                                            <select name="gender" class="form-control" required>
                                                <option value=""></option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <!-- board member title -->
                                        <div class="form-group">
                                            <P class="text-muted">Beneficiary Bio</P>
                                            <textarea name="benefBio" class="form-control h-150px" rows="6" id="comment" maxlength="1000" placeholder="Enter characters that are less than  300 characters"></textarea>
                                        </div>
                                        <!-- Add member Pic -->
                                        <div class="form-group">
                                        <label for="validationCustom04" class="form-label">Beneficiary pic</label>
                <label for="inputprofile" title="Click on avatar to choose a new photo">
        <input id="inputprofile" style="display: none; width: 150px;" hidden="hidden" type="file" name="profavatar" accept="image/*" onchange="loadFile(event)">
      <img id="output" src = "../img/beneficiaries/beneficiary img.jpg" style = "border-radius: 4px; border: double #263b47 3px; width: 40%; height: 20%; object-fit: cover;">
              <span style = "display: block; font-weight: normal; margin-top: 15px;"> To add a photo to the Beneficiary's profile, click on current avatar to select a photo </span>

        <script>
        var loadFile = function(event) {
          var output = document.getElementById('output');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
          }
        };
        </script>
      </label>
                                        </div>
                                        
                                   
                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="add_new_beneficiary">Save Beneficiary</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <div class="container">
                        <div class="row">

                        <div class="col-md-6 col-lg-8">
                                <div class="card">
                                   
                                    <div class="card-body">
                                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Benef. Names</th>
                                    <th>Benef. Gender</th>
                                    <th>Benef. Info</th>
                                    <th>Benef. image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               

                          <?php
                            // getting all Board members
                            $members = $conn->query("SELECT * FROM gecodorphans");
                            $x = 1;
                            while ($rows = mysqli_fetch_array($members)) {
                                $orphId = $rows['orphanid'];
                                $orphnames = $rows['orphanNames'];
                                $orphinfo = $rows['orphanInfo'];
                                $orphimg = $rows['orphanImage'];
                                $orphangender = $rows['orphanGender'];

                  
                                $safeNames  = htmlspecialchars($orphnames, ENT_QUOTES);
                                $safeGender = htmlspecialchars($orphangender, ENT_QUOTES);
                                $safeInfo   = htmlspecialchars($orphinfo, ENT_QUOTES);
                                $safeDob    = htmlspecialchars($rows['orphanBirthday'] ?? '', ENT_QUOTES);

                                echo '
                                    <tr>
                                    <td>'.$x++.'</td>
                                    <td>'.$safeNames.'</td>
                                    <td>'.$safeGender.'</td>
                                    <td>'.mb_substr($safeInfo, 0, 80).'...</td>
                                    <td><img class="img-fluid" style="max-width:60px;" src="../img/beneficiaries/'.$orphimg.'" alt=""></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm mr-1"
                                            data-toggle="modal" data-target="#editBenefModal"
                                            data-id="'.$orphId.'"
                                            data-names="'.$safeNames.'"
                                            data-dob="'.$safeDob.'"
                                            data-gender="'.$safeGender.'"
                                            data-bio="'.$safeInfo.'"
                                            onclick="fillEditBenef(this)">EDIT</button>
                                        <form style="display:inline" action="deleteorphan.php?orphanid='.$orphId.'" method="post"
                                              onsubmit="return confirm(\'Delete this beneficiary? This cannot be undone.\')">
                                            <input type="submit" value="DELETE" class="btn btn-danger btn-sm" name="deleteorphan">
                                        </form>
                                    </td>
                                    </tr>';
                            }


                            ?>

</tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Benef. Names</th>
                                    <th>Benef. Gender</th>
                                    <th>Benef. Info</th>
                                    <th>Benef. image</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                       

   
</div>
<!-- #/ container -->
</div>













































<!-- Edit Beneficiary Modal -->
<div class="modal fade" id="editBenefModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Beneficiary</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="updatebenefic.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="orphanid" id="editBenefId">
                    <div class="form-group"><label>Names</label>
                        <input type="text" class="form-control" name="benefNames" id="editBenefNames" required></div>
                    <div class="form-group"><label>Birthday</label>
                        <input type="date" class="form-control" name="dob" id="editBenefDob"></div>
                    <div class="form-group"><label>Gender</label>
                        <select name="gender" class="form-control" id="editBenefGender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select></div>
                    <div class="form-group"><label>Bio</label>
                        <textarea name="benefBio" class="form-control" rows="4" id="editBenefBio"></textarea></div>
                    <div class="form-group"><label>New Photo (optional &mdash; leave blank to keep current)</label>
                        <input type="file" class="form-control-file" name="profavatar" accept="image/*"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="update_beneficiary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function fillEditBenef(btn) {
    document.getElementById(' + chr(39) + 'editBenefId' + chr(39) + ').value     = btn.dataset.id;
    document.getElementById(' + chr(39) + 'editBenefNames' + chr(39) + ').value  = btn.dataset.names;
    document.getElementById(' + chr(39) + 'editBenefDob' + chr(39) + ').value    = btn.dataset.dob;
    document.getElementById(' + chr(39) + 'editBenefGender' + chr(39) + ').value = btn.dataset.gender;
    document.getElementById(' + chr(39) + 'editBenefBio' + chr(39) + ').value    = btn.dataset.bio;
}
</script>

<?php

include 'includes/footer.php';