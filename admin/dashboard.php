<?php
include 'config.php';
include 'sessionizr.php';

mysqli_report(MYSQLI_REPORT_OFF);

$cntMembers  = $conn->query("SELECT COUNT(*) AS c FROM teammembers")->fetch_assoc()['c'];
$cntBenef    = $conn->query("SELECT COUNT(*) AS c FROM gecodorphans")->fetch_assoc()['c'];
$cntRoadmap  = $conn->query("SELECT COUNT(*) AS c FROM gecodroadmap")->fetch_assoc()['c'];
$cntEvents   = $conn->query("SELECT COUNT(*) AS c FROM gecodevents")->fetch_assoc()['c'];

// Visitor stats
$visToday  = 0; $visWeek = 0; $visMonth = 0; $visUnique = 0;
$r = $conn->query("SELECT COUNT(*) AS c FROM site_visitors WHERE DATE(visited_at)=CURDATE()");
if ($r) $visToday = (int)$r->fetch_assoc()['c'];
$r = $conn->query("SELECT COUNT(*) AS c FROM site_visitors WHERE visited_at >= DATE_SUB(NOW(),INTERVAL 7 DAY)");
if ($r) $visWeek  = (int)$r->fetch_assoc()['c'];
$r = $conn->query("SELECT COUNT(*) AS c FROM site_visitors WHERE visited_at >= DATE_SUB(NOW(),INTERVAL 30 DAY)");
if ($r) $visMonth = (int)$r->fetch_assoc()['c'];
$r = $conn->query("SELECT COUNT(DISTINCT ip_address) AS c FROM site_visitors");
if ($r) $visUnique = (int)$r->fetch_assoc()['c'];

// Daily visits — last 30 days
$dailyLabels = []; $dailyData = [];
$r = $conn->query("SELECT DATE(visited_at) AS d, COUNT(*) AS cnt FROM site_visitors WHERE visited_at >= DATE_SUB(NOW(),INTERVAL 30 DAY) GROUP BY DATE(visited_at) ORDER BY d ASC");
if ($r) { while ($row = $r->fetch_assoc()) { $dailyLabels[] = date('d M', strtotime($row['d'])); $dailyData[] = (int)$row['cnt']; } }

// Top 10 countries
$countryLabels = []; $countryData = [];
$r = $conn->query("SELECT COALESCE(NULLIF(country,''),'Unknown') AS country, COUNT(*) AS cnt FROM site_visitors GROUP BY country ORDER BY cnt DESC LIMIT 10");
if ($r) { while ($row = $r->fetch_assoc()) { $countryLabels[] = $row['country']; $countryData[] = (int)$row['cnt']; } }

// Top 5 pages
$topPages = [];
$r = $conn->query("SELECT page_visited, COUNT(*) AS cnt FROM site_visitors GROUP BY page_visited ORDER BY cnt DESC LIMIT 5");
if ($r) { while ($row = $r->fetch_assoc()) $topPages[] = $row; }
include 'includes/header.php';
include 'includes/sidebar.php' ;

