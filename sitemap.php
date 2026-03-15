<?php
header('Content-Type: application/xml; charset=utf-8');
include 'config.php';

$base = 'https://gecodinitiative.org';

// Static pages with priorities
$static = [
    ['loc' => '/',                    'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => '/about.php',           'priority' => '0.9', 'changefreq' => 'monthly'],
    ['loc' => '/Orphans.php',         'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => '/event.php',           'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/careers-and-jobs.php','priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/Road%20Map.php',      'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/contact.php',         'priority' => '0.7', 'changefreq' => 'yearly'],
    ['loc' => '/checkout-cart.php',   'priority' => '0.6', 'changefreq' => 'monthly'],
];

// Dynamic: individual orphan profiles
$orphans = [];
$res = $conn->query("SELECT orphanid FROM gecodorphans ORDER BY orphanid ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $orphans[] = (int)$row['orphanid'];
    }
}

// Dynamic: individual job listings
$jobs = [];
$res2 = $conn->query("SELECT recordid FROM jobcareer ORDER BY recordid ASC");
if ($res2) {
    while ($row = $res2->fetch_assoc()) {
        $jobs[] = (int)$row['recordid'];
    }
}

// Dynamic: individual road map posts
$roadmaps = [];
$res3 = $conn->query("SELECT recordid FROM gecodroadmap ORDER BY recordid ASC");
if ($res3) {
    while ($row = $res3->fetch_assoc()) {
        $roadmaps[] = (int)$row['recordid'];
    }
}

$today = date('Y-m-d');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($static as $page) {
    echo "  <url>\n";
    echo "    <loc>" . $base . $page['loc'] . "</loc>\n";
    echo "    <lastmod>" . $today . "</lastmod>\n";
    echo "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
    echo "    <priority>" . $page['priority'] . "</priority>\n";
    echo "  </url>\n";
}

foreach ($orphans as $id) {
    echo "  <url>\n";
    echo "    <loc>" . $base . "/vieworphandetails.php?id=" . $id . "</loc>\n";
    echo "    <lastmod>" . $today . "</lastmod>\n";
    echo "    <changefreq>monthly</changefreq>\n";
    echo "    <priority>0.6</priority>\n";
    echo "  </url>\n";
}

foreach ($jobs as $id) {
    echo "  <url>\n";
    echo "    <loc>" . $base . "/viewjob.php?id=" . $id . "</loc>\n";
    echo "    <lastmod>" . $today . "</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.6</priority>\n";
    echo "  </url>\n";
}

foreach ($roadmaps as $id) {
    echo "  <url>\n";
    echo "    <loc>" . $base . "/viewroadmap.php?id=" . $id . "</loc>\n";
    echo "    <lastmod>" . $today . "</lastmod>\n";
    echo "    <changefreq>monthly</changefreq>\n";
    echo "    <priority>0.5</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>' . "\n";
?>
