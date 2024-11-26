<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "udtohanjailoy@gmail.com";
    $subject = "Form Submission";
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $boundary = md5(time());

    // Email Headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Email Body
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n\n";

    // Handle File Attachment
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileData = file_get_contents($fileTmpPath);
        $fileEncoded = chunk_split(base64_encode($fileData));

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $fileEncoded . "\r\n";
    }

    $body .= "--$boundary--";

    // Send Email
    if (mail($to, $subject, $body, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
}
?>