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
                <button type="button" class="btn btn-secondary align-items-right" data-toggle="modal" data-target="#basicModal">Add Partner</button></li>
        </ol>
    </div>
</div>
         <div class="row">
                    <div class="col-12 m-b-30">
                        <h4 class="d-inline">Gecod Partners</h4>
                        <p class="text-muted">Gecod Partners that are viewable on your website</p>
                        
                <!-- row Modal -->
                    
 
                                    <div class="modal fade" id="basicModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input Partner logo</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="basic-form">
                                    <form action="addpartner.php" method="POST" enctype="multipart/form-data">
                                        <!-- Add member Pic -->
                                        <div class="form-group">
                                            <P class="text-muted">Names</P>
                                            <input type="text" class="form-control input-default" placeholder="Partner Names" name="partnernames">
                                        </div>
                                        <div class="form-group">
                                        <label for="validationCustom04" class="form-label">partner Logo</label>
                <label for="inputprofile" title="Click on avatar to choose a new photo">
        <input id="inputprofile" style="display: none; width: 150px;" hidden="hidden" type="file" name="partnerlogo" accept="image/*" onchange="loadFile(event)">
      <img id="output" src = "../img/beneficiaries/beneficiary img.jpg" style = "border-radius: 4px; border: double #263b47 3px; width: 40%; height: 20%; object-fit: cover;">
              <span style = "display: block; font-weight: normal; margin-top: 15px;"> To add partner's logo, please click on the image above </span>

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
                                                    <button type="submit" class="btn btn-primary" name="add_new_partner">Save Partner</button>
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
                                    <th>Partner Names</th>
                                    <th>Partner Logo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               

                          <?php
                            // getting all Board members
                            $partners = $conn->query("SELECT * FROM gecodpartners");
                            $x = 1;
                            while ($rows = mysqli_fetch_array($partners)) {
                                $partnerNames = $rows['partnernames'];
                                $partnerlogo = $rows['partnerlogo'];
                                $deleteid = $rows['recordid'];

                                echo '
                               
                                    <tr>
                                    <td>'.$x++.'</td>
                                    <td>'.$partnerNames.'</td>
                                    <td> <img class="img-fluid" src="../img/sponsors/'.$partnerlogo.'" alt=""></td>
                                    <td><form action="deletepartner.php?partnerid='.$deleteid.'" method="post">
                                    <input type="submit" value="DELETE" class="btn btn-danger" name="deletepartner">
                                </form></td>

                                </tr>
                                
                              
                                  ';
                            }


                            ?>

</tbody>
                            <tfoot>
                            <tr>
                                    <th>#</th>
                                    <th>Partner Names</th>
                                    <th>Partner Logo</th>
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
?>