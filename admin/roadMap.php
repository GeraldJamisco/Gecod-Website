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
                    <div class="col-11 m-b-30">
                        <h4 class="d-inline">Gecod Initiative Road Map</h4>
                        <p class="text-muted">This is Gecod's Road map and what the initiave have been doing almost every month</p>
                        
                <!-- row Modal -->
                    
                                    <button type="button" class="btn btn-primary align-items-right" data-toggle="modal" data-target="#basicModal">New Update Road Map</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="basicModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input Road Map</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="basic-form">
                                    <form action="newroadmap.php" method="POST" enctype="multipart/form-data">
                                        <!-- Board member Names -->
                                        <div class="form-group">
                                            <P class="text-muted">Form a Title for the road Map Thta your Uploading </P>
                                            <input type="text" class="form-control input-default" placeholder="Form a Title for the road Map That your Uploading " name="roadmaptitle">
                                        </div>
                                        <!-- road map content -->
                                        <div class="form-group">
                                            <P class="text-muted">Select the best Content to put on the road Map that is going to appear on the site make sure its best for the initiative</P>
                                            <textarea name="content" class="form-control h-150px" rows="6" id="comment" maxlength="450" placeholder="Enter characters that are less than  450 characters"></textarea>
                                        </div>
                                        
                                        <!-- Add member Pic -->
                                        <div class="form-group">
                                        <label for="validationCustom04" class="form-label">Teacher pic</label>
                <label for="inputprofile" title="Click on avatar to choose a new photo">
        <input id="inputprofile" style="display: none; width: 150px;" hidden="hidden" type="file" name="profavatar" accept="image/*" onchange="loadFile(event)">
      <img id="output" src = "../img/carousel-1.jpg" style = "border-radius: 4px; border: double #263b47 3px; width: 40%; height: 20%; object-fit: cover;">
              <span style = "display: block; font-weight: normal; margin-top: 15px;"> To add a photo to the Organisation/initiative's road map, click on current image to select a photo </span>

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
                                                    <button type="submit" class="btn btn-primary" name="add_new_roadmap">Save And send to the website</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <div class="container-fluid">
                        <div class="row">

                          <?php
                            // getting all Board members
                            $members = $conn->query("SELECT * FROM gecodroadmap");
                            
                            while ($rows = mysqli_fetch_array($members)) {
                                $rdTitle = $rows['Title'];
                                $rdContent = $rows['content'];
                                $rdimg = $rows['image'];
                                $deleteid = $rows['recordid'];

                                $safeTitle   = htmlspecialchars($rdTitle, ENT_QUOTES);
                                $safeContent = htmlspecialchars($rdContent, ENT_QUOTES);
                                echo '
                                <div class="col-md-6 col-lg-6">
                                <div class="card">
                                    <img class="img-fluid" src="../img/'.$rdimg.'" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$safeTitle.'</h5>
                                        <p>'.substr($safeContent, 0, 120).'...</p>
                                        <button type="button" class="btn btn-warning btn-sm mr-1 mb-1"
                                            data-toggle="modal" data-target="#editRoadmapModal"
                                            data-id="'.$deleteid.'"
                                            data-title="'.$safeTitle.'"
                                            data-content="'.$safeContent.'"
                                            onclick="fillEditRoadmap(this)">EDIT</button>
                                        <form style="display:inline" action="deleteroadmap.php?deleteid='.$deleteid.'" method="post"
                                              onsubmit="return confirm(\'Delete this post? This cannot be undone.\')">
                                            <button type="submit" class="btn btn-outline-danger btn-sm mb-1">DELETE</button>
                                        </form>
                                    </div>
                                </div>
                            </div>';
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















































<!-- Edit Road Map Modal -->
<div class="modal fade" id="editRoadmapModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Road Map Post</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="updateroadmap.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="record_id" id="editRmId">
                    <div class="form-group"><label>Title</label>
                        <input type="text" class="form-control" name="rdtitle" id="editRmTitle" required></div>
                    <div class="form-group"><label>Content</label>
                        <textarea name="rdcontent" class="form-control" rows="6" id="editRmContent"></textarea></div>
                    <div class="form-group"><label>New Image (optional — leave blank to keep current)</label>
                        <input type="file" class="form-control-file" name="profavatar" accept="image/*"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="update_roadmap">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function fillEditRoadmap(btn) {
    document.getElementById('editRmId').value      = btn.dataset.id;
    document.getElementById('editRmTitle').value   = btn.dataset.title;
    document.getElementById('editRmContent').value = btn.dataset.content;
}
</script>

<?php
include 'includes/footer.php';