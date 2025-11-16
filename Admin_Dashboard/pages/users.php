<?php
include 'config.php';

// DELETE request
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM users WHERE id=$id");
    exit("deleted");
}

// FETCH DATA
$result = $conn->query("SELECT * FROM users ORDER BY registration_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Users Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Table container */
.overflow-x-auto {
    overflow-x: auto;
    width: 100%;
    margin-top: 20px;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    background-color: #ffffff;
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
button.btn-edit {
    background-color: #3b82f6;
    color: white;
}
button.btn-edit:hover { background-color: #2563eb; transform: translateY(-1px); }

/* Copy button */
button.btn-copy {
    background-color: #10b981;
    color: white;
}
button.btn-copy:hover { background-color: #059669; transform: translateY(-1px); }

/* Delete button */
button.btn-delete {
    background-color: #ef4444;
    color: white;
}
button.btn-delete:hover { background-color: #b91c1c; transform: translateY(-1px); }

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

<h2>Users Dashboard</h2>

<div class="overflow-x-auto">
<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Contact Number</th>
<th>Password</th>
<th>Registration Date</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
            <td data-label='ID'>{$row['id']}</td>
            <td data-label='Name'>{$row['name']}</td>
            <td data-label='Email'>{$row['email']}</td>
            <td data-label='Contact Number'>{$row['contact_number']}</td>
            <td data-label='Password'>{$row['password']}</td>
            <td data-label='Registration Date'>{$row['registration_date']}</td>
            <td data-label='Actions'>
                <button class='btn-edit'><i class='fas fa-edit'></i> Edit</button>
                <button class='btn-copy' onclick=\"navigator.clipboard.writeText('{$row['email']}')\"><i class='fas fa-copy'></i> Copy</button>
                <button class='btn-delete' onclick='deleteUser({$row['id']})'><i class='fas fa-trash'></i> Delete</button>
            </td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='7' class='text-center text-gray-500'>No users found</td></tr>";
}
?>
</tbody>
</table>
</div>

<script>
// Delete
function deleteUser(id){
    if(!confirm('Are you sure you want to delete this user?')) return;
    let form = new FormData();
    form.append('delete_id',id);
    fetch('',{method:'POST',body:form}).then(r=>r.text()).then(res=>{
        if(res.trim()==='deleted'){ alert('Deleted successfully'); location.reload(); }
    });
}
</script>

</body>
</html>
