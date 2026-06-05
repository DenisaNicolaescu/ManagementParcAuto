<?php
include 'conexiune.php';

$query="SELECT * FROM cars";
$result=mysqli_query($conn, $query);

$query_tires = "
SELECT tires.*, cars.brand AS car_brand, cars.model AS car_model
FROM tires
LEFT JOIN cars ON tires.car_id = cars.id
";

$result_tires = mysqli_query($conn, $query_tires);
$queryCars = "SELECT id, brand, model, license_plate, year FROM cars";
$resultCars = mysqli_query($conn, $queryCars);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Inventory - Autodock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="manager.css">
</head>

<body>

    <nav class="dash-navbar">
        <a href="index.html">
            <img src="images/logo.png" alt="Autodock Logo" class="dash-logo">
        </a>
        <ul class="dash-nav-links">
            <li><a href="dashboard-manager.html">Dashboard</a></li>
            <li><a href="cars-m.html" class="active">Cars</a></li>
            <li><a href="drivers.html">Drivers</a></li>
            <li><a href="services.html">Service</a></li>
            <li><a href="calendar.html">Calendar</a></li>
            <li><a href="documents-m.html">Documents</a></li>
        </ul>


        <div class="profile-dropdown-container">
            <div class="profile-trigger" id="profileTrigger">
                <div class="profile-avatar">AP</div>
                <div class="profile-info">
                    <span class="profile-name">Adrian Popescu</span>
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

                <a href="index.html" class="profile-menu-item sign-out">
                    <span class="material-symbols-outlined">logout</span> Sign Out
                </a>
            </div>
        </div>
    </nav>

    <main class="dashboard-container">

        <header class="page-header">
            <h1>Cars inventory</h1>
            <button id="btnOpenModal" class="btn-add-car">+ Add a new car</button>
        </header>

        <div class="filters-row">
            <input type="text" placeholder="Search by ID, brand or driver...." class="search-wide">
            <select class="status-dropdown">
                <option value="all">All statuses</option>
                <option value="active">Active</option>
                <option value="warning">Warning</option>
                <option value="service">In service</option>
            </select>
        </div>

        <div class="panel inventory-panel">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Vehicle Details</th>
                        <th class="text-center">Specs (Fuel/Eng/Power)</th>
                        <th class="text-center">Mileage</th>
                        <th class="text-center">Assigned Driver</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Service (Last/Next)</th>
                        <th></th> 
                    </tr>
                </thead>
            <tbody>

            <?php while($car = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td>
                    <strong>
                        <?php echo $car['brand']." ".$car['model']." (".$car['year'].")"; ?>
                    </strong>
                    <br>
                    <span class="license-plate">
                        <?php echo $car['license_plate']; ?>
                    </span>
                </td>

                <td class="text-center">
                    <?php echo $car['fuel_type']; ?> |
                    <?php echo $car['capacity']; ?>L |
                    <?php echo $car['power']; ?> HP
                    <br>
                    <span style="color: var(--text-muted); font-size:12px;">
                        <?php echo $car['consumption']; ?> L/100km
                    </span>
                </td>

                <td class="text-center">
                    <?php echo number_format($car['mileage']); ?> km
                </td>

                <td class="text-center">
                    Unassigned
                </td>

                <td class="text-center">
                    <?php echo $car['status']; ?>
                </td>

                <td class="text-center">
                    Last:
                    <?php echo $car['last_service_date'] ?: 'N/A'; ?>
                    <br>
                    Next:
                    <?php echo $car['next_service_date'] ?: 'N/A'; ?>
                </td>

                <td class="table-actions">

                    <a href="edit_car.php?id=<?php echo $car['id']; ?>">
                        <span class="material-symbols-outlined action-icon edit-icon">edit</span>
                    </a>

                    <a href="delete_car.php?id=<?php echo $car['id']; ?>"
                    onclick="return confirm('Delete this car?');">
                    <span class="material-symbols-outlined action-icon delete-icon">delete</span>
                    </a>

                </td>

            </tr>

            <?php } ?>

            </tbody>
            </table>
        </div>

        <div class="page-header" style="margin-top: 50px; margin-bottom: 20px;">
            <h1 style="margin: 0;">Tires inventory</h1>
            <button class="btn-add-car" id="btnOpenTireModal">+ Add new tires</button>
        </div>

        <div class="panel inventory-panel">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Vehicle Details</th>
                        <th class="text-center">Tire Type</th>
                        <th class="text-center">Brand/Dimension</th>
                        <th class="text-center">Wear level</th>
                        <th class="text-center">Condition Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                   <?php while($tire = mysqli_fetch_assoc($result_tires)){ ?>
                    <tr>
                        <td>
                            <strong>
                            <?php echo $tire['car_brand']." ".$tire['car_model']; ?>
                            </strong><br>
                            ID: <?php echo $tire['car_id']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $tire['tire_type']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $tire['brand']; ?><br>
                            <?php echo $tire['size']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $tire['wear_level']; ?>%
                        </td>
                        <td class="text-center">
                            <?php echo $tire['condition_status']; ?>
                        </td>
                        <td class="table-actions">
                            <a href="edit_tire.php?id=<?php echo $tire['id']; ?>">
                                <span class="material-symbols-outlined action-icon edit-icon">
                                    edit
                                </span>
                            </a>
                            <a href="delete_tire.php?id=<?php echo $tire['id']; ?>"
                            onclick="return confirm('Delete this tire?');">
                                <span class="material-symbols-outlined action-icon delete-icon">
                                    delete
                                </span>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody> 
            </table>
        </div>

    </main>

    <div id="addCarModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" id="closeModal">&times;</span>

            <h2>ADD NEW VEHICLE</h2>

            <form class="add-car-form" action="add_car.php" method="POST">

                <h3 class="section-title">General information</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Brand & Model</label>
                        <input type="text" name="brand" placeholder="e.g. Dacia">
                        <input type="text" name="model" placeholder="e.g. Logan">
                    </div>
                    <div class="input-group">
                        <label>License Plate</label>
                        <input type="text" name="license_plate" placeholder="e.g. SB 12 AAA">
                    </div>
                    <div class="input-group">
                        <label>Year</label>
                        <input type="number" name="year" value="2026">
                    </div>
                    <div class="input-group">
                        <label>VIN (Chassis Number)</label>
                        <input type="text" name="vin" placeholder="17 characters">
                    </div>
                </div>

                <h3 class="section-title">Document status</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>RCA Expiration Date</label>
                        <input type="date" name="rca_expiry_date">
                    </div>
                    <div class="input-group">
                        <label>ITP Expiration Date</label>
                        <input type="date" name="itp_expiry_date">
                    </div>
                </div>

                <h3 class="section-title">Assignment</h3>
                <div class="input-group full-width">
                    <label>Assign Driver</label>
                    <input type="text" name="assign_driver" placeholder="Unassigned">
                </div>
                <div class="input-group">
                    <label>Engine Capacity (L)</label>
                    <input type="number" step="0.1" name="capacity">
                </div>

                <div class="input-group">
                    <label>Power (HP)</label>
                    <input type="number" name="power">
                </div>

                <div class="input-group">
                    <label>Consumption (L/100km)</label>
                    <input type="number" step="0.1" name="consumption">
                </div>

                <div class="input-group">
                    <label>Mileage</label>
                    <input type="number" name="mileage">
                </div>
                <div class="input-group">
                    <label>Last Service Date</label>
                    <input type="date" name="last_service_date">
                </div>

                <div class="input-group">
                    <label>Next Service Date</label>
                    <input type="date" name="next_service_date">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancel">Cancel</button>
                    <button type="submit" class="btn-submit">Add to fleet</button>
                </div>

            </form>
        </div>
    </div>
    <div id="addTireModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" id="closeTireModal">&times;</span>

            <h2>ADD NEW TIRES</h2>

            <form class="add-car-form" action="add_tire.php" method="POST">

                <h3 class="section-title">General information</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Brand & Dimension</label>
                            <input type="text" name="brand" placeholder="e.g Michelin">
                            <input type="text" name="size" placeholder="e.g 205/60 R16">
                    </div>
                    <div class="input-group">
                        <label>Tire Type</label>
                        <select name="tire_type">
                            <option value="winter">Winter Tires</option>
                            <option value="summer">Summer Tires</option>
                            <option value="all-season">All-Season Tires</option>
                        </select>
                    </div>
                </div>

                <h3 class="section-title">Condition & Status</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Wear Level (%)</label>
                        <input type="text" name="wear_level" placeholder="e.g. 15%">
                    </div>
                    <div class="input-group">
                        <label>Condition Status</label>
                        <select name="condition_status">
                            <option value="new">Good Condition</option>
                            <option value="used">Normal Wear</option>
                            <option value="worn">Needs Replacement</option>
                        </select>
                    </div>
                </div>

                <h3 class="section-title">Assignment</h3>
                <div class="input-group">
                    <label>Assign to Vehicle</label>
                    <select name="car_id">
                        <option value="">Unassigned</option>
                        <?php while($carOption = mysqli_fetch_assoc($resultCars)){ ?>
                            <option value="<?php echo $carOption['id']; ?>">
                                <?php echo $carOption['brand']." ".$carOption['model']." (".$carOption['year'].") - ".$carOption['license_plate']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelTire">Cancel</button>
                    <button type="submit" class="btn-submit">Add to fleet</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>

        const modal = document.getElementById("addCarModal");
        const btnOpen = document.getElementById("btnOpenModal");
        const btnClose = document.getElementById("closeModal");
        const btnCancel = document.getElementById("btnCancel");


        btnOpen.onclick = function () {
            modal.style.display = "flex";
        }


        btnClose.onclick = function () {
            modal.style.display = "none";
        }


        btnCancel.onclick = function () {
            modal.style.display = "none";
        }

        const tireModal = document.getElementById("addTireModal");
        const btnOpenTire = document.getElementById("btnOpenTireModal");
        const btnCloseTire = document.getElementById("closeTireModal");
        const btnCancelTire = document.getElementById("btnCancelTire");

        btnOpenTire.onclick = function () {
            tireModal.style.display = "flex";
        }

        btnCloseTire.onclick = function () {
            tireModal.style.display = "none";
        }

        btnCancelTire.onclick = function () {
            tireModal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }

            if (event.target == tireModal) {
                tireModal.style.display = "none";
            }
        }


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

        
        document.addEventListener('DOMContentLoaded', () => {
            const tableRows = document.querySelectorAll('.inventory-table tbody tr');

            tableRows.forEach(row => {
                row.addEventListener('click', function (e) {
                    
                    if (e.target.closest('.action-icon')) return;

                   
                    tableRows.forEach(r => {
                        if (r !== this) {
                            r.classList.remove('show-actions');
                        }
                    });

                   
                    this.classList.toggle('show-actions');
                });
            });
        });

        

    </script>
</body>

</html>