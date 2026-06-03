<?php
include 'conexiune.php';
$query="SELECT * FROM cars";
$result=mysqli_query($conn, $query);

//while($car=mysqli_fetch_assoc($result)){
//echo $car['brand']." ".$car['model']."<br>";
//}
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
                        <th>Assigned Driver</th>
                        <th>Status</th>
                        <th>Next Maintenance</th>
                        <th>Documents</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($car=mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td>
                            <strong>
                                <?php echo $car['brand']." ".$car['model']." (".$car['year'].")";?>
                            </strong><br>
                            <span class="license_plate">
                                <?php echo $car['license_plate']; ?>
                            </span>
                        </td>

                        <td>Unassigned</td>

                        <td>
                            <?php echo $car['status']; ?>
                        </td>

                        <td><?php echo $car['next_service_date']; ?></td>
                        <td><?php echo $car['documents']; ?></td>
                        <td class="table-actions"> 
                            <a href="edit_car.php?id=<?php echo $car['id']; ?>">📝</a>
                            <a href="delete_car.php?id=<?php echo $car['id']; ?>">🗑️</a>
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
                        <label>Brand </label>
                        <input type="text" name="brand" placeholder="e.g. Dacia">
                    </div>
                    <div class="input-group">
                        <label>Model </label>
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
                     <div class="input-group">
                        <label>Next Service Date</label>
                        <input type="text" name="next_service_date">
                    </div>
                     <div class="input-group">
                        <label>Documents</label>
                        <input type="text" name="documents">
                    </div>
                    
                </div>

                <h3 class="section-title">Document status</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>RCA Expiration Date</label>
                        <input type="date">
                    </div>
                    <div class="input-group">
                        <label>ITP Expiration Date</label>
                        <input type="date">
                    </div>
                </div>

                <h3 class="section-title">Assignment</h3>
                <div class="input-group full-width">
                    <label>Assign Driver</label>
                    <input type="text" placeholder="Unassigned">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancel">Cancel</button>
                    <button type="submit" class="btn-submit">Add to fleet</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        // Luăm elementele din pagină
        const modal = document.getElementById("addCarModal");
        const btnOpen = document.getElementById("btnOpenModal");
        const btnClose = document.getElementById("closeModal");
        const btnCancel = document.getElementById("btnCancel");

        // Când apăsăm "Add a new car", afișăm modala
        btnOpen.onclick = function() {
            modal.style.display = "flex";
        }

        // Când apăsăm pe X, ascundem modala
        btnClose.onclick = function() {
            modal.style.display = "none";
        }

        // Când apăsăm pe Cancel, ascundem modala
        btnCancel.onclick = function() {
            modal.style.display = "none";
        }

        // Dacă dăm click pe fundalul gri închis, o ascundem
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>