<!-- navbar.php -->
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <a href="index.php">
                <span class="heart-icon">❤️</span>
                <span class="brand-text">Love Gallery</span>
            </a>
        </div>
        <div class="nav-links">
            <a href="index.php" class="nav-link">
                <span class="icon">🏠</span>
                <span class="text">Home</span>
            </a>
            <a href="upload.php" class="nav-link">
                <span class="icon">📤</span>
                <span class="text">Upload</span>
            </a>
        </div>
        <div class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: linear-gradient(135deg, #ff4d6d, #ff8fab);
        padding: 15px 0;
        box-shadow: 0 2px 10px rgba(255,77,109,0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-brand a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        font-family: 'Dancing Script', cursive;
        font-size: 1.8em;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .heart-icon {
        margin-right: 10px;
        animation: heartbeat 1.5s infinite;
    }

    .nav-links {
        display: flex;
        gap: 20px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: rgba(255,255,255,0.1);
    }

    .nav-link:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }

    .nav-link .icon {
        margin-right: 8px;
        font-size: 1.2em;
    }

    .nav-toggle {
        display: none;
        flex-direction: column;
        gap: 6px;
        cursor: pointer;
    }

    .nav-toggle span {
        display: block;
        width: 25px;
        height: 3px;
        background-color: white;
        transition: all 0.3s ease;
    }

    @keyframes heartbeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    @media (max-width: 768px) {
        .nav-toggle {
            display: flex;
        }

        .nav-links {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #ff4d6d, #ff8fab);
            flex-direction: column;
            padding: 20px;
            gap: 15px;
        }

        .nav-links.active {
            display: flex;
        }

        .nav-link {
            justify-content: center;
            padding: 12px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.querySelector('.nav-toggle');
        const navLinks = document.querySelector('.nav-links');

        navToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            this.classList.toggle('active');
        });
    });
</script>
