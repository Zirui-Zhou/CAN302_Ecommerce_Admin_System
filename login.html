
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login-Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/datatables.min.js"></script>
    </head>
    <body class="bg-login" >
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ellen's Store Manage System</h3></div>
                                    <div class="card-body">
                                        <form id="login-form">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" placeholder="name@example.com" />
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class=" mt-4 mb-0" style="text-align: right">
                                                <button class="btn btn-primary login-btn" >Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
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
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
        <script  type="module">
        $(document).ready(function () {
            $(".login-btn").click(function () {
                const name = $(this).closest('#login-form').find("#inputEmail").val()
                const password = $(this).closest('#login-form').find("#inputPassword").val()
                login(name, password);
            });
        });
        function login(name, password) {
            const values = {
                'name': name,
                'password': password,
            };
            $.ajax({
                url: "api/user/login.php",
                type: "POST",
                async: false,
                data: JSON.stringify(values),
            })
                .done(function(data) {
                    if (data.trim() === "Wrong password") {
                        alert("Input error. Please try it again!");
                    } else if (data.trim() === "Empty") {
                        alert("The field cannot be empty");
                    } else {
                        console.log("#" + data);
                        Cookies.set('token', data);
                        showUserInfo();
                    }
                })
                .fail(function(data) {
                    alert("Opps! There are something wrong.. (X_X) ");
                });
        }
        function showUserInfo(){
            $.ajax({
                headers: {
                    "token": Cookies.get('token')//此处放置请求到的用户token
                },
                type: "POST",
                url: "api/user/token.php",//请求url
            })
                .done(function(data) {
                    if (data.trim() === "SUCCESS") {
                        window.location.href="index.html"
                    } else {
                        alert("Opps! There are something wrong.. (X_X) "+data);
                    }
                })
                .fail(function(data) {
                    this.loginLoading = false;
                    alert("Opps! There are something wrong.. (X_X) ");
                })
        }
    </script>
    </body>
</html>
