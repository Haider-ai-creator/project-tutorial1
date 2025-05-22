<?php
// Get the form data safely
$firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

// Basic validation check
if (empty($firstName) || empty($lastName) || empty($gender) || empty($email) || empty($password) || empty($phone)) {
    die('Please complete all required fields.');
}

// Create connection to MySQL database on localhost
$conn = new mysqli('localhost', 'root', '', 'test1');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Prepare the INSERT statement with placeholders for 6 fields
$stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, gender, email, password, phone) VALUES (?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Bind parameters: s = string for each (all strings here)
$stmt->bind_param('ssssss', $firstName, $lastName, $gender, $email, $hashedPassword, $phone);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error during registration: " . htmlspecialchars($stmt->error);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

