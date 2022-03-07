<?php

//Opprette kobling
$kobling = new mysqli('localhost', 'root', '', 'crud');

//Sjekk om kobling virker
if ($kobling->connect_error) {
    die("Noe gikk galt: " . $kobling->connect_error);
}

$info = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $info = $_POST['input'];

    if (!empty($info) && isset($_POST['putin'])) {
        $sql = "insert into info (info) values ('$info')";

        if (mysqli_query($kobling, $sql)) {
            echo "Insett ble gjennomført. ";
        } else {
            echo "Noe gikk galt med insett $sql ($kobling->error).";
        }
    }

    $endreid =  $_POST['endreid'];
    $endre =  $_POST['endre'];

    if(!empty($endre) && isset($_POST['endrepo'])){
        $sql = "UPDATE info set info = '$endre' where id = '$endreid'";

        if (mysqli_query($kobling, $sql)) {
            echo "Endring ble gjennomført. ";
        } else {
            echo "Noe gikk galt med endring $sql ($kobling->error).";
        }
    }

    $slettid =  $_POST['slettid'];
    
    if (isset($_POST['slett'])){
        $sql = "DELETE FROM info WHERE id = '$slettid'";

        if (mysqli_query($kobling, $sql)) {
            echo "sletting ble gjennomført. ";
        } else {
            echo "Noe gikk galt med sletting $sql ($kobling->error).";
        }
    }

    if(isset($_POST['slett']) && isset($_POST['endrepo']) && isset($_POST['putin'])){
        echo "Husk å checke av på hva du vill gjøre";
    }


}



?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>

<body>
    <br><br>

    sjekk av boksene for tingene du ønsker å redigere

    <form method="post">
        <input type="checkbox" name="putin">
        Putt inn i database:
        <input id="input" placeholder="skriv noe her" type="text" name="input">

        <br><br>


        <div class="board">
            <table>
                <td>input id</td>
                <td>info</td>

                <?php
                $query = "SELECT * FROM info";
                if ($result = mysqli_query($kobling, $query)) {
                    while ($rad = mysqli_fetch_assoc($result)) {
                        $allid = $rad["id"];
                        $allinfo = $rad["info"];
                        echo "<tr><td>$allid</td><td>$allinfo</td></tr>";
                    }
                }

                ?>
            </table>
        </div>

        <br><br>

        <input type="checkbox" name="endrepo">
        <label for="id">hvilke nummer vill du endre:</label>
        <select name="endreid" id="endreid" for="endreid" type="text">

            <?php
            $query = "SELECT * FROM info";
            if ($result = mysqli_query($kobling, $query)) {
                while ($rad = mysqli_fetch_assoc($result)) {
                    $allid = $rad["id"];
                    echo "<option value=$allid>$allid</option>";
                }
            }
            ?>
        </select>

        <input id="endre" placeholder="Hva vill du endre till" type="text" name="endre">

        <br><br>

        <input type="checkbox" name="slett">
        <label for="id">hvilke rad vill du slette:</label>
        <select name="slettid" for="slettid" type="text">

            <?php
            $query = "SELECT * FROM info";
            if ($result = mysqli_query($kobling, $query)) {
                while ($rad = mysqli_fetch_assoc($result)) {
                    $allids = $rad["id"];
                    echo "<option value=$allids>$allids</option>";
                }
            }
            ?>
        </select>

        <br><br>
        <input id="button" type="submit" value="send inn">

    </form>

    <script src="script/script.js"></script>
</body>

</html>