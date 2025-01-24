<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['video'])) {
        $file = $_FILES['video'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'File upload failed.']);
            exit;
        }

        $uploadDir = 'assets/video/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); 
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadFile = $uploadDir . $fileName;

        $allowedVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];

        if (!in_array($file['type'], $allowedVideoTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only MP4, WebM, and OGG videos are allowed.']);
            exit;
        }

        $maxVideoSize = 100 * 1024 * 1024; 
        if ($file['size'] > $maxVideoSize) {
            echo json_encode(['success' => false, 'message' => 'File size exceeds the maximum limit of 100MB.']);
            exit;
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $fileUrl = 'https://hospitalitytv.dafam.cloud/' . $uploadFile;
            echo json_encode(['success' => true, 'fileUrl' => $fileUrl]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to move video file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No video file uploaded.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>