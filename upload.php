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
            $success = "File uploaded and stored successfully!";
            header("refresh:2;url=index.php"); // Redirect after 2 seconds
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error = "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image - Love Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(255,77,109,0.1);
        }

        h1 {
            font-family: 'Dancing Script', cursive;
            color: #ff4d6d;
            text-align: center;
            font-size: 2.5em;
            margin: 0 0 30px 0;
            padding: 0;
        }

        .upload-container {
            border: 2px dashed #ff4d6d;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            background: #fff;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            width: 100%;
            margin: 0;
        }

        .upload-container:hover, .upload-container.dragover {
            background: #fff5f7;
            border-color: #ff8fab;
        }

        .upload-icon {
            font-size: 3em;
            margin: 0 0 15px 0;
            color: #ff4d6d;
        }

        .upload-text {
            color: #666;
            margin: 0 0 20px 0;
            padding: 0;
        }

        .upload-text strong {
            color: #ff4d6d;
        }

        .file-input {
            display: none;
            margin: 0;
            padding: 0;
        }

        .preview-container {
            margin: 30px 0 0 0;
            padding: 0;
            display: none;
            width: 100%;
        }

        .preview-image {
            max-width: 300px;
            max-height: 300px;
            border-radius: 10px;
            margin: 0 auto;
            display: block;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .upload-btn {
            background: linear-gradient(135deg, #ff4d6d, #ff8fab);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 20px 0 0 0;
            display: none;
            width: auto;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,77,109,0.3);
        }

        .message {
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            display: none;
            width: 100%;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
            text-align: center;
            margin: 20px 0;
            padding: 0;
            width: 100%;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ff4d6d;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .container {
                margin: 0;
                padding: 15px;
                border-radius: 0;
            }

            h1 {
                font-size: 2em;
                margin: 0 0 20px 0;
            }

            .upload-container {
                padding: 20px;
                border-radius: 10px;
            }

            .upload-icon {
                font-size: 2.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Your Precious Memory ❤️</h1>
        
        <?php if (isset($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="upload-container" id="dropZone">
            <div class="upload-icon">📸</div>
            <div class="upload-text">
                <strong>Drag & Drop</strong> your image here<br>
                or <strong>Click to Browse</strong>
            </div>
            <input type="file" name="image" id="fileInput" class="file-input" accept="image/*" required>
            <div class="preview-container" id="previewContainer">
                <img src="" alt="Preview" class="preview-image" id="previewImage">
            </div>
        </div>

        <form action="upload.php" method="POST" enctype="multipart/form-data" id="uploadForm">
            <input type="file" name="image" id="formFileInput" class="file-input" accept="image/*" required>
            <button type="submit" name="upload" class="upload-btn" id="uploadBtn">Upload ❤️</button>
        </form>

        <div class="loading" id="loading">
            <div class="loading-spinner"></div>
            <p>Uploading your precious memory...</p>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const formFileInput = document.getElementById('formFileInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const uploadBtn = document.getElementById('uploadBtn');
        const uploadForm = document.getElementById('uploadForm');
        const loading = document.getElementById('loading');

        // Handle drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length) {
                handleFile(files[0]);
            }
        });

        // Handle click to upload
        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                handleFile(e.target.files[0]);
            }
        });

        function handleFile(file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                    uploadBtn.style.display = 'inline-block';
                    formFileInput.files = fileInput.files;
                };
                reader.readAsDataURL(file);
            } else {
                alert('Please upload an image file.');
            }
        }

        // Handle form submission
        uploadForm.addEventListener('submit', (e) => {
            loading.style.display = 'block';
            uploadBtn.style.display = 'none';
        });
    </script>
</body>
</html>
