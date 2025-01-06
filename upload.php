<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah file di-upload
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];

        // Cek apakah ada error pada file upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'File upload failed.']);
            exit;
        }

        // Tentukan direktori penyimpanan
        $uploadDir = 'assets/';
        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadFile = $uploadDir . $fileName;

        // Cek apakah file valid (misalnya, hanya gambar)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.']);
            exit;
        }

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            echo json_encode(['success' => true, 'imageUrl' => $uploadFile]);
        } else {
            echo json_encode(['success' => false, 'message' => 'File move failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
