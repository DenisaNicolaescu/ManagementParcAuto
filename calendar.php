<?php
include 'conexiune.php';
$query_cars = "SELECT id, brand, model, license_plate FROM cars";
$result_cars = mysqli_query($conn, $query_cars);

$query = "
SELECT service_orders.*, cars.license_plate
FROM service_orders
LEFT JOIN cars ON service_orders.car_id = cars.id
ORDER BY appointment_date
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Calendar - Autodock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="manager.css">
</head>

<body>
    <nav class="dash-navbar">
        <a href="index.html">
            <img src="images/logo.png" alt="Autodock Logo" class="dash-logo">
        </a>
        <ul class="dash-nav-links">
            <li><a href="dashboard-manager.html">Dashboard</a></li>
            <li><a href="cars-m.html">Cars</a></li>
            <li><a href="drivers.html">Drivers</a></li>
            <li><a href="services.html">Service</a></li>
            <li><a href="calendar.html" class="active">Calendar</a></li>
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
            <h1>Fleet Calendar - June 2026</h1>
            <button id="btnOpenEventModal" class="btn-add-car">+ Add a new event</button>
        </header>

        <div class="calendar-wrapper">

            <div class="calendar-header-row">
                <div>MON</div>
                <div>TUE</div>
                <div>WED</div>
                <div>THU</div>
                <div>FRI</div>
                <div>SAT</div>
                <div>SUN</div>
            </div>

            <div class="calendar-grid">

                <div class="cal-day"><span class="day-number">1</span></div>
                <div class="cal-day">
                    <span class="day-number">2</span>
                    <div class="event-pill event-green">SB 81 NQL: Service Done</div>
                </div>
                <div class="cal-day"><span class="day-number">3</span></div>
                <div class="cal-day"><span class="day-number">4</span></div>
                <div class="cal-day"><span class="day-number">5</span></div>
                <div class="cal-day">
                    <span class="day-number">6</span>
                    <div class="event-pill event-grey">SB 07 DKY: Oil change (YONI)</div>
                </div>
                <div class="cal-day"><span class="day-number">7</span></div>

                <div class="cal-day">
                    <span class="day-number">8</span>
                    <div class="event-pill event-yellow">CJ 92 CBL: Safety inspection</div>
                </div>
                <div class="cal-day"><span class="day-number">9</span></div>
                <div class="cal-day"><span class="day-number">10</span></div>
                <div class="cal-day">
                    <span class="day-number">11</span>
                    <div class="event-pill event-yellow">SB 23 ALX: ITP (Autoservice)</div>
                </div>
                <div class="cal-day"><span class="day-number">12</span></div>
                <div class="cal-day"><span class="day-number">13</span></div>
                <div class="cal-day"><span class="day-number">14</span></div>

                <div class="cal-day">
                    <span class="day-number">15</span>
                    <div class="event-pill event-red">CRITICAL: SB 42 BDP RCA</div>
                </div>
                <div class="cal-day"><span class="day-number">16</span></div>
                <div class="cal-day"><span class="day-number">17</span></div>
                <div class="cal-day"><span class="day-number">18</span></div>
                <div class="cal-day"><span class="day-number">19</span></div>
                <div class="cal-day"><span class="day-number">20</span></div>
                <div class="cal-day"><span class="day-number">21</span></div>

                <div class="cal-day"><span class="day-number">22</span></div>
                <div class="cal-day"><span class="day-number">23</span></div>
                <div class="cal-day"><span class="day-number">24</span></div>
                <div class="cal-day"><span class="day-number">25</span></div>
                <div class="cal-day"><span class="day-number">26</span></div>
                <div class="cal-day"><span class="day-number">27</span></div>
                <div class="cal-day"><span class="day-number">28</span></div>

                <div class="cal-day"><span class="day-number">29</span></div>
                <div class="cal-day"><span class="day-number">30</span></div>
                <div class="cal-day"><span class="day-number inactive">1</span></div>
                <div class="cal-day"><span class="day-number inactive">2</span></div>
                <div class="cal-day"><span class="day-number inactive">3</span></div>
                <div class="cal-day"><span class="day-number inactive">4</span></div>
                <div class="cal-day"><span class="day-number inactive">5</span></div>

            </div>
        </div>

    </main>
    <div id="addEventModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" id="closeEventModal">&times;</span>

            <h2>ADD NEW EVENT</h2>

            <form class="add-car-form" action="add_services.php" method="POST">

                <h3 class="section-title">Event type</h3>
                <div class="event-type-options">
                    <button type="button" class="event-type-btn active">Service</button>
                    <button type="button" class="event-type-btn">Legal(ITP/RCA)</button>
                    <button type="button" class="event-type-btn">Other</button>
                </div>

                <h3 class="section-title">Select vehicle</h3>
                <div class="input-group full-width">
                    <select name="car_id">
                    <?php while($car = mysqli_fetch_assoc($result_cars)){ ?>
                        <option value="<?php echo $car['id']; ?>">
                            <?php echo $car['license_plate']." - ".$car['brand']." ".$car['model']; ?>
                        </option>
                    <?php } ?>
                    </select>
                </div>

                <h3 class="section-title">Start date</h3>
                <div class="form-grid">
                    <div class="input-group">
                        <input type="date" name="appointment_date">
                    </div>
                    <div class="input-group">
                        <input type="text" name="estimated_cost" placeholder="e.g. 500 RON">
                    </div>
                </div>

                <h3 class="section-title">Description/Notes</h3>
                <div class="input-group full-width">
                    <textarea name="description" rows="3"></textarea>
                </div>
                <input type="hidden" name="service_center" value="Calendar">
                <input type="hidden" name="intervention_type" value="other">
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelEvent">Cancel</button>
                    <button type="submit" class="btn-submit">Create event</button>
                </div>

            </form>
        </div>
    </div>

    <div id="editEventModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" id="closeEditEventModal">&times;</span>

            <h2>EDIT EVENT</h2>

            <form class="add-car-form">
                <h3 class="section-title">Event Details</h3>
                <div class="input-group full-width" style="margin-bottom: 15px;">
                    <label>Event Title</label>
                    <input type="text" value="ITP (Autoservice)">
                </div>
                
                <div class="form-grid">
                    <div class="input-group">
                        <label>Vehicle</label>
                        <select>
                            <option>SB 81 NQL - Dacia Logan</option>
                            <option selected>SB 23 ALX - Ford Focus</option>
                            <option>SB 42 BDP - Dacia Jogger</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Date</label>
                        <input type="date" value="2026-06-11">
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelEditEvent">Cancel</button>
                    <button type="submit" class="btn-submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 420px; text-align: center;">
            <span class="close-modal" id="closeDeleteModal">&times;</span>

            <h2 style="color: var(--status-red); margin-bottom: 15px;">DELETE EVENT</h2>
            
            <p style="font-family: sans-serif; font-size: 15px; color: var(--text-gray-medium); margin-bottom: 30px; line-height: 1.5;">
                Are you sure you want to delete this event from the calendar? <br>
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

           
            const profileTrigger = document.getElementById('profileTrigger');
            const profileMenu = document.getElementById('profileMenu');
            
            if (profileTrigger && profileMenu) {
                profileTrigger.addEventListener('click', function(event) {
                    profileMenu.classList.toggle('show');
                    event.stopPropagation(); 
                });
                document.addEventListener('click', function(event) {
                    if (!profileMenu.contains(event.target) && !profileTrigger.contains(event.target)) {
                        profileMenu.classList.remove('show');
                    }
                });
            }

          
            const typeButtons = document.querySelectorAll('.event-type-btn');
            typeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    typeButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

          
            const eventModal = document.getElementById("addEventModal");
            const btnOpenEvent = document.getElementById("btnOpenEventModal");
            const btnCloseEvent = document.getElementById("closeEventModal");
            const btnCancelEvent = document.getElementById("btnCancelEvent");

            const editEventModal = document.getElementById("editEventModal");
            const closeEditEvent = document.getElementById("closeEditEventModal");
            const cancelEditEvent = document.getElementById("btnCancelEditEvent");

            const deleteModal = document.getElementById("deleteModal");
            const closeDelete = document.getElementById("closeDeleteModal");
            const cancelDelete = document.getElementById("btnCancelDelete");
            const confirmDelete = document.getElementById("btnConfirmDelete");

           
            if (btnOpenEvent) btnOpenEvent.onclick = () => eventModal.style.display = "flex";
            
           
            const editIcons = document.querySelectorAll('.edit-icon');
            editIcons.forEach(icon => {
                icon.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (editEventModal) editEventModal.style.display = "flex";
                });
            });

          
            const deleteIcons = document.querySelectorAll('.delete-icon');
            deleteIcons.forEach(icon => {
                icon.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (deleteModal) deleteModal.style.display = "flex";
                });
            });

           
            if (btnCloseEvent) btnCloseEvent.onclick = () => eventModal.style.display = "none";
            if (btnCancelEvent) btnCancelEvent.onclick = () => eventModal.style.display = "none";

            if (closeEditEvent) closeEditEvent.onclick = () => editEventModal.style.display = "none";
            if (cancelEditEvent) cancelEditEvent.onclick = () => editEventModal.style.display = "none";

            if (closeDelete) closeDelete.onclick = () => deleteModal.style.display = "none";
            if (cancelDelete) cancelDelete.onclick = () => deleteModal.style.display = "none";

            if (confirmDelete) {
                confirmDelete.onclick = () => deleteModal.style.display = "none";
            }

            window.onclick = (event) => {
                if (event.target == eventModal) eventModal.style.display = "none";
                if (event.target == editEventModal) editEventModal.style.display = "none";
                if (event.target == deleteModal) deleteModal.style.display = "none";
            };

           
            const calEvents = document.querySelectorAll('.cal-event');
            calEvents.forEach(evt => {
                evt.addEventListener('click', function(e) {
                    if (e.target.closest('.action-icon')) return;
                    calEvents.forEach(otherEvt => {
                        if (otherEvt !== this) {
                            otherEvt.classList.remove('show-actions');
                        }
                    });
                    this.classList.toggle('show-actions');
                });
            });

        });
    </script>
</body>

</html>