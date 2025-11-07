<?php
include 'config.php';

$sql = "SELECT * FROM rescue_reports ORDER BY id DESC";
$result = $conn->query($sql);
?>

<div class="overflow-x-auto shadow-md sm:rounded-lg">
    <table class="min-w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th scope="col" class="px-4 py-3">ID</th>
                <th scope="col" class="px-4 py-3">Name</th>
                <th scope="col" class="px-4 py-3">Email</th>
                <th scope="col" class="px-4 py-3">Animal Type</th>
                <th scope="col" class="px-4 py-3">Location</th>
                <th scope="col" class="px-4 py-3">Description</th>
                <th scope="col" class="px-4 py-3">Image</th>
                <th scope="col" class="px-4 py-3">Created At</th>
                <th scope="col" class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $mapLink = $row['location'] ? "<a href='http://maps.google.com/?q={$row['location']}' target='_blank' class='text-blue-500 hover:underline'>View Map</a>" : "N/A";
                $image = $row['image'] ? "<img src='{$row['image']}' alt='Pet Image' class='w-12 h-12 object-cover rounded'>" : "<span class='text-gray-400'>NULL</span>";

                echo "<tr class='hover:bg-gray-50'>
                        <td class='px-4 py-3'>{$row['id']}</td>
                        <td class='px-4 py-3'>{$row['name']}</td>
                        <td class='px-4 py-3'>{$row['email']}</td>
                        <td class='px-4 py-3' data-field='animalType'>{$row['animal_type']}</td>
                        <td class='px-4 py-3' data-field='location'>{$mapLink}</td>
                        <td class='px-4 py-3'>{$row['description']}</td>
                        <td class='px-4 py-3'>{$image}</td>
                        <td class='px-4 py-3'>{$row['created_at']}</td>
                        <td class='px-4 py-3 space-x-2'>
                            <button class='px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600'><i class='fas fa-edit'></i></button>
                            <button class='px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600'><i class='fas fa-copy'></i></button>
                            <button class='px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600'><i class='fas fa-trash-alt'></i></button>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='px-4 py-4 text-center text-gray-500'>No reports found</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>
