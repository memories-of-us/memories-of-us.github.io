<?php
include('db.php');
include('navbar.php'); // Include the navbar on this page

// Upload directory
$targetDir = "uploads/";

// Create the uploads directory if it doesn't exist
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Check if the form is submitted
if (isset($_POST['upload'])) {
    $image = $_FILES['image'];
    $imageName = basename($image['name']);
    $targetFile = $targetDir . $imageName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Get current date and time
        $uploadDate = date("Y-m-d H:i:s");

        // Insert image details into the database
        $sql = "INSERT INTO images (image_name, upload_date) VALUES ('$imageName', '$uploadDate')";
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded and stored successfully!";
            header("Location: index.php"); // Redirect back to the gallery
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <style>
        /* Add your styling here for the upload page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            color: #555;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        input[type="file"] {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        button {
            padding: 12px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

    <h1>Upload New Image</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="upload">Upload</button>
    </form>

</body>
</html>
