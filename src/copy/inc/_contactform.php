    <div class="contact-form" id="contact-form">
        <div class="content">
    <?php
    // Function to send an email
    function sendEmail($to, $subject, $message, $headers) {
        mail($to, $subject, $message, $headers);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Validate CSRF token
        if (!empty($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $message = $_POST["message"];
            $subject = "Website Form Submission from $name";

            // Customize the email headers if needed
            $headers = "From: $name <$email>" . "\r\n";

            // Your email address where you want to receive the form submissions
            $to = 'andre@3615toronto.ca';// $company['email'];

            // Check the honeypot field (if filled, assume spam and do not send email)
            if (empty($_POST['honeypot'])) {
                // Send the email
                sendEmail($to, $subject, $message, $headers);

                // Display the thank you message
                echo "<h3>Thank you for contacting us, $name!</h3>";
                echo "<p>We will get back to you as soon as possible.</p>";
            } else {
                // Honeypot field was filled; consider it as a spam attempt
                echo "<h3>Error: Suspicious Submission Detected.</h3>";
            }
        } else {
            // CSRF token validation failed; consider it as a potential security threat
            echo "<h3>Error: CSRF Token Validation Failed.</h3>";
        }
    } else {
        // Generate a CSRF token and store it in the session
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    ?>
    <p>Complete the form below and we will be happy to put you in touch with our closest team to see if they can help with your barbeque or gas fireplace needs.</p>
    <form method="post" action="<?php echo str_replace('index.php', '', $_SERVER['PHP_SELF']); ?>">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
         <label for="phone">Phone:
            <input type="text" id="phone" name="phone">
        </label>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>

        <button class="cta_button available" type="submit">Contact me!</button>
    </form>
    <?php 
    }
    ?>
        </div>
    </div>