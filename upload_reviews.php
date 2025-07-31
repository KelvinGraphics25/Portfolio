<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "images/";
    $fileName = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validate image
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            $feedback = htmlspecialchars($_POST["feedback"]);
            $stars = $_POST["stars"];
            $review = [
                "image" => $targetFilePath,
                "feedback" => $feedback,
                "stars" => $stars
            ];

            $jsonFile = 'feedback.json';
            $reviews = [];

            if (file_exists($jsonFile)) {
                $jsonData = file_get_contents($jsonFile);
                $reviews = json_decode($jsonData, true) ?? [];
            }

            $reviews[] = $review;
            file_put_contents($jsonFile, json_encode($reviews, JSON_PRETTY_PRINT));
            header("Location: index.html");
            exit();
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Only JPG, JPEG, PNG & GIF files are allowed.";
    }
}
?>
