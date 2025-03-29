<?php
include('db.php');

// Get the image ID from the URL
if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    // Get the image name from the database
    $sql = "SELECT image_name FROM images WHERE id = $imageId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imageName = $row['image_name'];

        // Delete the image from the uploads folder
        $filePath = "uploads/" . $imageName;
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the image file
        }

        // Delete the image record from the database
        $sqlDelete = "DELETE FROM images WHERE id = $imageId";
        if ($conn->query($sqlDelete) === TRUE) {
            echo "Image deleted successfully!";
            header("Location: index.php"); // Redirect back to the gallery
        } else {
            echo "Error deleting image: " . $conn->error;
        }
    } else {
        echo "Image not found!";
    }
}
?>
