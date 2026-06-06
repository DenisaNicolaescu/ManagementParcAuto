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

     <div id="editCarModal" class="modal-overlay">

        <div class="modal-content" style="max-width: 550px;">
            <span class="close-modal" id="closeEditCarModal">&times;</span>


            <div style="margin-bottom: 20px;">
                <h2 style="margin-bottom: 5px;">EDIT VEHICLE</h2>
                <p style="color: var(--text-gray-medium); font-family: sans-serif; font-size: 15px; margin: 0;">SB 42
                    BDP</p>
            </div>

            <form class="add-car-form">


                <h3 class="section-title">Vehicle identity</h3>
                <div class="form-grid grid-3-cols" style="margin-bottom: 15px;">
                    <div class="input-group">
                        <label>Make</label>
                        <input type="text" value="Dacia">
                    </div>
                    <div class="input-group">
                        <label>Model</label>
                        <input type="text" value="Jogger">
                    </div>
                    <div class="input-group">
                        <label>Year</label>
                        <input type="text" value="2023">
                    </div>
                </div>
                <div class="input-group full-width" style="margin-bottom: 25px;">
                    <label>License plate</label>
                    <input type="text" value="SB 42 BDP">
                </div>


                <h3 class="section-title">Engine & performance</h3>
                <div class="form-grid grid-3-cols" style="margin-bottom: 15px;">
                    <div class="input-group">
                        <label>Fuel type</label>
                        <select>
                            <option selected>Gasoline</option>
                            <option>Diesel</option>
                            <option>Hybrid</option>
                            <option>Electric</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Engine size</label>
                        <div class="input-with-unit unit-short">
                            <input type="number" step="0.1" value="1.5">
                            <span class="unit">L</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Horsepower</label>
                        <div class="input-with-unit unit-medium">
                            <input type="number" value="95">
                            <span class="unit">hp</span>
                        </div>
                    </div>
                </div>
                <div class="form-grid" style="margin-bottom: 25px;">
                    <div class="input-group">
                        <label>Fuel consumption</label>
                        <div class="input-with-unit unit-long">
                            <input type="number" step="0.1" value="1.5">
                            <span class="unit">L/100km</span>
                        </div>
                    </div>
                </div>


                <h3 class="section-title">Status & mileage</h3>
                <div class="form-grid" style="margin-bottom: 15px;">
                    <div class="input-group">
                        <label>Mileage</label>
                        <div class="input-with-unit unit-medium">
                            <input type="text" value="50.000">
                            <span class="unit">km</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Next service date</label>
                        <input type="date" value="2026-09-06">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Status</label>
                        <select>
                            <option selected>Active</option>
                            <option>In Service</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                </div>


                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelEditCar">Cancel</button>
                    <button type="submit" class="btn-submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editTireModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 450px;">
            <span class="close-modal" id="closeEditTireModal">&times;</span>

          
            <div style="margin-bottom: 20px;">
                <h2 style="margin-bottom: 5px;">EDIT TIRES</h2>
                <p style="color: var(--text-gray-medium); font-family: sans-serif; font-size: 15px; margin: 0;">SB 42
                    BDP</p>
            </div>

            <form class="add-car-form" action="update_tire.php" method="POST">

                <h3 class="section-title">Tires information</h3>

             
                <div class="form-grid" style="margin-bottom: 15px;">
                    <div class="input-group">
                        <label>Brand</label>
                        <input type="text" name="brand" value="Michelin Alpin 6">
                    </div>
                    <div class="input-group">
                        <label>Size</label>
                        <input type="text" name="size" value="205/60 R16">
                    </div>
                </div>

               
                <div class="input-group full-width" style="margin-bottom: 15px;">
                    <label>Tire type</label>
                    <select name="tire_type">
                        <option selected>Winter</option>
                        <option>Summer</option>
                        <option>All-Season</option>
                    </select>
                </div>

                
                <div class="input-group full-width" style="margin-bottom: 15px;">
                    <label>Wear level (%)</label>
                    <div class="input-with-unit unit-short">
                       
                        <input type="number" name="wear_level" value="15" id="wearInput"
                            style="background: linear-gradient(to right, var(--status-green) 15%, transparent 15%); font-weight: bold;">
                        <span class="unit">%</span>
                    </div>
                </div>

               
                <div class="input-group full-width" style="margin-bottom: 25px;">
                    <label>Condition status</label>
                    <select name="condition_status">
                        <option selected>Good</option>
                        <option>Normal Wear</option>
                        <option>Needs Replacement</option>
                    </select>
                </div>

                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelEditTire">Cancel</button>
                    <button type="submit" class="btn-submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>

     <div id="deleteModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 420px; text-align: center;">
            <span class="close-modal" id="closeDeleteModal">&times;</span>

            <h2 style="color: var(--status-red); margin-bottom: 15px;">DELETE RECORD</h2>
            
            <p style="font-family: sans-serif; font-size: 15px; color: var(--text-gray-medium); margin-bottom: 30px; line-height: 1.5;">
                Are you sure you want to delete this driver? <br>
                <strong>This action cannot be undone.</strong>
            </p>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="btnCancelDelete">Cancel</button>
                <button type="button" class="btn-delete" id="btnConfirmDelete">Delete</button>
            </div>
        </div>
    </div>

     <script>
        
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.style.display = "flex";
        }

        // Funcție ajutătoare pentru a închide un modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.style.display = "none";
        }

    
        const btnOpenAddCar = document.getElementById("btnOpenModal");
        if (btnOpenAddCar) btnOpenAddCar.onclick = () => openModal("addCarModal");
        
        const closeAddCar = document.getElementById("closeModal");
        if (closeAddCar) closeAddCar.onclick = () => closeModal("addCarModal");
        
        const cancelAddCar = document.getElementById("btnCancel");
        if (cancelAddCar) cancelAddCar.onclick = () => closeModal("addCarModal");

    
        const btnOpenAddTire = document.getElementById("btnOpenTireModal");
        if (btnOpenAddTire) btnOpenAddTire.onclick = () => openModal("addTireModal");

        const closeAddTire = document.getElementById("closeTireModal");
        if (closeAddTire) closeAddTire.onclick = () => closeModal("addTireModal");

        const cancelAddTire = document.getElementById("btnCancelTire");
        if (cancelAddTire) cancelAddTire.onclick = () => closeModal("addTireModal");

    
        const inventoryTables = document.querySelectorAll('.inventory-table');
        
        if (inventoryTables.length > 0) {
            const carEditIcons = inventoryTables[0].querySelectorAll('.edit-icon');
            carEditIcons.forEach(icon => {
                icon.addEventListener('click', function (e) {
                    e.stopPropagation();
                    openModal("editCarModal");
                });
            });
        }
        
        const closeEditCar = document.getElementById("closeEditCarModal");
        if (closeEditCar) closeEditCar.onclick = () => closeModal("editCarModal");
        
        const cancelEditCar = document.getElementById("btnCancelEditCar");
        if (cancelEditCar) cancelEditCar.onclick = () => closeModal("editCarModal");

    
        if (inventoryTables.length > 1) {
            const tireEditIcons = inventoryTables[1].querySelectorAll('.edit-icon');
            tireEditIcons.forEach(icon => {
                icon.addEventListener('click', function (e) {
                    e.stopPropagation();
                    openModal("editTireModal");
                });
            });
        }

        const closeEditTire = document.getElementById("closeEditTireModal");
        if (closeEditTire) closeEditTire.onclick = () => closeModal("editTireModal");

        const cancelEditTire = document.getElementById("btnCancelEditTire");
        if (cancelEditTire) cancelEditTire.onclick = () => closeModal("editTireModal");

      
        let rowToDelete = null; 
        
        const deleteIcons = document.querySelectorAll('.delete-icon');
        deleteIcons.forEach(icon => {
            icon.addEventListener('click', function (e) {
                e.stopPropagation(); 
                rowToDelete = this.closest('tr'); 
                openModal("deleteModal"); 
            });
        });

        const closeDelete = document.getElementById("closeDeleteModal");
        if (closeDelete) closeDelete.onclick = () => closeModal("deleteModal");

        const cancelDelete = document.getElementById("btnCancelDelete");
        if (cancelDelete) cancelDelete.onclick = () => closeModal("deleteModal");

        const confirmDelete = document.getElementById("btnConfirmDelete");
        if (confirmDelete) {
            confirmDelete.onclick = () => {
                if (rowToDelete) {
                    rowToDelete.remove(); 
                    rowToDelete = null; 
                }
                closeModal("deleteModal"); 
            };
        }

        
        window.addEventListener("click", function (event) {
            if (event.target.classList.contains("modal-overlay")) {
                event.target.style.display = "none";
            }
        });

       
        const wearInput = document.getElementById('wearInput');
        if(wearInput) {
            wearInput.addEventListener('input', function() {
                let val = this.value || 0;
                if(val > 100) val = 100;
                if(val < 0) val = 0;
                this.style.background = `linear-gradient(to right, var(--status-green) ${val}%, transparent ${val}%)`;
            });
        }

       
        const profileTrigger = document.getElementById('profileTrigger');
        const profileMenu = document.getElementById('profileMenu');
        if (profileTrigger && profileMenu) {
            profileTrigger.addEventListener('click', function (event) {
                profileMenu.classList.toggle('show');
                event.stopPropagation();
            });
            document.addEventListener('click', function (event) {
                if (!profileMenu.contains(event.target) && !profileTrigger.contains(event.target)) {
                    profileMenu.classList.remove('show');
                }
            });
        }

       
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