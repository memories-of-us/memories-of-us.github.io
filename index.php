<?php
include('db.php');
include('navbar.php'); // Include the navbar on this page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>❤️ Love Gallery ❤️</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100%;
        }

        .container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            margin-top: 20px;
            font-family: 'Dancing Script', cursive;
            color: #ff4d6d;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            position: relative;
            width: 100%;
        }

        h1 {
            font-size: 3.5em;
            margin-bottom: 20px;
        }

        h1::before, h1::after {
            content: '❤️';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            animation: heartbeat 1.5s infinite;
        }

        h1::before {
            left: 20px;
        }

        h1::after {
            right: 20px;
        }

        @keyframes heartbeat {
            0% { transform: translateY(-50%) scale(1); }
            50% { transform: translateY(-50%) scale(1.2); }
            100% { transform: translateY(-50%) scale(1); }
        }

        #gallery {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 20px 0;
            padding: 0 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 80%;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .image-container:nth-child(odd) {
            margin-left: auto;
            margin-right: 10%;
            border-bottom-right-radius: 5px;
        }

        .image-container:nth-child(even) {
            margin-left: 10%;
            margin-right: auto;
            border-bottom-left-radius: 5px;
        }

        .image-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
            display: block;
        }

        .image-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .image-container:hover img {
            transform: scale(1.02);
        }

        .image-container .info {
            display: none;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(255,77,109,0.95));
            padding: 15px;
            text-align: center;
            color: white;
            backdrop-filter: blur(5px);
        }

        .image-container .delete-btn, .image-container .download-btn {
            background-color: #ff4d6d;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 20px;
            margin: 5px;
            text-decoration: none;
            color: white;
            border: none;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 0.9em;
        }

        .image-container .download-btn {
            background-color: #ff8fab;
        }

        .image-container .delete-btn:hover, .image-container .download-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .image-container:hover .info {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
            background: rgba(255, 255, 255, 0.95);
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(255,77,109,0.2);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #ff4d6d;
            font-size: 40px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .modal-close:hover {
            transform: rotate(90deg);
        }

        .download-btn-fullscreen {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(45deg, #ff4d6d, #ff8fab);
            padding: 12px 25px;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255,77,109,0.2);
        }

        .download-btn-fullscreen:hover {
            transform: translateX(-50%) scale(1.05);
            box-shadow: 0 6px 20px rgba(255,77,109,0.3);
        }

        /* Floating hearts animation */
        .floating-heart {
            position: fixed;
            font-size: 20px;
            animation: float 6s linear infinite;
            z-index: -1;
            opacity: 0.3;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) translateX(0);
                opacity: 0;
            }
            50% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        /* Pull to refresh indicator */
        .pull-refresh {
            text-align: center;
            padding: 20px;
            color: #ff4d6d;
            font-size: 0.9em;
            display: none;
        }

        .pull-refresh.visible {
            display: block;
        }

        @media (min-width: 768px) {
            #gallery {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }

            .image-container {
                width: 300px;
                margin: 0;
                border-radius: 12px;
            }

            .image-container:nth-child(odd),
            .image-container:nth-child(even) {
                margin: 0;
                border-radius: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>❤️ Love Gallery ❤️</h1>
        <h2>Our Precious Moments</h2>
        <div class="pull-refresh">Pull down to refresh...</div>
        <div id="gallery">
            <?php
            // Fetch images from the database
            $sql = "SELECT * FROM images ORDER BY upload_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="image-container">
                            <img src="uploads/' . $row['image_name'] . '" alt="Precious Memory" onclick="openModal(\'uploads/' . $row['image_name'] . '\', \'' . $row['image_name'] . '\')">
                            <div class="info">
                                Date: ' . $row['upload_date'] . '
                                <a href="uploads/' . $row['image_name'] . '" download class="download-btn">Download ❤️</a>
                                <span class="delete-btn" onclick="deleteImage(' . $row['id'] . ')">Delete 💔</span>
                            </div>
                          </div>';
                }
            } else {
                echo "<div style='text-align: center; font-size: 1.2em; color: #ff4d6d;'>No memories yet! Start adding your precious moments ❤️</div>";
            }
            ?>
        </div>
    </div>

    <!-- Fullscreen Modal -->
    <div id="imageModal" class="modal">
        <span class="modal-close" onclick="closeModal()">×</span>
        <img id="modalImage" src="" alt="Fullscreen Image">
        <a id="fullscreenDownloadBtn" href="#" download class="download-btn-fullscreen">Download ❤️</a>
    </div>

    <script>
        function deleteImage(imageId) {
            if (confirm("Are you sure you want to delete this precious memory? 💔")) {
                window.location.href = 'delete.php?id=' + imageId;
            }
        }

        function openModal(imageSrc, imageName) {
            var modal = document.getElementById("imageModal");
            var modalImage = document.getElementById("modalImage");
            var downloadBtn = document.getElementById("fullscreenDownloadBtn");

            modal.style.display = "flex";
            modalImage.src = imageSrc;
            downloadBtn.href = imageSrc;
        }

        function closeModal() {
            var modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("imageModal");
            if (event.target === modal) {
                closeModal();
            }
        }

        // Add floating hearts animation
        function createFloatingHeart() {
            const heart = document.createElement('div');
            heart.className = 'floating-heart';
            heart.innerHTML = '❤️';
            heart.style.left = Math.random() * 100 + 'vw';
            document.body.appendChild(heart);
            
            setTimeout(() => {
                heart.remove();
            }, 6000);
        }

        // Create floating hearts periodically
        setInterval(createFloatingHeart, 3000);

        let touchStartY = 0;
        let pullRefresh = document.querySelector('.pull-refresh');
        let gallery = document.getElementById('gallery');

        // Pull to refresh functionality
        document.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        });

        document.addEventListener('touchmove', function(e) {
            if (window.scrollY === 0) {
                const touchY = e.touches[0].clientY;
                const pullDistance = touchY - touchStartY;
                
                if (pullDistance > 0) {
                    pullRefresh.classList.add('visible');
                } else {
                    pullRefresh.classList.remove('visible');
                }
            }
        });

        document.addEventListener('touchend', function() {
            if (pullRefresh.classList.contains('visible')) {
                location.reload();
            }
            pullRefresh.classList.remove('visible');
        });
    </script>
</body>
</html>
