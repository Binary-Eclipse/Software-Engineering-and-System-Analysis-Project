<?php
include_once "config.php";

// --- HANDLE DELETE ---
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM abuse_reports WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // refresh after deletion
    exit;
}

// --- HANDLE EDIT ---
if (isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $stmt = $conn->prepare("UPDATE abuse_reports SET date_incident=?, type_incident=?, incident_address=?, city=?, state=?, zip_code=?, detailed_description=?, reporter_name=?, reporter_email=? WHERE id=?");
    $stmt->bind_param(
        "sssssssssi",
        $_POST['date_incident'],
        $_POST['type_incident'],
        $_POST['incident_address'],
        $_POST['city'],
        $_POST['state'],
        $_POST['zip_code'],
        $_POST['detailed_description'],
        $_POST['reporter_name'],
        $_POST['reporter_email'],
        $id
    );
    $stmt->execute();
    $stmt->close();
    exit("updated");
}

// --- FETCH ALL DATA ---
$result = $conn->query("SELECT * FROM abuse_reports ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Abuse Reports Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Table container */
.overflow-x-auto {
    overflow-x: auto;
    width: 100%;
    margin-top: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 0.5rem;
    font-family: 'Inter', sans-serif;
}

thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    color: #6b7280;
    padding: 0.75rem 1rem;
    text-align: left;
    background-color: #f9fafb;
    border-radius: 0.5rem;
}

tbody td {
    padding: 0.75rem 1rem;
    color: #374151;
    vertical-align: middle;
    font-size: 0.875rem;
    background-color: #f9fafb;
    border-radius: 0.5rem;
    transition: transform 0.15s, background 0.2s;
}

tbody tr:hover td {
    background-color: #e5e7eb;
    transform: translateY(-2px);
}

/* Buttons */
.btn {
    font-size: 0.875rem;
    padding: 0.4rem 0.85rem;
    border-radius: 0.5rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    transition: all 0.2s;
    cursor: pointer;
    text-decoration: none;
    border: none;
    color: white;
}

.btn-edit {
    background-color: #3b82f6;
    box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
}

.btn-edit:hover {
    background-color: #2563eb;
    transform: translateY(-1px);
}

.btn-delete {
    background-color: #ef4444;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
}

.btn-delete:hover {
    background-color: #b91c1c;
    transform: translateY(-1px);
}

/* Modal backdrop */
#editModal {
    display: none;
    background-color: rgba(0,0,0,0.5);
    position: fixed;
    inset: 0;
    z-index: 50;
    align-items: center;
    justify-content: center;
}

/* Modal content */
#editModal .modal-content {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    width: 100%;
    max-width: 28rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* Form inputs */
#editForm input, #editForm textarea, #editForm select {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.5rem;
    width: 100%;
    font-size: 0.875rem;
    color: #111827;
    margin-bottom: 0.5rem;
    transition: border 0.2s, box-shadow 0.2s;
}

#editForm input:focus, #editForm textarea:focus, #editForm select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

/* Modal buttons */
#editForm button {
    font-weight: 600;
    border-radius: 0.375rem;
    padding: 0.5rem 1rem;
}

#editForm button.bg-gray-500 {
    background-color: #6b7280;
}

#editForm button.bg-gray-500:hover {
    background-color: #4b5563;
}

#editForm button.bg-blue-600 {
    background-color: #2563eb;
}

#editForm button.bg-blue-600:hover {
    background-color: #1e40af;
}

/* Responsive table */
@media (max-width: 768px) {
    thead { display: none; }
    tbody td {
        display: block;
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 0.5rem;
        font-weight: 600;
        text-align: left;
        color: #6b7280;
    }
}
</style>
</head>
<body>
<h2>Abuse Reports Dashboard</h2>

