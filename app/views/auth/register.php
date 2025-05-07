<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-primary text-white">
                <h4 class="m-0">Create Account</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/register/register" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control <?php echo (!empty($data['firstName_err'])) ? 'is-invalid' : ''; ?>"
                                id="firstName" name="firstName" value="<?php echo $data['firstName']; ?>" required>
                            <div class="invalid-feedback"><?php echo $data['firstName_err']; ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control <?php echo (!empty($data['lastName_err'])) ? 'is-invalid' : ''; ?>"
                                id="lastName" name="lastName" value="<?php echo $data['lastName']; ?>" required>
                            <div class="invalid-feedback"><?php echo $data['lastName_err']; ?></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name (Optional)</label>
                        <input type="text" class="form-control"
                            id="middleName" name="middleName" value="<?php echo $data['middleName']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="userName" class="form-label">Username</label>
                        <input type="text" class="form-control <?php echo (!empty($data['userName_err'])) ? 'is-invalid' : ''; ?>"
                            id="userName" name="userName" value="<?php echo $data['userName']; ?>" required>
                        <div class="invalid-feedback"><?php echo $data['userName_err']; ?></div>
                        <div class="form-text">Username must be less than 10 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control <?php echo (!empty($data['userEmail_err'])) ? 'is-invalid' : ''; ?>"
                                id="userEmail" name="userEmail" value="<?php echo $data['userEmail']; ?>" required>
                            <div class="invalid-feedback"><?php echo $data['userEmail_err']; ?></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control <?php echo (!empty($data['userPassword_err'])) ? 'is-invalid' : ''; ?>"
                                id="userPassword" name="userPassword" required>
                            <div class="invalid-feedback"><?php echo $data['userPassword_err']; ?></div>
                        </div>
                        <div class="form-text">Password must be at least 6 characters.</div>
                    </div>

                    <div class="mb-4">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control <?php echo (!empty($data['confirmPassword_err'])) ? 'is-invalid' : ''; ?>"
                                id="confirmPassword" name="confirmPassword" required>
                            <div class="invalid-feedback"><?php echo $data['confirmPassword_err']; ?></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Register <i class="bi bi-person-plus"></i></button>
                        <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-link">Already have an account? Login</a>
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