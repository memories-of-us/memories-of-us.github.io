<?php
include('db.php');
include('navbar.php'); // Include the navbar on this page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Couples Image Gallery</title>
    <style>
        /* Add your gallery styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            margin-top: 20px;
        }

        #gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .image-container {
            position: relative;
            margin: 15px;
            border: 1px solid #444;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .image-container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .image-container:hover {
            transform: scale(1.05);
        }

        .image-container .info {
            display: none;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 10px;
            text-align: center;
        }

        .image-container .delete-btn, .image-container .download-btn {
            background-color: #e74c3c;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            text-decoration: none;
            color: white;
        }

        .image-container .download-btn {
            background-color: #3498db;
        }

        .image-container:hover .info {
            display: block;
        }

        /* Fullscreen Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .modal img {
            max-width: 90%;
            max-height: 90%;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .download-btn-fullscreen {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #3498db;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

    </style>
</head>
<body>

    <h1>Couples Image Gallery</h1>
    <h2>Uploaded Images</h2>
    <div id="gallery">
        <?php
        // Fetch images from the database
        $sql = "SELECT * FROM images ORDER BY upload_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="image-container">
                        <img src="uploads/' . $row['image_name'] . '" alt="Uploaded Image" onclick="openModal(\'uploads/' . $row['image_name'] . '\', \'' . $row['image_name'] . '\')">
                        <div class="info">
                            Date: ' . $row['upload_date'] . '
                            <a href="uploads/' . $row['image_name'] . '" download class="download-btn">Download</a>
                            <span class="delete-btn" onclick="deleteImage(' . $row['id'] . ')">Delete</span>
                        </div>
                      </div>';
            }
        } else {
            echo "No images uploaded yet!";
        }
        ?>
    </div>

    <!-- Fullscreen Modal -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeModal()">×</span>
        <img id="modalImage" src="" alt="Fullscreen Image">
        <a id="fullscreenDownloadBtn" href="#" download class="download-btn-fullscreen">Download</a>
    </div>

    <script>
        function deleteImage(imageId) {
            if (confirm("Are you sure you want to delete this image?")) {
                window.location.href = 'delete.php?id=' + imageId;
            }
        }

        // Open Modal with clicked image
        function openModal(imageSrc, imageName) {
            var modal = document.getElementById("imageModal");
            var modalImage = document.getElementById("modalImage");
            var downloadBtn = document.getElementById("fullscreenDownloadBtn");

            modal.style.display = "flex";
            modalImage.src = imageSrc;

            // Set the download link to the image file
            downloadBtn.href = imageSrc;
        }

        // Close the modal
        function closeModal() {
            var modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }

        // Close modal if clicked outside of the image
        window.onclick = function(event) {
            var modal = document.getElementById("imageModal");
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>

</body>
</html>
