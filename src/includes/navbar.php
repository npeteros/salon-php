<div class="nav-main-container">
    <div class="nav-section-container">
        <button
            style="display: flex; gap: 0.5rem; align-items: center; height: 100%; background: transparent; border: none;"
            onclick="window.location.href = './'">
            <?php include 'src/includes/logo.php'; ?>
            <span style="font-size: 1.5rem; line-height: 2rem; font-weight: 800; color: #A80011;">LOGO</span>
        </button>
        <div class="nav-menu-container">
            <a href="./#home" class="nav-menu-link">
                Home
                <span class="nav-link-animation"></span>
            </a>
            <a href="./#services" class="nav-menu-link">
                Our Services
                <span class="nav-link-animation"></span>
            </a>
            <a href="/team" class="nav-menu-link">
                Our Team
                <span class="nav-link-animation"></span>
            </a>
            <a href="/about" class="nav-menu-link">
                About Us
                <span class="nav-link-animation"></span>
            </a>
            <?php if (!isset($_SESSION['user'])) { ?>
                <a href="./register.php" class="nav-menu-link">
                    Register
                    <span class="nav-link-animation"></span>
                </a>
            <?php } else { ?>
                <a href="./logout.php" class="nav-menu-link">
                    Logout
                    <span class="nav-link-animation"></span>
                </a>
            <?php } ?>
        </div>
        <button class="nav-menu-button" id="menu-button">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fillRule="evenodd" d="M3 8V6h18v2H3Zm0 5h18v-2H3v2Zm0 5h18v-2H3v2Z" clipRule="evenodd">
                </path>
            </svg>
        </button>
    </div>
</div>