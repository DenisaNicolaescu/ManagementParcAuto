<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: welcome.html");
    exit();
}

include 'conexiune.php';
$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$totalFleet = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars")
)['total'];

$activeVehicles = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars WHERE status='active'")
)['total'];

$inMaintenance = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars WHERE status='in_service'")
)['total'];

$criticalAlerts = mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT COUNT(*) AS total
        FROM service_orders
        WHERE appointment_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
        AND status='scheduled'
    ")
)['total'];

$scheduleQuery = "
SELECT
    service_orders.*,
    cars.license_plate
FROM service_orders
LEFT JOIN cars
ON service_orders.car_id = cars.id
ORDER BY appointment_date ASC
LIMIT 3
";

$scheduleResult = mysqli_query($conn, $scheduleQuery);
if($search != ""){

    $fleetQuery = "
    SELECT
        cars.brand,
        cars.model,
        cars.license_plate,
        cars.status,
        drivers.first_name,
        drivers.last_name,
        cars.last_service_date
    FROM cars
    LEFT JOIN drivers
    ON cars.driver_id = drivers.id
    WHERE
        cars.brand LIKE '%$search%'
        OR cars.model LIKE '%$search%'
        OR cars.license_plate LIKE '%$search%'
        OR drivers.first_name LIKE '%$search%'
        OR drivers.last_name LIKE '%$search%'
    ";

}
else{

    $fleetQuery = "
    SELECT
        cars.brand,
        cars.model,
        cars.license_plate,
        cars.status,
        drivers.first_name,
        drivers.last_name,
        cars.last_service_date
    FROM cars
    LEFT JOIN drivers
    ON cars.driver_id = drivers.id
    LIMIT 5
    ";

}
$docsAlertQuery = "
SELECT documents.*, cars.license_plate
FROM documents
LEFT JOIN cars ON documents.car_id = cars.id
ORDER BY expiry_date ASC
LIMIT 5
";

$docsAlertResult = mysqli_query($conn, $docsAlertQuery);