?>
    
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
                <div class="row">
                    <!-- team members card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <a href="Members.php">
                                <div class="card-body">
                                    <h3 class="card-title text-white">Team Members Update</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white"><?php echo $cntMembers; ?></h2>
                                    </div>
                                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                     <!-- team members card end -->
                      <!-- Gecod Orphans card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                           <a href="benefeciaries.php">
                             <div class="card-body">
                            <h3 class="card-title text-white">Gecod Beneficiaries</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white"><?php echo $cntBenef; ?></h2>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-child"></i></span>
                        </div>
                    </a>
                        </div>
                    </div>
                     <!-- Gecod Orphans card end -->
                     <!-- Gecod road map card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                           <a href="roadMap.php">
                            <div class="card-body">
                                <h3 class="card-title text-white">Road Map Posts</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $cntRoadmap; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-map"></i></span>
                            </div>
                           </a>
                        </div>
                    </div>
                    <!-- Gecod road map card end -->
                    <!-- Gecod events card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                           <a href="gecodevents.php">
                            <div class="card-body">
                                <h3 class="card-title text-white">Events</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo $cntEvents; ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-calendar"></i></span>
                            </div>
                           </a>
                        </div>
                    </div>
                    <!-- Gecod events card end -->
                </div>


              
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="../img/CEOGecod - Copy.png" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">Gordan Sabiiti</h5>
                                    <p class="m-0">Founder & CEO</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="../img/Nakacwa Leila - Copy.jpeg" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">Nakacwa Leila</h5>
                                    <p class="m-0">DEPUTY ED</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="./images/users/7.jpg" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">Dr. Mujibu Nkambo</h5>
                                    <p class="m-0">BOARD SECRETARY</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="Members.php">
                            <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="./images/users/1.jpg" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">View All Board </h5>
                                    <p class="m-0">Members</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>

                </div>


                <!-- ===== VISITOR TRACKER SECTION ===== -->
                <hr class="mt-4 mb-3">
                <h5 class="mb-3 text-muted"><i class="fa fa-bar-chart mr-2"></i>Website Traffic</h5>

                <!-- Visitor stat mini-cards -->
                <div class="row mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="card text-center py-3">
                            <h6 class="text-muted mb-1">Today</h6>
                            <h3 class="mb-0"><?php echo number_format($visToday); ?></h3>
                            <small class="text-muted">visits</small>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card text-center py-3">
                            <h6 class="text-muted mb-1">This Week</h6>
                            <h3 class="mb-0"><?php echo number_format($visWeek); ?></h3>
                            <small class="text-muted">visits</small>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card text-center py-3">
                            <h6 class="text-muted mb-1">This Month</h6>
                            <h3 class="mb-0"><?php echo number_format($visMonth); ?></h3>
                            <small class="text-muted">visits</small>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card text-center py-3">
                            <h6 class="text-muted mb-1">Unique IPs</h6>
                            <h3 class="mb-0"><?php echo number_format($visUnique); ?></h3>
                            <small class="text-muted">all time</small>
                        </div>
                    </div>
                </div>

                <!-- Charts row -->
                <div class="row mb-4">
                    <!-- Line chart: daily visitors 30 days -->
                    <div class="col-lg-8 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Daily Visits — Last 30 Days</h6>
                                <canvas id="dailyChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Doughnut: top countries -->
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Visitors by Country</h6>
                                <?php if (empty($countryLabels)): ?>
                                    <p class="text-muted text-center mt-4">No data yet — traffic will appear here once visitors arrive.</p>
                                <?php else: ?>
                                <canvas id="countryChart"></canvas>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top pages table -->
                <?php if (!empty($topPages)): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Most Visited Pages</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead class="thead-light">
                                            <tr><th>Page</th><th style="width:120px">Visits</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($topPages as $tp): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($tp['page_visited'], ENT_QUOTES); ?></td>
                                                <td><?php echo number_format((int)$tp['cnt']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Chart.js -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
                <script>
                // Daily line chart
                (function(){
                    var labels = <?php echo json_encode($dailyLabels); ?>;
                    var data   = <?php echo json_encode($dailyData);   ?>;
                    if (!labels.length) {
                        document.getElementById('dailyChart').insertAdjacentHTML('afterend','<p class="text-muted text-center">No data yet.</p>');
                        document.getElementById('dailyChart').style.display='none';
                        return;
                    }
                    new Chart(document.getElementById('dailyChart'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Visits',
                                data: data,
                                borderColor: '#5e72e4',
                                backgroundColor: 'rgba(94,114,228,0.1)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                        }
                    });
                })();

                // Country doughnut chart
                <?php if (!empty($countryLabels)): ?>
                (function(){
                    var colors = ['#5e72e4','#2dce89','#fb6340','#11cdef','#f3a4b5','#ffd600','#adb5bd','#172b4d','#8965e0','#f4f5f7'];
                    new Chart(document.getElementById('countryChart'), {
                        type: 'doughnut',
                        data: {
                            labels: <?php echo json_encode($countryLabels); ?>,
                            datasets: [{
                                data: <?php echo json_encode($countryData); ?>,
                                backgroundColor: colors
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                            }
                        }
                    });
                })();
                <?php endif; ?>
                </script>
                <!-- ===== END VISITOR TRACKER SECTION ===== -->



            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
       <?php
include 'includes/footer.php';
       ?>