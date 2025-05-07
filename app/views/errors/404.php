<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <div class="mt-5 mb-4">
            <h1 class="display-1 text-danger">404</h1>
            <h2>Page Not Found</h2>
            <p class="lead">The page you are looking for does not exist or has been moved.</p>
        </div>

        <div class="error-image my-5">
            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 5rem;"></i>
        </div>

        <div class="mb-5">
            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-house-fill"></i> Return to Home
            </a>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>