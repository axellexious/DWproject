<?php require APPROOT . '/views/layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <a href="<?php echo BASE_URL; ?>/tos" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Files
        </a>
        <h1 class="display-5">Upload TOS File</h1>
        <p class="lead">Upload a new Table of Specifications file</p>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-cloud-upload"></i> File Upload Form
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/tos/store" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Topic</label>
                        <select class="form-select <?php echo (!empty($data['topic_id_err'])) ? 'is-invalid' : ''; ?>"
                            id="topic_id" name="topic_id" required>
                            <option value="" selected disabled>Select a topic</option>
                            <?php foreach ($data['topics'] as $topic) : ?>
                                <option value="<?php echo $topic['topicID']; ?>" <?php echo $data['topic_id'] == $topic['topicID'] ? 'selected' : ''; ?>>
                                    <?php echo $topic['topicDesc']; ?> (<?php echo $topic['courseCode_FK']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?php echo $data['topic_id_err']; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="test_type_id" class="form-label">Test Type</label>
                        <select class="form-select <?php echo (!empty($data['test_type_id_err'])) ? 'is-invalid' : ''; ?>"
                            id="test_type_id" name="test_type_id" required>
                            <option value="" selected disabled>Select a test type</option>
                            <?php foreach ($data['testTypes'] as $testType) : ?>
                                <option value="<?php echo $testType['testTypeID']; ?>" <?php echo $data['test_type_id'] == $testType['testTypeID'] ? 'selected' : ''; ?>>
                                    <?php echo $testType['testTypeName']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?php echo $data['test_type_id_err']; ?></div>
                    </div>

                    <div class="mb-4">
                        <label for="tosFile" class="form-label">File</label>
                        <div class="input-group">
                            <input type="file" class="form-control <?php echo (!empty($data['file_err'])) ? 'is-invalid' : ''; ?>"
                                id="tosFile" name="tosFile" required accept=".doc,.docx,.xls,.xlsx">
                            <div class="invalid-feedback"><?php echo $data['file_err']; ?></div>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> Allowed file types: DOC, DOCX, XLS, XLSX. Maximum file size: 5MB.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Uploader Information</label>
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Name:</strong> <?php echo getCurrentUserName(); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Date:</strong> <?php echo date('M d, Y'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-cloud-upload"></i> Upload File
                        </button>
                        <a href="<?php echo BASE_URL; ?>/tos" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/layouts/footer.php'; ?>