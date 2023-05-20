<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "students";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$gender = $_POST['gender'];

$errors = [];

if (empty($full_name)) {
    $errors[] = "Full Name is required.";
}

if (empty($email)) {
    $errors[] = "Email Address is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid Email Address format.";
}

if (empty($gender)) {
    $errors[] = "Gender is required.";
}

if (empty($errors)) {
    
    $stmt = $conn->prepare("INSERT INTO students (full_name, email, gender) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $gender);
    $stmt->execute();

    
    if ($stmt->affected_rows > 0) {
        echo "Registration successful!";
    } else {
        echo "Error occurred. Please try again.";
    }
   
    $stmt->close();
} else {
    
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

$conn->close();
?>