<div class="overflow-x-auto">
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Date</th><th>Type</th><th>Address</th><th>City</th><th>State</th><th>ZIP</th>
                <th>Submitted At</th><th>Description</th><th>Reporter Name</th><th>Reporter Email</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td data-label="ID"><?= $row['id'] ?></td>
                <td data-label="Date"><?= htmlspecialchars($row['date_incident']) ?></td>
                <td data-label="Type"><?= htmlspecialchars($row['type_incident']) ?></td>
                <td data-label="Address"><?= htmlspecialchars($row['incident_address']) ?></td>
                <td data-label="City"><?= htmlspecialchars($row['city']) ?></td>
                <td data-label="State"><?= htmlspecialchars($row['state']) ?></td>
                <td data-label="ZIP"><?= htmlspecialchars($row['zip_code']) ?></td>
                <td data-label="Submitted At"><?= htmlspecialchars($row['submitted_at']) ?></td>
                <td data-label="Description"><?= htmlspecialchars($row['detailed_description']) ?></td>
                <td data-label="Reporter Name"><?= htmlspecialchars($row['reporter_name']) ?></td>
                <td data-label="Reporter Email"><?= htmlspecialchars($row['reporter_email']) ?></td>
                <td data-label="Actions">
                    <button class="btn btn-edit" onclick="openEditModal(<?= $row['id'] ?>, '<?= htmlspecialchars(addslashes($row['date_incident'])) ?>', '<?= htmlspecialchars(addslashes($row['type_incident'])) ?>', '<?= htmlspecialchars(addslashes($row['incident_address'])) ?>', '<?= htmlspecialchars(addslashes($row['city'])) ?>', '<?= htmlspecialchars(addslashes($row['state'])) ?>', '<?= htmlspecialchars(addslashes($row['zip_code'])) ?>', `<?= htmlspecialchars(addslashes($row['detailed_description'])) ?>`, '<?= htmlspecialchars(addslashes($row['reporter_name'])) ?>', '<?= htmlspecialchars(addslashes($row['reporter_email'])) ?>')"><i class="fas fa-edit"></i></button>
                    <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- EDIT MODAL -->
<div id="editModal">
    <div class="modal-content">
        <h2 class="text-xl font-bold mb-4">Edit Abuse Report</h2>
        <form id="editForm" method="POST">
            <input type="hidden" id="edit_id" name="edit_id">
            <label>Date of Incident</label>
            <input type="date" id="date_incident" name="date_incident" required>
            <label>Type of Incident</label>
            <select id="type_incident" name="type_incident" required>
                <option value="Neglect">Neglect</option>
                <option value="Physical Harm">Physical Harm</option>
                <option value="Abandonment">Abandonment</option>
                <option value="Other">Other</option>
            </select>
            <label>Address</label>
            <input type="text" id="incident_address" name="incident_address" required>
            <label>City</label>
            <input type="text" id="city" name="city" required>
            <label>State</label>
            <input type="text" id="state" name="state" required>
            <label>ZIP</label>
            <input type="text" id="zip_code" name="zip_code" required>
            <label>Description</label>
            <textarea id="detailed_description" name="detailed_description" required></textarea>
            <label>Reporter Name</label>
            <input type="text" id="reporter_name" name="reporter_name">
            <label>Reporter Email</label>
            <input type="email" id="reporter_email" name="reporter_email">
            <div style="display:flex; justify-content:flex-end; gap:0.5rem; margin-top:0.5rem;">
                <button type="button" class="bg-gray-500" onclick="closeModal()">Cancel</button>
                <button type="submit" class="bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
// Open modal with prefilled data
function openEditModal(id, date, type, address, city, state, zip, desc, name, email){
    document.getElementById('edit_id').value = id;
    document.getElementById('date_incident').value = date;
    document.getElementById('type_incident').value = type;
    document.getElementById('incident_address').value = address;
    document.getElementById('city').value = city;
    document.getElementById('state').value = state;
    document.getElementById('zip_code').value = zip;
    document.getElementById('detailed_description').value = desc;
    document.getElementById('reporter_name').value = name;
    document.getElementById('reporter_email').value = email;
    document.getElementById('editModal').style.display = 'flex';
}

// Close modal
function closeModal(){
    document.getElementById('editModal').style.display = 'none';
}

// AJAX submit edit form
document.getElementById('editForm').addEventListener('submit', function(e){
    e.preventDefault();
    var formData = new FormData(this);
    fetch("", {method:"POST", body:formData})
    .then(r=>r.text())
    .then(res=>{
        if(res.trim() === "updated"){
            alert("Updated successfully!");
            location.reload();
        }
    });
});
</script>
</body>
</html>
