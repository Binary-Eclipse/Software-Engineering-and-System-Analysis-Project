<?php
include 'config.php';

// DELETE request
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);

    // Delete image file if exists
    $imgQuery = $conn->query("SELECT image FROM rescue_reports WHERE id=$id");
    if ($imgQuery && $imgRow = $imgQuery->fetch_assoc()) {
        if ($imgRow['image'] && file_exists($imgRow['image'])) {
            unlink($imgRow['image']);
        }
    }

    $conn->query("DELETE FROM rescue_reports WHERE id=$id");
    exit("deleted");
}

// UPDATE request
if (isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $stmt = $conn->prepare("UPDATE rescue_reports SET name=?, email=?, animal_type=?, location=?, description=? WHERE id=?");
    $stmt->bind_param("sssssi", $_POST['edit_name'], $_POST['edit_email'], $_POST['edit_animal'], $_POST['edit_location'], $_POST['edit_description'], $id);
    $stmt->execute();
    exit("updated");
}

// FETCH DATA
$result = $conn->query("SELECT * FROM rescue_reports ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rescue Reports Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ===== Table container ===== */
.overflow-x-auto {
    overflow-x: auto;
    width: 100%;
    margin-top: 20px;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    background-color: #ffffff;
}

/* ===== Table styling ===== */
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

/* ===== Buttons ===== */
button, a.btn {
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
}

/* Edit button */
button.bg-blue-500 {
    background-color: #3b82f6;
    color: white;
    box-shadow: 0 2px 6px rgba(59,130,246,0.3);
}
button.bg-blue-500:hover {
    background-color: #2563eb;
    transform: translateY(-1px);
}

/* Delete button */
button.bg-red-500 {
    background-color: #ef4444;
    color: white;
}
button.bg-red-500:hover {
    background-color: #b91c1c;
    transform: translateY(-1px);
}

/* ===== Modal ===== */
#editModal {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
    z-index: 50;
}

#editModal .modal-content {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    width: 100%;
    max-width: 28rem;
    box-shadow: 0 12px 28px rgba(0,0,0,0.25);
}

/* Form inputs */
#editForm input, #editForm textarea {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.6rem 0.8rem;
    width: 100%;
    font-size: 0.875rem;
    color: #111827;
    margin-bottom: 0.75rem;
    transition: border 0.2s, box-shadow 0.2s, transform 0.2s;
}
#editForm input:focus, #editForm textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    transform: translateY(-1px);
}

/* Modal buttons */
#editForm button {
    font-weight: 600;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    transition: all 0.2s;
}
#editForm button.bg-gray-500 {
    background-color: #6b7280;
}
#editForm button.bg-gray-500:hover { background-color:#4b5563; transform:translateY(-1px);}
#editForm button.bg-blue-600 {
    background-color: #2563eb;
}
#editForm button.bg-blue-600:hover { background-color:#1e40af; transform:translateY(-1px); }

/* Image styling */
img { border-radius: 0.5rem; object-fit: cover; border: 1px solid #e5e7eb; }

/* ===== Responsive ===== */
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

<h2>Rescue Reports Dashboard</h2>

<div class="overflow-x-auto">
<table>
<thead>
<tr>
<th>ID</th><th>Name</th><th>Email</th><th>Animal Type</th><th>Location</th><th>Description</th><th>Image</th><th>Created At</th><th>Actions</th>
</tr>
</thead>
<tbody>
<?php
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $mapLink = $row['location'] ? "<a href='{$row['location']}' target='_blank' class='text-blue-500 hover:underline'>View Map</a>" : "N/A";
        $image = $row['image'] ? "<img src='{$row['image']}' class='w-12 h-12'>" : "<span class='text-gray-400'>NULL</span>";

        echo "<tr>
            <td data-label='ID'>{$row['id']}</td>
            <td data-label='Name'>{$row['name']}</td>
            <td data-label='Email'>{$row['email']}</td>
            <td data-label='Animal Type'>{$row['animal_type']}</td>
            <td data-label='Location'>{$mapLink}</td>
            <td data-label='Description'>{$row['description']}</td>
            <td data-label='Image'>{$image}</td>
            <td data-label='Created At'>{$row['created_at']}</td>
            <td data-label='Actions'>
                <button class='bg-blue-500' onclick=\"openEditModal('{$row['id']}','{$row['name']}','{$row['email']}','{$row['animal_type']}','{$row['location']}','`{$row['description']}`')\"><i class='fas fa-edit'></i></button>
                <button class='bg-red-500' onclick='deleteReport({$row['id']})'><i class='fas fa-trash'></i></button>
            </td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='9' class='text-center text-gray-500'>No reports found</td></tr>";
}
?>
</tbody>
</table>
</div>

<!-- EDIT MODAL -->
<div id="editModal">
<div class="modal-content">
<h2 class="text-xl font-bold mb-4">Edit Report</h2>
<form id="editForm">
<input type="hidden" id="update_id" name="update_id">
<label>Name</label>
<input type="text" id="edit_name" name="edit_name">
<label>Email</label>
<input type="text" id="edit_email" name="edit_email">
<label>Animal Type</label>
<input type="text" id="edit_animal" name="edit_animal">
<label>Location URL</label>
<input type="text" id="edit_location" name="edit_location">
<label>Description</label>
<textarea id="edit_description" name="edit_description"></textarea>
<div style="display:flex;justify-content:flex-end;gap:0.5rem;margin-top:0.5rem;">
<button type="button" class="bg-gray-500" onclick="closeModal()">Cancel</button>
<button type="button" class="bg-blue-600" onclick="saveEdit()">Save</button>
</div>
</form>
</div>
</div>

<script>
// Delete
function deleteReport(id){
    if(!confirm('Delete this report?')) return;
    let form = new FormData();
    form.append('delete_id',id);
    fetch('',{method:'POST',body:form}).then(r=>r.text()).then(res=>{
        if(res.trim()==='deleted'){ alert('Deleted successfully'); location.reload();}
    });
}

// Edit Modal
function openEditModal(id,name,email,animal,location,description){
    document.getElementById('update_id').value=id;
    document.getElementById('edit_name').value=name;
    document.getElementById('edit_email').value=email;
    document.getElementById('edit_animal').value=animal;
    document.getElementById('edit_location').value=location;
    document.getElementById('edit_description').value=description;
    document.getElementById('editModal').style.display='flex';
}
function closeModal(){ document.getElementById('editModal').style.display='none'; }

// Save Edit
function saveEdit(){
    let form = new FormData(document.getElementById('editForm'));
    fetch('',{method:'POST',body:form}).then(r=>r.text()).then(res=>{
        if(res.trim()==='updated'){ alert('Updated successfully'); location.reload();}
    });
}
</script>

</body>
</html>
