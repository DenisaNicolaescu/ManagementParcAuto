<?php
include 'conexiune.php';


$query_cars = "SELECT id, brand, model, license_plate FROM cars";
$result_cars = mysqli_query($conn, $query_cars);
$query = "
SELECT service_orders.*, cars.brand, cars.model, cars.license_plate
FROM service_orders
LEFT JOIN cars ON service_orders.car_id = cars.id
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management - Autodock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="manager.css">
</head>

<body>

    <nav class="dash-navbar">
        <a href="index.html">
            <img src="images/logo.png" alt="Autodock Logo" class="dash-logo">
        </a>
        <ul class="dash-nav-links">
            <li><a href="dashboard-manager.html">Dashboard</a></li>
            <li><a href="cars-m.php">Cars</a></li>
            <li><a href="drivers.php">Drivers</a></li>
            <li><a href="services.php" class="active">Service</a></li>
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

        <header class="page-header align-start">
            <div class="header-text">
                <h1>Service Management</h1>
                <p>Track repairs, costs and maintenance schedules</p>
            </div>
            <button id="btnOpenServiceModal" class="btn-add-car">+ Add a new intervention</button>
        </header>

        <section class="kpi-row kpi-3-cols">
            <div class="kpi-card">
                <h3>Monthly Budget</h3>
                <p class="kpi-number black">6.500 RON</p>
            </div>
            <div class="kpi-card">
                <h3>Active Repairs</h3>
                <p class="kpi-number black">3 Vehicles</p>
            </div>
            <div class="kpi-card">
                <h3>Avg. Downtime</h3>
                <p class="kpi-number black">1.2 Days</p>
            </div>
        </section>

        <div class="panel inventory-panel">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Vehicle & ID</th>
                        <th>Intervention Type</th>
                        <th>Service Station</th>
                        <th>Progress</th>
                        <th>Estimated Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($service = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td>
                            <strong><?php echo $service['brand']." ".$service['model']; ?></strong><br>
                            <span class="license-plate">
                                <?php echo $service['license_plate']; ?>
                            </span>
                        </td>

                        <td><?php echo $service['intervention_type']; ?></td>
                        <td><?php echo $service['service_center']; ?></td>
                        <td><?php echo $service['status']; ?></td>
                        <td><strong><?php echo $service['estimated_cost']; ?> RON</strong></td>

                        <td class="table-actions">
                            <a href="edit_service.php?id=<?php echo $service['id']; ?>">
                                <span class="material-symbols-outlined action-icon edit-icon">
                                    edit
                                </span>
                            </a>
                            <a href="delete_service.php?id=<?php echo $service['id']; ?>"
                            onclick="return confirm('Delete this intervention?');">
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

    <div id="addServiceModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" id="closeServiceModal">&times;</span>

            <h2>ADD NEW INTERVENTION</h2>

            <form class="add-car-form" action="add_services.php" method="POST">

                <h3 class="section-title">Vehicle & Schedule</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Select Vehicle</label>
                        <select name="car_id">
                        <?php while($car = mysqli_fetch_assoc($result_cars)){ ?>
                            <option value="<?php echo $car['id']; ?>">
                                <?php echo $car['license_plate']." - ".$car['brand']." ".$car['model']; ?>
                            </option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Intervention Date</label>
                        <input type="date" name="appointment_date" value="2026-09-06">
                    </div>
                </div>

                <h3 class="section-title">Service Details</h3>
                <div class="input-group full-width" style="margin-bottom: 15px;">
                    <label>Type of Intervention</label>
                    <select name="intervention_type">
                        <option value="revision">Revision</option>
                        <option value="repair">Repair</option>
                        <option value="inspection">Inspection</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Service name</label>
                        <input type="text" name="service_center" placeholder="e.g. YONI">
                    </div>
                    <div class="input-group">
                        <label>Estimated Cost</label>
                        <input type="text" step="0.01" name="estimated_cost" placeholder="e.g. 500 RON">
                    </div>
                </div>

                <h3 class="section-title">Description/Notes</h3>
                <div class="input-group full-width">
                    <textarea name="description" placeholder="Describe the maintenance or issue..." rows="3"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelService">Cancel</button>
                    <button type="submit" class="btn-submit">Schedule intervention</button>
                </div>

            </form>
        </div>
    </div>
    <div id="editServiceModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" id="closeEditServiceModal">&times;</span>

            <h2>EDIT INTERVENTION</h2>

            <form class="add-car-form">
                
                <h3 class="section-title">Intervention Details</h3>
                
                <div class="input-group full-width" style="margin-bottom: 15px;">
                    <label>Vehicle & ID</label>
                    <select>
                        <option selected>Dacia Jogger (2023) - SB 42 BDP</option>
                        <option>Volkswagen Golf - B 200 ADK</option>
                        <option>Ford Focus - SB 07 DKY</option>
                    </select>
                </div>

                <div class="input-group full-width" style="margin-bottom: 20px;">
                    <label>Intervention Type</label>
                    <input type="text" value="Insurance Renewal & Safety Check">
                </div>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Service Station</label>
                        <input type="text" value="Autoservice Sibiu">
                    </div>
                    <div class="input-group">
                        <label>Estimated Cost</label>
                        <input type="text" value="1,100 RON">
                    </div>
                </div>

                <h3 class="section-title">Status</h3>
                <div class="input-group full-width">
                    <label>Progress</label>
                    <select>
                        <option selected>Pending Approval</option>
                        <option>Scheduled</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelEditService">Cancel</button>
                    <button type="submit" class="btn-submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 420px; text-align: center;">
            <span class="close-modal" id="closeDeleteModal">&times;</span>

            <h2 style="color: var(--status-red); margin-bottom: 15px;">DELETE RECORD</h2>

            <p
                style="font-family: sans-serif; font-size: 15px; color: var(--text-gray-medium); margin-bottom: 30px; line-height: 1.5;">
                Are you sure you want to delete this intervention? <br>
                <strong>This action cannot be undone.</strong>
            </p>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="btnCancelDelete">Cancel</button>
                <button type="button" class="btn-delete" id="btnConfirmDelete">Delete</button>
            </div>
        </div>
    </div>
  <script>
   
    document.addEventListener('DOMContentLoaded', () => {

       
        const serviceModal = document.getElementById("addServiceModal");
        const btnOpenService = document.getElementById("btnOpenServiceModal");
        const btnCloseService = document.getElementById("closeServiceModal");
        const btnCancelService = document.getElementById("btnCancelService");

       
        if (btnOpenService) btnOpenService.addEventListener('click', () => serviceModal.style.display = "flex");
        if (btnCloseService) btnCloseService.addEventListener('click', () => serviceModal.style.display = "none");
        if (btnCancelService) btnCancelService.addEventListener('click', () => serviceModal.style.display = "none");


      
        const editServiceModal = document.getElementById("editServiceModal");
        const closeEditService = document.getElementById("closeEditServiceModal");
        const cancelEditService = document.getElementById("btnCancelEditService");
        
       
        const editIcons = document.querySelectorAll('.edit-icon');
        editIcons.forEach(icon => {
            icon.addEventListener('click', (e) => {
                e.stopPropagation(); 
                if (editServiceModal) editServiceModal.style.display = "flex";
            });
        });

        if (closeEditService) closeEditService.addEventListener('click', () => editServiceModal.style.display = "none");
        if (cancelEditService) cancelEditService.addEventListener('click', () => editServiceModal.style.display = "none");


        
        const deleteModal = document.getElementById("deleteModal");
        const closeDelete = document.getElementById("closeDeleteModal");
        const cancelDelete = document.getElementById("btnCancelDelete");
        const confirmDelete = document.getElementById("btnConfirmDelete");

       
        const deleteIcons = document.querySelectorAll('.delete-icon');
        deleteIcons.forEach(icon => {
            icon.addEventListener('click', (e) => {
                e.stopPropagation();
                if (deleteModal) deleteModal.style.display = "flex";
            });
        });

        if (closeDelete) closeDelete.addEventListener('click', () => deleteModal.style.display = "none");
        if (cancelDelete) cancelDelete.addEventListener('click', () => deleteModal.style.display = "none");
        
        
        if (confirmDelete) {
            confirmDelete.addEventListener('click', () => {
                deleteModal.style.display = "none";
            });
        }


       
        window.addEventListener("click", (event) => {
            if (event.target == serviceModal) serviceModal.style.display = "none";
            if (event.target == editServiceModal) editServiceModal.style.display = "none";
            if (event.target == deleteModal) deleteModal.style.display = "none";
        });


        
        const profileTrigger = document.getElementById('profileTrigger');
        const profileMenu = document.getElementById('profileMenu');

        if (profileTrigger && profileMenu) {
            profileTrigger.addEventListener('click', (event) => {
                profileMenu.classList.toggle('show');
                event.stopPropagation();
            });

            document.addEventListener('click', (event) => {
                if (!profileMenu.contains(event.target) && !profileTrigger.contains(event.target)) {
                    profileMenu.classList.remove('show');
                }
            });
        }
        
    });
    const tableRows = document.querySelectorAll('.inventory-table tbody tr');
        
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                
                if (e.target.closest('.action-icon')) return;

                
                tableRows.forEach(r => {
                    if (r !== this) {
                        r.classList.remove('show-actions');
                    }
                });

              
                this.classList.toggle('show-actions');
            });
        });
</script>
</body>

</html>