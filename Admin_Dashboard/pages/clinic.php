<?php
include 'config.php';

// --- Handle Accept action via AJAX ---
if(isset($_POST['accept_id'])){
    $id = intval($_POST['accept_id']);
    $stmt = $conn->prepare("UPDATE doctor_appointments SET status='Accepted' WHERE appointment_id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message'=>'DB update failed']);
    }
    exit;
}

// --- Handle Cancel action via AJAX ---
if(isset($_POST['cancel_id'])){
    $id = intval($_POST['cancel_id']);
    $stmt = $conn->prepare("UPDATE doctor_appointments SET status='Cancelled' WHERE appointment_id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false,'message'=>'DB update failed']);
    }
    exit;
}

// --- Fetch appointments ---
$sql = "SELECT * FROM doctor_appointments ORDER BY appointment_id DESC";
$result = $conn->query($sql);
?>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<h2 class="text-2xl font-bold mb-4">Clinic Appointments</h2>

<table class="nice-table w-full">
    <thead>
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Specialty</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
            <th>Contact</th>
            <th>Email</th>
            <th>NID</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()){ ?>
            <tr id="row-<?= $row['appointment_id'] ?>" 
                class="<?= $row['status']=='Accepted' ? 'bg-green-100' : ($row['status']=='Cancelled' ? 'bg-red-100' : '') ?>">
                <td><?= $row['appointment_id'] ?></td>
                <td><?= $row['patient_name'] ?></td>
                <td><?= $row['doctor_name'] ?></td>
                <td><?= $row['doctor_specialty'] ?></td>
                <td><?= $row['appointment_date'] ?></td>
                <td><?= $row['appointment_time'] ?></td>
                <td><?= $row['reason_for_visit'] ?></td>
                <td><?= $row['contact_number'] ?></td>
                <td><?= $row['owner_email'] ?></td>
                <td><?= $row['owner_nid'] ?></td>
                <td class="status-cell"><?= $row['status'] ?></td>
                <td class="flex space-x-2">
                    <button type="button" 
                            class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 accept-btn"
                            data-appointment-id="<?= $row['appointment_id'] ?>"
                            <?= $row['status']=='Accepted' ? 'disabled' : '' ?>>
                        Accept
                    </button>
                    <button type="button" 
                            class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 cancel-btn"
                            data-appointment-id="<?= $row['appointment_id'] ?>"
                            <?= $row['status']=='Cancelled' ? 'disabled' : '' ?>>
                        Cancel
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
// --- Accept button ---
document.querySelectorAll('.accept-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const appointmentId = this.dataset.appointmentId;
        const row = document.getElementById('row-' + appointmentId);
        const statusCell = row.querySelector('.status-cell');

        fetch('', { // same file
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'accept_id=' + appointmentId
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                row.classList.remove('bg-red-100');
                row.classList.add('bg-green-100');
                statusCell.innerText = 'Accepted';
                this.disabled = true;

                const cancelBtn = row.querySelector('.cancel-btn');
                if(cancelBtn) cancelBtn.disabled = false;
            }
        });
    });
});

// --- Cancel button ---
document.querySelectorAll('.cancel-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        const appointmentId = this.dataset.appointmentId;
        const row = document.getElementById('row-' + appointmentId);
        const statusCell = row.querySelector('.status-cell');

        if(!confirm('Are you sure you want to cancel this appointment?')) return;

        fetch('', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'cancel_id=' + appointmentId
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                row.classList.remove('bg-green-100');
                row.classList.add('bg-red-100');
                statusCell.innerText = 'Cancelled';
                btn.disabled = true;

                const acceptBtn = row.querySelector('.accept-btn');
                if(acceptBtn) acceptBtn.disabled = false;
            }
        });
    });
});
</script>
