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

                                $safeNames = htmlspecialchars($partnerNames, ENT_QUOTES);
                                echo '
                                    <tr>
                                    <td>'.$x++.'</td>
                                    <td>'.$safeNames.'</td>
                                    <td><img class="img-fluid" style="max-width:80px;" src="../img/sponsors/'.$partnerlogo.'" alt=""></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm mr-1"
                                            data-toggle="modal" data-target="#editPartnerModal"
                                            data-id="'.$deleteid.'"
                                            data-names="'.$safeNames.'"
                                            onclick="fillEditPartner(this)">EDIT</button>
                                        <form style="display:inline" action="deletepartner.php?partnerid='.$deleteid.'" method="post"
                                              onsubmit="return confirm(\'Delete this partner? This cannot be undone.\')">
                                            <input type="submit" value="DELETE" class="btn btn-danger btn-sm" name="deletepartner">
                                        </form>
                                    </td>
                                    </tr>';
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















































<!-- Edit Partner Modal -->
<div class="modal fade" id="editPartnerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Partner</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="updatepartner.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="record_id" id="editPartnerId">
                    <div class="form-group"><label>Partner Name</label>
                        <input type="text" class="form-control" name="partnernames" id="editPartnerNames" required></div>
                    <div class="form-group"><label>New Logo (optional)</label>
                        <input type="file" class="form-control-file" name="partnerlogo" accept="image/*"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="update_partner">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function fillEditPartner(btn) {
    document.getElementById('editPartnerId').value    = btn.dataset.id;
    document.getElementById('editPartnerNames').value = btn.dataset.names;
}
</script>
<?php
include 'includes/footer.php';
?>