$fleetResult = mysqli_query($conn, $fleetQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Autodock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="manager.css?v=2">
</head>

<body>

    <nav class="dash-navbar">
        <a href="index.html">
            <img src="images/logo.png" alt="Autodock Logo" class="dash-logo">
        </a>
        <ul class="dash-nav-links">
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="cars-m.php">Cars</a></li>
            <li><a href="drivers.php">Drivers</a></li>
            <li><a href="services.php">Service</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="documents-m.php">Documents</a></li>
        </ul>

        <div class="profile-dropdown-container">

            <div class="profile-trigger" id="profileTrigger">
                <div class="profile-avatar">AP</div>
                <div class="profile-info">
                    <span class="profile-name">
                        <?php echo $_SESSION['username']; ?>
                    </span>
                    <span class="profile-role">Manager</span>
                </div>
                <span class="material-symbols-outlined arrow-icon">expand_more</span>
            </div>

            <div class="profile-menu" id="profileMenu">
                <div class="profile-menu-header">
                    <strong>Manager Central</strong>
                    <span>manager@autodock.ro</span>
                </div>

                <hr class="dropdown-divider">

                <a href="#" class="profile-menu-item">
                    <span class="material-symbols-outlined">account_circle</span> My Profile
                </a>
                <a href="#" class="profile-menu-item">
                    <span class="material-symbols-outlined">settings</span> Account Settings
                </a>

                <hr class="dropdown-divider">

                <a href="logout.php" class="profile-menu-item sign-out">
                    <span class="material-symbols-outlined">logout</span> Sign Out
                </a>
            </div>
        </div>
    </nav>

    <main class="dashboard-container">

        <header class="dash-header">
            <h1>Welcome back, <?php echo $_SESSION['username']; ?>!</h1>
            <div class="header-actions">
                <form method="GET" action="dashboard_manager.php">
                    <input
                        type="text"
                        name="search"
                        class="search-bar"
                        placeholder="Search vehicle, driver or docs..."
                        value="<?php echo $search; ?>"
                    >
                    <button type="submit" class="btn-search">Search</button>
                </form>
            </div>
        </header>

        <section class="kpi-row">
            <div class="kpi-card">
                <h3>TOTAL FLEET</h3>
                <p class="kpi-number black"><?php echo $totalFleet; ?></p>
            </div>
            <div class="kpi-card">
                <h3>ACTIVE VEHICLES</h3>
                <p class="kpi-number green"><?php echo $activeVehicles; ?></p>
            </div>
            <div class="kpi-card">
                <h3>IN MAINTENANCE</h3>
                <p class="kpi-number yellow"><?php echo $inMaintenance; ?></p>
            </div>
            <div class="kpi-card">
                <h3>CRITICAL ALERTS</h3>
                <p class="kpi-number red"><?php echo $criticalAlerts; ?></p>
            </div>
        </section>

        <section class="main-grid">

            <div class="grid-left">

                <div class="panel">
                    <div class="panel-header">
                        <h2>Document Expiration Alerts</h2>
                        <a href="documents-m.php" class="link-view-all">View all →</a>
                    </div>
                        <?php
                        while($doc = mysqli_fetch_assoc($docsAlertResult)){
                            $daysLeft = floor(
                                (strtotime($doc['expiry_date']) - time()) / 86400
                            );
                            $isExpired = $daysLeft < 0;
                        ?>
                        <div class="alert-box <?php echo $isExpired ? 'alert-red' : 'alert-yellow'; ?>">
                            <div class="alert-info">
                                <span class="material-symbols-outlined <?php echo $isExpired ? 'alert-icon-red' : 'alert-icon-yellow'; ?>">
                                    <?php echo $isExpired ? 'warning' : 'assignment'; ?>
                                </span>
                                <div>
                                    <h4>
                                        <?php echo $doc['doc_type']; ?>
                                        -
                                        <?php echo $doc['license_plate']; ?>
                                    </h4>
                                    <p>
                                    <?php
                                    if($isExpired){
                                        echo "Expired ".abs($daysLeft)." days ago";
                                    }else{
                                        echo "Expires in ".$daysLeft." days";
                                    }
                                    ?>
                                    </p>
                                </div>
                            </div>
                            <a href="documents-m.php"
                            class="btn-alert <?php echo $isExpired ? 'btn-red' : 'btn-yellow'; ?>">

                                <?php echo $isExpired ? 'Renew now' : 'View'; ?>
                            </a>
                        </div>
                        <?php } ?>
                    </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2>Live Fleet Status</h2>
                        <a href="cars-m.php" class="link-view-all">View full inventory →</a>
                    </div>
                    <table class="fleet-table">
                        <thead>
                            <tr>
                                <th>VEHICLE</th>
                                <th>DRIVER</th>
                                <th>STATUS</th>
                                <th>LAST SERVICE</th>
                            </tr>
                        </thead>
                        <tbody>

                    <?php while($car = mysqli_fetch_assoc($fleetResult)){ ?>
                    <tr>
                        <td>
                            <?php echo $car['brand']." ".$car['model']; ?>
                            (<?php echo $car['license_plate']; ?>)
                        </td>
                        <td>
                            <?php
                            if($car['first_name']){
                                echo $car['first_name']." ".$car['last_name'];
                            } else {
                                echo "Unassigned";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $class = "text-yellow";

                            if($car['status'] == 'active'){
                                $class = "text-green";
                            }

                            if($car['status'] == 'in_service'){
                                $class = "text-red";
                            }
                            ?>
                            <span class="<?php echo $class; ?>">
                                <?php echo strtoupper($car['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php echo $car['last_service_date']; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="grid-right">

                <div class="panel">
                    <h2>Service Schedule</h2>
                    <div class="schedule-list">
                        <?php while($event = mysqli_fetch_assoc($scheduleResult)){ ?>
                        <div class="schedule-item">
                            <span class="dot dot-purple"></span>
                            <div>
                                <p class="date-task">
                                    <?php echo date('M d', strtotime($event['appointment_date'])); ?>
                                    -
                                    <?php echo ucfirst($event['intervention_type']); ?>
                                </p>
                                <p class="car-details">
                                    <?php echo $event['license_plate']; ?>
                                    |
                                    <?php echo $event['service_center']; ?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <button class="btn-outline-purple" onclick="window.location.href='calendar.php'">View full
                        calendar</button>
                </div>

                <div class="panel">
                    <h3 class="costs-title">Maintenance Costs (May)</h3>
                    <p class="costs-amount">4,200 RON</p>
                    <p class="costs-trend">↑ 12% vs last month</p>

                    <div class="progress-container">
                        <div class="progress-bar"></div>
                    </div>
                    <p class="progress-text">Budget Used: 70%</p>
                </div>

            </div>
        </section>
    </main>
    <script>
        const profileTrigger = document.getElementById('profileTrigger');
        const profileMenu = document.getElementById('profileMenu');

        profileTrigger.addEventListener('click', function (event) {
            profileMenu.classList.toggle('show');
            event.stopPropagation();
        });

        document.addEventListener('click', function (event) {
            if (!profileMenu.contains(event.target) && !profileTrigger.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });
    </script>
</body>

</html>