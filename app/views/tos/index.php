<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="display-5">TOS Files</h1>
        <p class="lead">Manage your Table of Specifications files</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="<?php echo BASE_URL; ?>/tos/upload" class="btn btn-primary btn-lg">
            <i class="bi bi-cloud-upload"></i> Upload New File
        </a>
    </div>
</div>

<!-- Filter Form -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-funnel"></i> Filter Files
        </h5>
    </div>
    <div class="card-body">
        <form action="<?php echo BASE_URL; ?>/tos/filter" method="post" class="row g-3">
            <div class="col-md-5">
                <label for="course_code" class="form-label">Course</label>
                <select name="course_code" id="course_code" class="form-select">
                    <option value="">All Courses</option>
                    <?php foreach ($data['courses'] as $course) : ?>
                        <option value="<?php echo $course['courseCode']; ?>" <?php echo isset($data['selectedCourse']) && $data['selectedCourse'] == $course['courseCode'] ? 'selected' : ''; ?>>
                            <?php echo $course['courseCode']; ?> - <?php echo $course['courseName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label for="test_type_id" class="form-label">Test Type</label>
                <select name="test_type_id" id="test_type_id" class="form-select">
                    <option value="">All Test Types</option>
                    <?php foreach ($data['testTypes'] as $testType) : ?>
                        <option value="<?php echo $testType['testTypeID']; ?>" <?php echo isset($data['selectedTestType']) && $data['selectedTestType'] == $testType['testTypeID'] ? 'selected' : ''; ?>>
                            <?php echo $testType['testTypeName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Files Table -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-file-earmark-text"></i> Your Files
            <?php if (isset($data['selectedCourse']) || isset($data['selectedTestType'])) : ?>
                <span class="badge bg-info">Filtered</span>
            <?php endif; ?>
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($data['tosFiles'])) : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>File ID</th>
                            <th>Topic</th>
                            <th>Test Type</th>
                            <th>Course</th>
                            <th>Uploaded By</th>
                            <th>Upload Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['tosFiles'] as $tos) : ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="<?php echo getFileIcon('file.docx'); ?> fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">TOS #<?php echo $tos['tosID']; ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $tos['topicDesc']; ?></td>
                                <td><?php echo $tos['testTypeName']; ?></td>
                                <td><?php echo $tos['courseCode']; ?> - <?php echo $tos['courseName']; ?></td>
                                <td><?php echo $tos['facultyName']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($tos['dateCreated'])); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo BASE_URL; ?>/tos/download/<?php echo $tos['tosID']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/tos/view/<?php echo $tos['tosID']; ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <?php if ($_SESSION['user_role'] == 1 || $_SESSION['profile_id'] == $tos['profileID_FK']) : ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $tos['tosID']; ?>">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?php echo $tos['tosID']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete TOS #<?php echo $tos['tosID']; ?>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="<?php echo BASE_URL; ?>/tos/delete/<?php echo $tos['tosID']; ?>" method="post">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No files found.
                <?php if (isset($data['selectedCourse']) || isset($data['selectedTestType'])) : ?>
                    Try changing your filter criteria or <a href="<?php echo BASE_URL; ?>/tos" class="alert-link">view all files</a>.
                <?php else : ?>
                    <a href="<?php echo BASE_URL; ?>/tos/upload" class="alert-link">Upload your first file</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>