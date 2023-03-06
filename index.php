<?php
header('location:./Etudiant/index.php');

?>

<head>
    <style>
        .tableau {
            border-collapse: collapse;
            text-align: left;
            font-size: 13;
            font-weight: 500;
            margin-top: 40px;
            margin-left: 405px;
            width: 1210px;
            border-radius: 10px;
            box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
            position: relative;
            z-index: 1;
            background: inherit;
            overflow: hidden;
            margin-bottom: 70px;
            padding-bottom: 50px;
            border-radius: 5px;
            background-color: #EFF5F5;


        }

        td,
        th {
            width: 150px;
            height: 10px;
            font-size: 18px;
            padding-left: 5px;
            padding-top: 20px;
            text-align: center;
            font-family: 'Nanum Myeongjo', serif;
        }


        th {
            padding: 23px;
            font-family: 'Nanum Myeongjo', serif;
            font-weight: 700;
            font-size: 20px;
            color: #4E944F;
            border-bottom: 1px solid #497174;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="tableau">
        <table id="produit">
            <thead>
                <tr>
                    <th id="star">image</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date</th>
                    <th>Ville</th>
                    <th> CIN</th>
                    <th>CNE</th>
                    <th>moyen</th>
                    <th>Mention</th>



                </tr>

            </thead>
            <tbody>
                <?php
                foreach ($lst as $c) {
                    echo "<tr>
                     <td> <img src=" . $c->image . " width='80px' height='80px'></td>
                    <td>  $c->nom</td>
                    <td>  $c->prenom </td>
                    <td >  $c->date</td>
                    <td>  $c->ville</td>
                    <td>  $c->cin</td>
                    <td>  $c->cne  </td>
                    <td > $c->moyen</td>
                    <td > $c->mention</td>

                    </tr>";
                }
                ?>
            </tbody>
        </table>
</body>