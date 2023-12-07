<?php
require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // If Password matches, redirect to index.html
            header("Location: ../index.html");
            exit();
        } else {
            $errorMessage = "Invalid password. Please try again.";
        }
    } else {
        $errorMessage = "Invalid email or user not found. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Shirtify | Login</title>
    <link rel="icon" href="../img/mdb-favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="../js/scriptLogin.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/font-poppins.css">
</head>

<body>
    <section class="vh-100 gradient-custom d-flex justify-content-center align-items-center"
        style="box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);">
        <div class="container py-5 h-100">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                onsubmit="return validateLoginForm()">
                <div class="row align-items-center">

                    <!-- Login form -->
                    <div class="col-md-6">
                        <div class="card bg-white text-black" style="border-radius: 1rem;">
                            <div class="card-body p-5">
                                <h2 class="text-start fw-bold text-black mb-2 text-uppercase">SHIRTIFY</h2>
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="text-start font-weight-bold text-black-50 mb-5">Sign in</h2>

                                    <label class="form-label" for="typeEmailX">Email</label>
                                    <div class="form-outline form-black border border-secondary mb-4 rounded-3">
                                        <input type="email" id="typeEmailX" class="form-control form-control-lg"
                                            name="email" />
                                    </div>

                                    <label class="form-label" for="typePasswordX">Password</label>
                                    <div class="form-outline form-black border border-secondary mb-4 rounded-3">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg"
                                            name="password" />
                                    </div>

                                    <!-- Error message -->
                                    <div id="loginErrorMessage"></div>
                                    <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
                                    <span id="phpLoginErrorMessage"
                                        style="color: red;"><?php echo $errorMessage; ?></span>
                                    <?php endif; ?>

                                    <div class="text-center">
                                        <p class="small mb-5 pb-lg-2">
                                            <a class="text-black-50" href="signup.php?showMessage=true">Forgot
                                                password?</a>
                                        </p>
                                        <button class="btn btn-success btn-lg rounded-pill px-5" type="submit">SIGN
                                            IN</button>
                                    </div>

                                </div>
                                <div class="text-center">
                                    <p class="text-black-50 mb-0">Don't have an account? <a href="signup.php"
                                            class="text-green fw-bold">Sign Up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>