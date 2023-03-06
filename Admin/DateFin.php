<?php

include 'header.php';
if (!empty($CAdmin)) {
    $Dates = $db->get_Date();
    $date_D = $Dates['date_debut'];
    $date_F = $Dates['date_fin'];
    if (isset($_POST['Applique'])) {
        $date_D = htmlspecialchars($_POST['date_debut']);
        $date_F = htmlspecialchars($_POST['date_fin']);
        $db->change_dateFin($date_D, $date_F);
    }
    $Dates = $db->get_Date();
?>
    <style>
        .Date_FD {
            width: 100%;
            position: relative;

        }

        .Date_FD form {
            display: flex;
            width: 100%;
            margin-top: 20px;
            font-size: 30px;
        }

        .Date_FD form label {
            font-weight: bold;
        }

        .Date_FD form input[type="datetime-local"] {
            width: 30%;
            height: 40px;
        }

        .btn {
            width: 20%;
            background-color: #00C6CF;
            color: #fff;
            border: 1px;
            font-weight: bold;
            border-radius: 5px;
        }

        .container_count {
            display: grid;
            place-content: center;

        }

        h1 {
            font-weight: normal;
            letter-spacing: 0.125rem;
            text-transform: uppercase;
        }

        #countdown ul li {
            display: inline-block;
            font-size: 1.5em;
            list-style-type: none;
            padding: 1em;
            text-transform: uppercase;
        }

        #countdown ul li span {
            display: block;
            font-size: 4.5rem;
        }

        .fin {
            color: red;
        }

        @media all and (max-width: 768px) {
            h1 {
                font-size: calc(1.5rem * var(--smaller));
            }

            #countdown ul li {
                font-size: calc(1.125rem * var(--smaller));
            }

            #countdown ul li span {
                font-size: calc(3.375rem * var(--smaller));
            }
        }
    </style>
    <h2>Date de Debut et Fin d'inscreption :</h2>
    <div class="Date_FD">
        <form method="post" action="">
            <label for="DB">Date Debut:</label>
            <input type="datetime-local" name="date_debut" id="DB" value="<?php if (!empty($Dates['date_debut'])) {
                                                                                echo $Dates['date_debut'];
                                                                            } else {
                                                                                echo date('Y-m-d H:i');
                                                                            } ?>" readonly />
            <label for=" DF">Date Fin:</label>
            <input type="datetime-local" name="date_fin" id="DF" value="<?php if ($Dates) {
                                                                            echo $Dates['date_fin'];
                                                                        }
                                                                        ?>" />
            <input type="submit" value="Applique" name="Applique" class="btn">
        </form>
    </div>
    <div class="container_count">
        <h1 id="headline"> </h1>
        <div id="countdown">
            <ul>
                <li><span id="days"></span>Jours</li>
                <li><span id="hours"></span>Hours</li>
                <li><span id="minutes"></span>Minutes</li>
                <li><span id="seconds"></span>Seconds</li>
            </ul>
        </div>
        <div id="content" class="fin">

        </div>
    </div>
    </div>
    </div>
    <script>
        <?php if (!empty($date_D)) { ?>
            // Set the date we're counting down to
            var countDownDate = new Date("<?php echo $date_F; ?>").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time

                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"

                document.getElementById("days").innerHTML = days;
                document.getElementById("hours").innerHTML = hours;
                document.getElementById("minutes").innerHTML = minutes;
                document.getElementById("seconds").innerHTML = seconds;
                // If the count down is finished, write some text
                if (distance <= 0) {
                    clearInterval(x);
                    document.getElementById("content").innerHTML = "le temps d'inscription est expireé!!!  ";
                    document.getElementById("days").innerHTML = "0";
                    document.getElementById("hours").innerHTML = "0";
                    document.getElementById("minutes").innerHTML = "0";
                    document.getElementById("seconds").innerHTML = "0";
                }
            }, 1000);
        <?php }; ?>
    </script>
    </body>

    </html>
<?php
} else {
    header('location:index.php');
}
?>