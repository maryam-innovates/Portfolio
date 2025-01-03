<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(strip_tags(trim($_POST["name"])));
    $email = htmlspecialchars(strip_tags(trim($_POST["email"])));
    $message = htmlspecialchars(strip_tags(trim($_POST["message"])));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // reCAPTCHA validation
    $secretKey = "YOUR_SECRET_KEY";
    $captchaResponse = $_POST["g-recaptcha-response"];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        die("Captcha verification failed. Please try again.");
    }

    // Process data (e.g., send email)
    $to = "youremail@example.com"; // Replace with your email
    $subject = "New Contact Message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    if (mail($to, $subject, $body)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message.";
    }
}
?>
