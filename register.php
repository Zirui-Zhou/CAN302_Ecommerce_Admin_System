<!DOCTYPE html>
<html lang="en">
    <head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-login">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                    <form action="save_register.php" method="post">
                                        
                                    <div class="form-floating mb-3">
                                            <input class="form-control" id="inputFirstName" name="first_name" type="text" placeholder="Enter your first name" />
                                            <label for="inputFirstName">Name</label>
                                    </div>
                                                
                                          
                                        <div class="form-floating mb-3 ">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Email address</label>
                                        </div>
                                           
                                        <div class="row mb-3">
                                         <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" name="inputPhone" id="phone" type="phone" placeholder="Create a password" />
                                                        <label for="inputPhone">Phone</label>
                                                        
                                                    </div>
                                            </div>
                                         <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputBirthday" name="birthday" type="date" />
                                                    <label for="inputBirthday">Birthday</label>
                                            </div>
                                         </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" name="password_confirm" type="password" placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button id = "register-btn" class="btn btn-primary btn-block" type="submit" >Create Account</button></div>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Ellen's Mall</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

        <script>
          $(document).ready(function() {

            $("form").submit(function(event) {

              event.preventDefault();


              var password = $("#inputPassword").val();
              var passwordConfirm = $("#inputPasswordConfirm").val();
              var phone = $("#phone").val();
              var name = $("#inputFirstName").val();
              var email = $("#inputEmail").val();
              var birthday = $("#inputBirthday").val();

              if (password !== passwordConfirm) {
                alert("Password and confirm password do not match!");
                return;
              }else{
                $.ajax({
                        url: "save_register.php",
                        method: "POST",
                        data: {
                            name: name,
                            email: email,
                            password: password,
                            phone: phone,
                            birthday: birthday,

                        },
                        success: function(response) {
                            console.log(response);
                            alert("Data saved successfully!");
                            window.location.href = "login.php";
                        },

                        error: function(xhr, status, error) {
                            console.log(error);
                            alert("An error occurred while saving data. Please try again later.");
                        }
                     });
              }

              // $(this).unbind("submit").submit();
            });
          });
        </script>
</body>
</html>
