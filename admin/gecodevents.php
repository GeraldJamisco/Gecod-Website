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
                        <button type="button" class="btn btn-secondary align-items-right" data-toggle="modal"
                            data-target="#eventModal">Add Event</button>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12 m-b-30">
                <h4 class="d-inline">Gecod Events</h4>
                <p class="text-muted">Gecod events that are viewable on your website</p>

                <!-- row Modal -->
                <div class="modal fade" id="eventModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Enter event Abouts</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="basic-form">
                                    <form action="addEvent.php" method="POST" enctype="multipart/form-data">
                                        <!-- Add event title -->
                                        <div class="form-group">
                                            <P class="text-muted">Event Title</P>
                                            <input type="text" class="form-control input-default"
                                                placeholder="Event Title" name="title">
                                        </div>
                                        <!-- Add event About -->
                                        <div class="form-group">
                                            <P class="text-muted">Event About</P>
                                            <textarea name="about" class="form-control h-150px" rows="5" id="comment"
                                                maxlength="300"
                                                placeholder="Enter characters that are less than  200 characters"></textarea>
                                        </div>
                                        <!-- Add event date -->
                                        <div class="form-group">
                                            <P class="text-muted">Event date</P>
                                            <input type="date" class="form-control input-default"
                                                placeholder="Event date" name="datec"
                                                min="<?php echo date("Y-m-d");  ?>">
                                        </div>
                                        <!-- Add event time start -->
                                        <div class="form-group">
                                            <P class="text-muted">Event time start</P>
                                            <input type="time" class="form-control input-default"
                                                placeholder="Event time start" name="timestart">
                                        </div>
                                        <!-- Add event time end -->
                                        <div class="form-group">
                                            <P class="text-muted">Event time end</P>
                                            <input type="time" class="form-control input-default"
                                                placeholder="Event time end" name="timeend">
                                        </div>
                                        <!-- Add event Location District -->
                                        <div class="form-group">
                                            <P class="text-muted">Event Location District</P>
                                            <input type="text" class="form-control input-default"
                                                placeholder="Event Location District" name="location" maxlength="15">
                                        </div>
                                        <div class="form-group">
                                            <label for="validationCustom04" class="form-label">Event Logo</label>
                                            <label for="inputprofile" title="Click on avatar to choose a new photo">
                                                <input id="inputprofile" style="display: none; width: 150px;"
                                                    hidden="hidden" type="file" name="eventBanner" accept="image/*"
                                                    onchange="loadFile(event)">
                                                <img id="output" src="../img/beneficiaries/beneficiary img.jpg"
                                                    style="border-radius: 4px; border: double #263b47 3px; width: 40%; height: 20%; object-fit: cover;">
                                                <span style="display: block; font-weight: normal; margin-top: 15px;"> To
                                                    add event's banner, please click on the image above </span>

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
                                <button type="submit" class="btn btn-primary" name="add_new_event">Save
                                    Event</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">

                        <div class="col-md-6 col-lg-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Event Title</th>
                                                    <th>Event About</th>
                                                    <th>Event Date</th>
                                                    <th>Time Start</th>
                                                    <th>Time End</th>
                                                    <th>Location</th>
                                                    <th>Event Banner</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php
                            // getting all Board members
                            $partners = $conn->query("SELECT * FROM gecodevents");
                            $x = 1;
                            while ($rows = mysqli_fetch_array($partners)) {
                                $deleteid = $rows['recordid'];
                                $eventTitle = $rows['eventTitle'];
                                $eventAbout = $rows['eventInfo'];
                                $eventdate = $rows['eventDate'];
                                $eventtimeStart = $rows['eventTimeStart'];
                                $eventtimeend = $rows['eventTimeEnd'];
                                $eventlocation = $rows['eventLocation'];
                                $eventimage = $rows['eventImageLogo'];

                                $safeTitle    = htmlspecialchars($eventTitle, ENT_QUOTES);
                                $safeAbout    = htmlspecialchars($eventAbout, ENT_QUOTES);
                                $safeLocation = htmlspecialchars($eventlocation, ENT_QUOTES);
                                echo '
                                    <tr>
                                    <td>'.$x++.'</td>
                                    <td>'.$safeTitle.'</td>
                                    <td>'.substr($safeAbout,0,60).'...</td>
                                    <td>'.$eventdate.'</td>
                                    <td>'.$eventtimeStart.'</td>
                                    <td>'.$eventtimeend.'</td>
                                    <td>'.$safeLocation.'</td>
                                    <td><img class="img-fluid" style="max-width:60px;" src="../img/events/'.$eventimage.'" alt=""></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm mr-1"
                                            data-toggle="modal" data-target="#editEventModal"
                                            data-id="'.$deleteid.'"
                                            data-title="'.$safeTitle.'"
                                            data-about="'.$safeAbout.'"
                                            data-date="'.$eventdate.'"
                                            data-tstart="'.$eventtimeStart.'"
                                            data-tend="'.$eventtimeend.'"
                                            data-location="'.$safeLocation.'"
                                            onclick="fillEditEvent(this)">EDIT</button>
                                        <form style="display:inline" action="deleteevent.php?eventid='.$deleteid.'" method="post"
                                              onsubmit="return confirm(\'Delete this event? This cannot be undone.\')">
                                            <input type="submit" value="DELETE" class="btn btn-danger btn-sm" name="deleteevent">
                                        </form>
                                    </td>
                                    </tr>';
                            }


                            ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Event Title</th>
                                                    <th>Event About</th>
                                                    <th>Event Date</th>
                                                    <th>Time Start</th>
                                                    <th>Time End</th>
                                                    <th>Location</th>
                                                    <th>Event Banner</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>



                                </div>
                                <!-- #/ container -->
                            </div>















































<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Event</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="updateevent.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="record_id" id="editEvId">
                    <div class="form-group"><label>Title</label>
                        <input type="text" class="form-control" name="title" id="editEvTitle" required></div>
                    <div class="form-group"><label>About</label>
                        <textarea name="about" class="form-control" rows="3" id="editEvAbout"></textarea></div>
                    <div class="form-group"><label>Date</label>
                        <input type="date" class="form-control" name="datec" id="editEvDate"></div>
                    <div class="row">
                        <div class="col-6 form-group"><label>Time Start</label>
                            <input type="time" class="form-control" name="timestart" id="editEvTstart"></div>
                        <div class="col-6 form-group"><label>Time End</label>
                            <input type="time" class="form-control" name="timeend" id="editEvTend"></div>
                    </div>
                    <div class="form-group"><label>Location District</label>
                        <input type="text" class="form-control" name="location" id="editEvLocation" maxlength="15"></div>
                    <div class="form-group"><label>New Banner (optional)</label>
                        <input type="file" class="form-control-file" name="eventBanner" accept="image/*"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="update_event">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function fillEditEvent(btn) {
    document.getElementById('editEvId').value       = btn.dataset.id;
    document.getElementById('editEvTitle').value    = btn.dataset.title;
    document.getElementById('editEvAbout').value    = btn.dataset.about;
    document.getElementById('editEvDate').value     = btn.dataset.date;
    document.getElementById('editEvTstart').value   = btn.dataset.tstart;
    document.getElementById('editEvTend').value     = btn.dataset.tend;
    document.getElementById('editEvLocation').value = btn.dataset.location;
}
</script>
                            <?php
include 'includes/footer.php';
?>