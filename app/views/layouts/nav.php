<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">AI-Exam System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('dashboard'); ?>" href="<?php echo BASE_URL; ?>/dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('tos'); ?>" href="<?php echo BASE_URL; ?>/tos">
                        <i class="bi bi-file-earmark-text"></i> TOS Files
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isActive('tos/upload'); ?>" href="<?php echo BASE_URL; ?>/tos/upload">
                        <i class="bi bi-cloud-upload"></i> Upload File
                    </a>
                </li>
                <?php if (isAdmin()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-gear"></i> Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/users">Manage Users</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/programs">Manage Programs</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/courses">Manage Courses</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/topics">Manage Topics</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?php echo getCurrentUserName(); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/auth/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>