<html>
    <head>
        <title>Registration Complete</title>
        <link type="text/css" rel="stylesheet" href="../../css_files/style.css" />
    </head>
    <body>
        <h1>Registration Complete</h1>
        <h4>Administrator will now review your details<br/>
        and you will soon receive an email with your login credentials.</h4>
        <h2>Thank you for registering!</h2>

        <script>
            function timer(){
                var counter = 5;
                var x = setInterval(function(){
                    counter--;
                    document.getElementById('countdown').innerHTML = counter;
                    if (counter == 0) {
                        clearInterval(x);
                    }
                }, 1000);
            }

            timer();
        </script>

        <h5>Redirecting to login page in: <span id="countdown">5</span></h5>
        <?php
            header("refresh:5;url='../../../index.php'");
        ?>
    </body>
</html>