<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="display-5">Dashboard</h1>
        <p class="lead">Welcome back, <?php echo getCurrentUserName(); ?>!</p>
        <hr>
    </div>
</div>

<!-- Dashboard Quick Stats -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <div class="display-4 text-primary">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h5 class="card-title">TOS Files</h5>
                        <h2><?php echo $data['tos_count']; ?></h2>
                        <a href="<?php echo BASE_URL; ?>/tos" class="btn btn-sm btn-outline-primary">View All Files</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <div class="display-4 text-success">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <h5 class="card-title">Courses</h5>
                        <h2><?php echo $data['course_count']; ?></h2>
                        <a href="<?php echo BASE_URL; ?>/courses" class="btn btn-sm btn-outline-success">Manage Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Uploads -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Recent File Uploads</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($data['recent_tos'])) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Topic</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['recent_tos'] as $tos) : ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="<?php echo getFileIcon('file.docx'); ?> fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">TOS #<?php echo $tos['tosID']; ?></h6>
                                                    <small class="text-muted"><?php echo $tos['testTypeName']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $tos['topicDesc']; ?></td>
                                        <td><?php echo $tos['courseCode']; ?> - <?php echo $tos['courseName']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($tos['dateCreated'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?php echo BASE_URL; ?>/tos/download/<?php echo $tos['tosID']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download"></i> Download
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/tos/view/<?php echo $tos['tosID']; ?>" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No files have been uploaded yet.
                        <a href="<?php echo BASE_URL; ?>/tos/upload" class="alert-link">Upload your first file</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="<?php echo BASE_URL; ?>/tos" class="btn btn-primary">View All Files</a>
                <a href="<?php echo BASE_URL; ?>/tos/upload" class="btn btn-success">Upload New File</a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>