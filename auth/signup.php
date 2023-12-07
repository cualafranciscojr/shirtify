<?php
require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

 try {
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) { 
            // MySQL error code for duplicate entry
            $errorMsg = "This email is already registered. Please use a different email.";
            echo "<script> var errorMsg = '" . addslashes($errorMsg) . "'; </script>";
        } else {
            $errorMsg = "Error: " . $e->getMessage();
            echo "<script> var errorMsg = '" . addslashes($errorMsg) . "'; </script>";
        }
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
    <title>Shirtify | Signup</title>
    <link rel="icon" href="../img/mdb-favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="../js/scriptSignup.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/font-poppins.css">

    <!-- /* CSS for modal */ -->
    <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        color: red;
        font-weight: bold;
    }
    </style>
</head>

<body style="background: #6DD877">
    <div class="container-fluid">
        <h1 class="display-1" style="font-weight: 600; ">SHIRTIFY</h1>

        <!-- Message container of forgot password -->
        <div id="messageContainer" style="display: none; color: red; font-weight: bold;"></div>

        <!-- // Function for "If you forgot your password in login.php" -->
        <script>
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        function showMessage() {
            var showMessageParam = getParameterByName('showMessage');
            if (showMessageParam === 'true') {
                var messageElement = document.getElementById('messageContainer');
                messageElement.textContent = 'You cannot change your password. Just create a new one!';
                messageElement.style.display = 'block';

                setTimeout(function() {
                    messageElement.style.display = 'none';
                }, 5000);
            }
        }
        showMessage();
        </script>

        <section class="text-center py-5">

            <!-- Error modal -->
            <div id="errorModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p id="errorMessage"></p>
                </div>
            </div>

            <!-- // JS to display the modal with the error message -->
            <script>
            window.onload = function() {
                if (typeof errorMsg !== 'undefined' && errorMsg !== '') {
                    var modal = document.getElementById('errorModal');
                    var message = document.getElementById('errorMessage');
                    message.textContent = errorMsg;
                    modal.style.display = 'block';

                    // Close the modal
                    var closeButton = document.getElementsByClassName('close')[0];
                    window.onclick = function(event) {
                        if (event.target == modal || event.target == closeButton) {
                            modal.style.display = 'none';
                        }
                    };
                }
            };
            </script>

            <!-- Signup form -->
            <div class="row justify-content-end">
                <div class="col-md-6">
                    <div class="card p-5 mx-4 mx-md-5 shadow-5-strong">
                        <div class="card-body py-5 px-md-5">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">

                                    <form name="signupForm"
                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                                        onsubmit="return validateForm()">
                                        <h2 class="fw-bold mb-5 text-start">Create Account</h2>
                                        <div class="row">
                                            <div class="Group1 col"
                                                style="width: 221px; height: 57px; position: relative">
                                                <div class="Rectangle3"
                                                    style="width: 221px; height: 57px; left: 0px; top: 0px; position: absolute; border-radius: 5px; border: 1px #F3F3F3 solid">
                                                </div>
                                                <img class="Pngegg691"
                                                    style="width: 24px; height: 24px; left: 9px; top: 16px; position: absolute"
                                                    src="../img/google-sign.png" />
                                                <div class="SignupWithFacebook"
                                                    style="left: 42px; top: 11px; position: absolute; color: black; font-size: 13px; font-weight: 300; line-height: 35px; letter-spacing: 1.04px; word-wrap: break-word">
                                                    Signup with Google</div>
                                            </div>
                                            <div class="Group1 col"
                                                style="width: 221px; height: 57px; position: relative">
                                                <div class="Rectangle3"
                                                    style="width: 221px; height: 57px; left: 0px; top: 0px; position: absolute; border-radius: 5px; border: 1px #F3F3F3 solid">
                                                </div>
                                                <img class="Pngegg691"
                                                    style="width: 24px; height: 24px; left: 9px; top: 16px; position: absolute"
                                                    src="../img/fb-signup.jpg" />
                                                <div class="SignupWithFacebook"
                                                    style="left: 42px; top: 11px; position: absolute; color: black; font-size: 13px; font-weight: 300; line-height: 35px; letter-spacing: 1.04px; word-wrap: break-word">
                                                    Signup with Facebook</div>
                                            </div>
                                        </div>

                                        <div class="Or mt-5 mb-5"
                                            style="color: #CDCACA; font-size: 18px; font-weight: 300; line-height: 35px; letter-spacing: 1.44px; word-wrap: break-word">
                                            - OR -</div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <label class="form-label font-weight-bold" for="form3Example1">First
                                                        name</label>
                                                    <input type="text" id="form3Example1" class="form-control"
                                                        name="firstName" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <label class="form-label font-weight-bold" for="form3Example2">Last
                                                        name</label>
                                                    <input type="text" id="form3Example2" class="form-control"
                                                        name="lastName" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label font-weight-bold" for="form3Example3">Email
                                                address</label>
                                            <input type="email" id="form3Example3" class="form-control" name="email" />
                                        </div>
                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label font-weight-bold"
                                                for="form3Example4">Password</label>
                                            <input type="password" id="form3Example4" class="form-control"
                                                name="password" />
                                        </div>
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-success btn-block mb-4">
                                            Create Account
                                        </button>
                                        <!-- Register buttons -->
                                        <div class="text-center">
                                            <p>Already have an account? <a href="login.php" style="color: green;">Log
                                                    in</a></p>
                                            <!-- Buttons for sign-up  -->
                                        </div>
                                    </form>
                                    <!-- Error message -->
                                    <div id="errorMessages"></div>

                                    <!-- // Signup validation -->
                                    <script>
                                    function validateForm() {
                                        var firstName = document.forms["signupForm"]["firstName"].value;
                                        var lastName = document.forms["signupForm"]["lastName"].value;
                                        var email = document.forms["signupForm"]["email"].value;
                                        var password = document.forms["signupForm"]["password"].value;
                                        var errorMessage = document.getElementById("errorMessages");

                                        if (firstName === "" || lastName === "" || email === "" || password === "") {
                                            errorMessage.innerHTML = "Please fill in all fields";
                                            errorMessage.style.color = "red";

                                            setTimeout(function() {
                                                errorMessage.innerHTML = "";
                                            }, 3000);

                                            return false;
                                        }
                                        return true;
                                    }
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</body>

</html>