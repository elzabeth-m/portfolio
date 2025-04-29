
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'biroDB';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function cleanInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$fullname = $email = $phone = $subject = $message = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = cleanInput($_POST["fullname"]);
    $email = cleanInput($_POST["email"]);
    $phone = cleanInput($_POST["phone"]);
    $subject = cleanInput($_POST["subject"]);
    $message = cleanInput($_POST["message"]);

    // Validation
    if (empty($fullname)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($message)) $errors[] = "Message is required";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (fullname, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            // Redirect back to HTML with success flag
            header("Location: portfolio.html?status=success");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}

$conn->close();
?>