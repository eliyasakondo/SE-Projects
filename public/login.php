<?php
session_start();
error_log("Session started: " . session_id());
echo "Session started: " . session_id() . "<br>";

include '../includes/functions.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ob_start(); // Start output buffering to prevent any output before headers

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $conn = get_db_connection();
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->errorInfo()[2]);
        die("Prepare failed: " . $conn->errorInfo()[2]);
    }

    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging: Print user details
    if ($user) {
        error_log("User details: " . json_encode($user));
        echo "User details: " . json_encode($user) . "<br>";
    } else {
        error_log("No user found with email: " . $email);
        echo "No user found with email: " . $email . "<br>";
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        // Debugging: Check the session variables
        error_log("Session user_id: " . $_SESSION['user_id']);
        error_log("Session role: " . $_SESSION['role']);
        echo "Session user_id: " . $_SESSION['user_id'] . "<br>";
        echo "Session role: " . $_SESSION['role'] . "<br>";

        // Check if any output has been sent before headers
        if (headers_sent()) {
            error_log("Headers already sent. Cannot redirect.");
            echo "Headers already sent. Cannot redirect.<br>";
        } else {
            // Redirect based on role
            switch ($user['role']) {
                case 'tutor':
                    error_log("Redirecting to tutor profile");
                    echo "Redirecting to tutor profile<br>";
                    header('Location: tutor/profile.php');
                    break;
                case 'coordinator':
                    error_log("Redirecting to coordinator dashboard");
                    echo "Redirecting to coordinator dashboard<br>";
                    header('Location: coordinator/dashboard.php');
                    break;
                case 'sst':
                    error_log("Redirecting to sst dashboard");
                    echo "Redirecting to sst dashboard<br>";
                    header('Location: sst/dashboard.php');
                    break;
                case 'sss':
                    error_log("Redirecting to sss dashboard");
                    echo "Redirecting to sss dashboard<br>";
                    header('Location: sss/dashboard.php');
                    break;
                case 'dean':
                    error_log("Redirecting to dean dashboard");
                    echo "Redirecting to dean dashboard<br>";
                    header('Location: dean/dashboard.php');
                    break;
                case 'provc':
                    error_log("Redirecting to provc dashboard");
                    echo "Redirecting to provc dashboard<br>";
                    header('Location: provc/dashboard.php');
                    break;
                case 'vc':
                    error_log("Redirecting to provc dashboard");
                    echo "Redirecting to provc dashboard<br>";
                    header('Location: vc/dashboard.php');
                    break;
                default:
                    error_log("Unknown role, redirecting to login");
                    echo "Unknown role, redirecting to login<br>";
                    header('Location: login.php');
                    break;
            }
        }
        ob_end_flush(); // Flush the output buffer and send headers
        exit();
    } else {
        // Debugging: Check if user was found and password verification
        if (!$user) {
            error_log("User not found for email: " . $email);
            echo "User not found for email: " . $email . "<br>";
        } else {
            error_log("Password verification failed for email: " . $email);
            echo "Password verification failed for email: " . $email . "<br>";
        }
        $error = "Invalid email or password.";
    }
    ob_end_flush(); // Flush the output buffer in case of error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>