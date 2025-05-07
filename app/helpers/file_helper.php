<?php
// app/helpers/file_helper.php

// Check if file extension is allowed
function isAllowedExtension($filename)
{
    $allowed = ALLOWED_DOC_FORMATS;
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (in_array(strtolower($ext), $allowed)) {
        return true;
    }

    return false;
}

// Get file size in human readable format
function formatFileSize($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

// Get file icon based on extension
function getFileIcon($filename)
{
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    switch ($ext) {
        case 'doc':
        case 'docx':
            return 'bi bi-file-word text-primary';
        case 'xls':
        case 'xlsx':
            return 'bi bi-file-excel text-success';
        case 'pdf':
            return 'bi bi-file-pdf text-danger';
        default:
            return 'bi bi-file-earmark';
    }
}

// Get MIME type based on extension
function getMimeType($filename)
{
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    switch ($ext) {
        case 'doc':
            return 'application/msword';
        case 'docx':
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        case 'xls':
            return 'application/vnd.ms-excel';
        case 'xlsx':
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        default:
            return 'application/octet-stream';
    }
}
