<!doctype html>
<html lang="en">

<head>
    <?php include('include/head.inc.html') ?>
    <title>Webcom - Admin Login</title>
</head>

<body>
    <section id="login">
        <div class="login-container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <form method="POST" onsubmit="return login(event);">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include('include/jslib.inc.html') ?>

    <script>
        function login(e) {
            e.preventDefault();
            $.ajax({
                url: 'php/login.php',
                data: {
                    'email': $('#email').val(),
                    'password': $('#password').val()
                },
                method: 'post',
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        window.location.href = "dashboard";
                    } else {
                        alert(response.message);
                    }
                },
            });
        }
    </script>
</body>

</html>