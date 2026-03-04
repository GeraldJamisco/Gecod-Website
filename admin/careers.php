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
                <button type="button" class="btn btn-secondary align-items-right" data-toggle="modal" data-target="#basicModal">Add job insight</button></li>
        </ol>
    </div>
</div>
         <div class="row">
                    <div class="col-12 m-b-30">
                        <h4 class="d-inline">Gecod careers and opportunities</h4>
                        <p class="text-muted">Gecod careeers and opportunities are reviewd here </p>
                        
                <!-- row Modal -->
                    
 
                                    <div class="modal fade" id="basicModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input new Careere/job opportunity details</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="basic-form">
                                                    <!-- page that uploads the jobs to the server -->
                                    <form action="addjob.php" method="POST" enctype="multipart/form-data">
                                         <!-- job title -->
                                         <div class="form-group">
                                            <P class="text-muted">Job Title</P>
                                            <input type="text" class="form-control input-default" placeholder="Job Title" name="jobTitle" required>
                                        </div>
                                         <!-- Job Description -->
                                         <div class="form-group">
                                            <P class="text-muted">Job Description</P>
                                            <textarea name="jobDescript" class="form-control h-150px" rows="8" id="comment" maxlength="100000" placeholder="Please enter Job Description Here, describe it "></textarea>
                                        </div>
                                         <!-- job Position -->
                                         <div class="form-group">
                                            <P class="text-muted">Job Position</P>
                                            <input type="text" class="form-control input-default" placeholder="Job Position" name="jobPosition" required>
                                        </div>
                                         <!-- job Location -->
                                         <div class="form-group">
                                            <P class="text-muted">Job Location</P>
                                            <input type="text" class="form-control input-default" placeholder="Job Location like District or place" name="jobLocation" required>
                                        </div>
                                        <!-- Job Qualifications  -->
                                        <div class="form-group">
                                            <P class="text-muted">Job Qualifications </P>
                                            <textarea name="jobQualific" class="form-control h-150px" rows="8" id="comment" maxlength="100000" placeholder="Please enter Job Qualifications  Here, describe it "></textarea>
                                        </div>
                                        <!-- Job Experience  -->
                                        <div class="form-group">
                                            <P class="text-muted">Job Experience </P>
                                            <textarea name="jobExperie" class="form-control h-150px" rows="8" id="comment" maxlength="100000" placeholder="Please enter Job Experience  Here, describe it "></textarea>
                                        </div>
                                          <!-- Dead Line Date -->
                                          <div class="form-group">
                                            <P class="text-muted">Dead Line Date</P>
                                            <input type="date" class="form-control input-default" placeholder="deadlineDate" name="dld" min="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                          <!-- Hiring Type-->
                                        <div class="form-group">
                                            <P class="text-muted">Hiring Type</P>
                                            <select name="hiringType" class="form-control" required>
                                                <option value=""></option>
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                            </select>
                                        </div>
                                        <!-- Contacts / How to apply  -->
                                        <div class="form-group">
                                            <P class="text-muted">Contacts / How to apply </P>
                                            <textarea name="jobsend" class="form-control h-150px" rows="8" id="comment" maxlength="100000" placeholder="Please enter Contacts / How to apply  Here, describe where the applicant will send there application once filled"></textarea>
                                        </div>
                                       
                                        <!-- Add member Pic -->
                                        <div class="form-group">
                                                                                <label for="validationCustom04" class="form-label">Job pic</label>
                                                        <label for="inputprofile" title="Click on avatar to choose a new banner for this job insight">
                                                <input id="inputprofile" style="display: none; width: 150px;" hidden="hidden" type="file" name="profavatar" accept="image/*" onchange="loadFile(event)" required="required">
                                            <img id="output" src = "../img/job-search.JPG" style = "border-radius: 4px; border: double #263b47 3px; width: 40%; height: 20%; object-fit: cover;">
                                                    <span style = "display: block; font-weight: normal; margin-top: 15px;"> To add a photo to the job insight, click on current avatar to select a photo </span>

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
                                                    <button type="submit" class="btn btn-primary" name="add_new_Job">Save Job</button>
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
                                    <th>Job Title</th>
                                    <th>Job Description</th>
                                    <th>Benef. image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               

                          <?php
                            // getting all Board members
                            $members = $conn->query("SELECT * FROM jobcareer");
                            $x = 1;
                            while ($rows = mysqli_fetch_array($members)) {
                                $orphId = $rows['recordid'];
                                $jobTitle = $rows['job_title'];
                                $jobTitle = $rows['job_title'];
                                $jobDescript = $rows['JobDescription'];
                                $jobBanner = $rows['imgBanner'];

                                echo '
                               
                                    <tr>
                                    <td>'.$x++.'</td>
                                    <td>'.$jobTitle.'</td>
                                    <td>'.$jobDescript.'</td>
                                    <td> <img class="img-fluid" src="../img/job_banner_images/'.$jobBanner.'" alt=""></td>
                                    <td><form action="deletejob.php?jobid='.$orphId.'" method="post">
                                    <input type="submit" value="DELETE" class="btn btn-danger" name="deleteJob">
                                </form></td>

                                </tr>
                                
                              
                                  ';
                            }


                            ?>

</tbody>
                            <tfoot>
                                <tr>
                                <th>#</th>
                                    <th>Job Title</th>
                                    <th>Job Description</th>
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

?>