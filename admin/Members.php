<?php 
include 'config.php';
include 'sessionizr.php';
include 'includes/header.php';
include 'includes/sidebar.php';



?>

<div class="content-body">
    <div class="container-fluid mt-3">
         <!-- End Row -->
         <div class="row">
                    <div class="col-12 m-b-30">
                        <h4 class="d-inline">Gecod Team Members</h4>
                        <p class="text-muted">Gecod Team Members that are viewable on your website</p>
                        
                <!-- row Modal -->
                    
                                    <button type="button" class="btn btn-primary align-items-right" data-toggle="modal" data-target="#basicModal">Add Staff or Board member</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="basicModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input New Board Member</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="basic-form">
                                    <form action="addbdmember.php" method="POST" enctype="multipart/form-data">
                                        <!-- Board member Names -->
                                        <div class="form-group">
                                            <P class="text-muted">Names</P>
                                            <input type="text" class="form-control input-default" placeholder="Board Member Names" name="bdNames">
                                        </div>
                                        <!-- board member title -->
                                        <div class="form-group">
                                            <P class="text-muted">Board Member Title</P>
                                            <input type="text" class="form-control input-default" placeholder="Board Member Title" name="bdTitle">
                                        </div>
                                        <!-- twitter link -->
                                        <div class="form-group">
                                            <P class="text-muted">twitter Link</P>
                                            <input type="text" class="form-control input-default" placeholder="Input Twitter Link for Board Member" name="bdtwtlink">
                                        </div>
                                        <!-- whatsapp link -->
                                        <div class="form-group">
                                            <P class="text-muted">Whatsapp Link for Board Member</P>
                                            <input type="text" class="form-control input-default" placeholder="Input Whatsapp Link for Board Member" name="bdwsplink">
                                        </div>
                                        <!-- facebook link -->
                                        <div class="form-group">
                                            <P class="text-muted">facebook Link for Board Member</P>
                                            <input type="text" class="form-control input-default" placeholder="Input facebook page Link for Board Member" name="bdfblink">
                                        </div>
                                        <!-- Add member Pic -->
                                        <div class="form-group">
                                        <label for="validationCustom04" class="form-label">Teacher pic</label>
                <label for="inputprofile" title="Click on avatar to choose a new photo">
        <input id="inputprofile" style="display: none; width: 150px;" hidden="hidden" type="file" name="profavatar" accept="image/*" onchange="loadFile(event)">
      <img id="output" src = "../img/CEOGecod - Copy.png" style = "border-radius: 4px; border: double #263b47 3px; width: 40%; height: 20%; object-fit: cover;">
              <span style = "display: block; font-weight: normal; margin-top: 15px;"> To add a photo to the board Member's profile, click on current avatar to select a photo </span>

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
                                                    <button type="submit" class="btn btn-primary" name="add_new_member">Save Board   Member</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <div class="container-fluid">
                        <div class="row">

                          <?php
                            // getting all Board members
                            $members = $conn->query("SELECT * FROM teammembers");
                            
                            while ($rows = mysqli_fetch_array($members)) {
                                $bodnames = $rows['Names'];
                                $bodtitle = $rows['Title'];
                                $bodtwit = $rows['Twitter'];
                                $bodfb = $rows['Facebook'];
                                $bodwasap = $rows['Whatsapp'];
                                $bodimg = $rows['image'];

                                echo '
                                <div class="col-md-6 col-lg-3">
                                <div class="card">
                                    <img class="img-fluid" src="../img/'.$bodimg.'" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$bodnames.'</h5>
                                        <h6>'.$bodtitle.'</h6>
                                        <div class="card-footer border-0 bg-transparent">
                                <div class="row">
                                    <div class="col-4 border-right-1 pt-3">
                                        <a class="text-center d-block text-muted" target="_blank" rel="noopener noreferrer" href="https://'.$bodtwit.'">
                                            <i class="fa fa-twitter gradient-1-text" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-4 border-right-1 pt-3"><a class="text-center d-block text-muted" target="_blank" rel="noopener noreferrer" href="https://'.$bodfb.'">
                                        <i class="fa fa-facebook gradient-3-text"></i>
                                        </a>
                                    </div>
                                    <div class="col-4 pt-3"><a class="text-center d-block text-muted" target="_blank" rel="noopener noreferrer" href="https://'.$bodwasap.'">
                                        <i class="fa fa-whatsapp gradient-4-text"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Col -->';
                            }


                            ?>
                           <!-- End col -->
                        </div>
                    </div>
                </div>
                <!-- End Row -->
    </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

















































<?php

include 'includes/footer.php';