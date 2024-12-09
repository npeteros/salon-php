<div class="dash-nav-container">
    <div class="dash-nav-subcontainer">
        <div style="display: flex; justify-content: space-between; width: 100%;">
            <button
                style="display: flex; gap: 0.5rem; height: 100%; align-items: center; color: black; background: transparent; border: none; cursor: pointer;"
                onclick="window.location.href = './'">
                <?php include __DIR__ . '/logo.php'; ?>
                <span style="color: #A80011; font-weight: 800; font-size: 1.5rem; line-height: 2rem;">Hair Salon</span>
            </button>
            <div style="position: relative;">
                <button class="nav-menu-button" id="menu-button">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fillRule="evenodd" d="M3 8V6h18v2H3Zm0 5h18v-2H3v2Zm0 5h18v-2H3v2Z" clipRule="evenodd">
                        </path>
                    </svg>
                </button>
                <div id="menu"
                    style="display: none; position: absolute; right: 0; z-index: 10; border-radius: 0.5rem; border: 1px solid #F3F4F6; border-top-width: 1px; border-color: #F3F4F6; width: 11rem; font-weight: 400; background-color: #ffffff; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); padding: 0.5rem 0rem;">
                    <?php if ($_SESSION['user']['role'] === 'user' || $_SESSION['user']['role'] === 'stylist'): ?>
                        <button class="responsive-nav-link" onclick="window.location.href='./dashboard.php'">
                            <span class="color: rgb(163 163 163);">Home</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href='./appointments.php'">
                            <span class="color: rgb(163 163 163);">Appointments</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href='./consultations.php'">
                            <span class="color: rgb(163 163 163);">Consultations</span>
                        </button>
                        <div class="side-nav-divider" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
                        <button class="responsive-nav-link" onclick="window.location.href = './services.php'">
                            <span class="color: rgb(163 163 163);">Services</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href = './stylists.php'">
                            <span class="color: rgb(163 163 163);">Stylists</span>
                        </button>
                        <div class="side-nav-divider" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
                        <button class="responsive-nav-link" onclick="window.location.href='./profile.php'">
                            <span class="color: rgb(163 163 163);">Profile</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href='./logout.php'">
                            <span class="color: rgb(163 163 163);">Logout</span>
                        </button>
                    <?php else: ?>
                        <button class="responsive-nav-link" onclick="window.location.href='./admin-dashboard.php'">
                            <span>Home</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href='./admin-appointments.php'">
                            <span class="">Appointments</span>
                        </button>
                        <div class="side-nav-divider" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
                        <button class="responsive-nav-link" onclick="window.location.href = './admin-treatments.php'">
                            <span class="">Treatments</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href = './admin-services.php'">
                            <span class="">Services</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href = './users.php'">
                            <span class="">Users</span>
                        </button>
                        <div class="side-nav-divider" style="margin-top: 0.5rem; margin-bottom: 0.5rem;"></div>
                        <button class="responsive-nav-link" onclick="window.location.href='./admin-profile.php'">
                            <span class="">Profile</span>
                        </button>
                        <button class="responsive-nav-link" onclick="window.location.href='./logout.php'">
                            <span class="">Logout</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>