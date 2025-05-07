<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-primary text-white">
                <h4 class="m-0">Login to AI-Exam System</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/auth/login" method="post">
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                                id="userEmail" name="userEmail" value="<?php echo $data['userEmail']; ?>" required>
                            <div class="invalid-feedback"><?php echo $data['email_err']; ?></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                                id="userPassword" name="userPassword" required>
                            <div class="invalid-feedback"><?php echo $data['password_err']; ?></div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login <i class="bi bi-box-arrow-in-right"></i></button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <small class="text-muted">AI-Generated Exam System &copy; <?php echo date('Y'); ?></small>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>