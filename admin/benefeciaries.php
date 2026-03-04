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

                                echo '
                               
                                    <tr>
                                    <td>'.$x++.'</td>
                                    <td>'.$orphnames.'</td>
                                    <td>'.$orphangender.'</td>
                                    <td>'.$orphinfo.'</td>
                                    <td> <img class="img-fluid" src="../img/beneficiaries/'.$orphimg.'" alt=""></td>
                                    <td><form action="deleteorphan.php?orphanid='.$orphId.'" method="post">
                                    <input type="submit" value="DELETE" class="btn btn-danger" name="deleteorphan">
                                </form></td>

                                </tr>
                                
                              
                                  ';
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













































<?php

include 'includes/footer.php';