<?php
/**
 * BoutonFlareX — contact form handler
 * Lightweight, dependency-free mail relay for contact.html's form.
 * Replace $to_address with your live support inbox before going live,
 * and consider swapping mail() for a transactional email API/SMTP
 * library if your host has PHP mail() disabled.
 */

header('Content-Type: text/html; charset=UTF-8');

$to_address = "hello@boutonflarex.com";

function clean_input($value) {
    return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

$name    = clean_input($_POST['name'] ?? '');
$email   = clean_input($_POST['email'] ?? '');
$subject = clean_input($_POST['subject'] ?? 'New message from boutonflarex.com');
$message = clean_input($_POST['message'] ?? '');

// Honeypot field, if one is later added to the form (name="website"), quietly drops bots.
if (!empty($_POST['website'])) {
    echo "Thanks!";
    exit;
}

if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please go back and fill in your name, a valid email address, and a message.";
    exit;
}

$mail_body = "New contact form submission from boutonflarex.com\n\n";
$mail_body .= "Name: {$name}\n";
$mail_body .= "Email: {$email}\n";
$mail_body .= "Subject: {$subject}\n\n";
$mail_body .= "Message:\n{$message}\n";

$headers = "From: no-reply@boutonflarex.com\r\n";
$headers .= "Reply-To: {$email}\r\n";

$sent = @mail($to_address, "[BoutonFlareX Contact] " . $subject, $mail_body, $headers);

if ($sent) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Message sent — BoutonFlareX</title>" .
         "<meta http-equiv='refresh' content='4;url=contact.html'></head>" .
         "<body style='font-family:sans-serif; padding:60px; text-align:center;'>" .
         "<h1>Thanks, {$name}!</h1><p>Your message has been sent. We'll get back to you within one business day.</p>" .
         "<p><a href='contact.html'>Return to the contact page</a></p></body></html>";
} else {
    http_response_code(500);
    echo "Something went wrong sending your message. Please email us directly or try again shortly.";
}
