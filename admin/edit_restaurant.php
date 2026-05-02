<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    echo "unauthorized";
    exit();
}

$id = $_GET['id'];

// AJAX UPDATE
if(isset($_POST['ajax_update'])){

    $name        = $_POST['name'];
    $description = $_POST['description'];
    $category    = $_POST['category'];
    $open_time   = $_POST['open_time'];
    $close_time  = $_POST['close_time'];
    $address     = $_POST['address'];
    $phone       = $_POST['phone'];

    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin_restaurants WHERE hotel_id=$id"));

    // IMAGE
    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $tmp   = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "uploads/".$image);

        if(file_exists("uploads/".$data['image'])){
            unlink("uploads/".$data['image']);
        }

        $imgQuery = ", image='$image'";
    } else {
        $imgQuery = "";
    }

    mysqli_query($conn, "UPDATE admin_restaurants SET
        name='$name',
        description='$description',
        category='$category',
        open_time='$open_time',
        close_time='$close_time',
        address='$address',
        phone='$phone'
        $imgQuery
        WHERE hotel_id=$id
    ");

    echo "success";
    exit();
}

// FETCH
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin_restaurants WHERE hotel_id=$id"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Restaurant</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <?php include("sidebar.php"); ?>

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- MAIN CONTENT -->
    <div id="mainContent" class="flex-1 flex flex-col transition-all duration-300 md:ml-64">

        <!-- NAVBAR -->
        <?php include("navbar.php"); ?>

        <!-- PAGE -->
        <main class="p-6 overflow-y-auto flex justify-center">

            <div class="bg-white p-6 rounded-xl shadow w-full max-w-lg">

                <h2 class="text-xl font-bold mb-2 text-center">✏️ Edit Restaurant</h2>

                <!-- BACK -->
                <a href="add_hotel.php"
                class="inline-block mb-4 px-4 py-2 text-sm bg-gray-200 rounded-lg hover:bg-gray-300">
                ← Back
                </a>

                <form id="editForm" enctype="multipart/form-data" class="space-y-3">

                    <input type="text" name="name"
                    value="<?php echo $data['name']; ?>"
                    class="w-full border p-2 rounded">

                    <textarea name="description"
                    class="w-full border p-2 rounded"><?php echo $data['description']; ?></textarea>

                    <select name="category" class="w-full border p-2 rounded">
                        <option><?php echo $data['category']; ?></option>
                        <option value="veg">Veg</option>
                        <option value="nonveg">Non-Veg</option>
                        <option value="both">Both</option>
                    </select>

                    <input type="text" name="open_time"
                    value="<?php echo $data['open_time']; ?>"
                    class="w-full border p-2 rounded">

                    <input type="text" name="close_time"
                    value="<?php echo $data['close_time']; ?>"
                    class="w-full border p-2 rounded">

                    <textarea name="address"
                    class="w-full border p-2 rounded"><?php echo $data['address']; ?></textarea>

                    <input type="text" name="phone"
                    value="<?php echo $data['phone']; ?>"
                    class="w-full border p-2 rounded">

                    <!-- IMAGE -->
                    <img src="uploads/<?php echo $data['image']; ?>"
                    onerror="this.src='https://via.placeholder.com/150'"
                    class="w-full h-32 object-cover rounded">

                    <input type="file" name="image"
                    class="w-full border p-2 rounded">

                    <button type="submit"
                    class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
                    Update Restaurant
                    </button>

                </form>

            </div>

        </main>

    </div>
</div>

<!-- TOAST -->
<div id="toast"
class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded shadow hidden">
Updated Successfully ✅
</div>

<!-- AJAX -->
<script>
document.getElementById("editForm").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);
    formData.append("ajax_update", true);

    fetch("", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "success"){
            let toast = document.getElementById("toast");
            toast.classList.remove("hidden");

            setTimeout(() => {
                toast.classList.add("hidden");
            }, 3000);
        }
    });
});
</script>

<!-- COMMON JS -->
<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>