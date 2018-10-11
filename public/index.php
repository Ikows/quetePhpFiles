<?php
// Dossier dans lequel iront les images
$uploadDir = 'images/';

if (isset($_POST['Send']))
{

    for($i=0; $i<count($_FILES['fichier']['name']); $i++) //boucle pour chaque fichier
    {
        if ($_FILES['fichier']['size'][$i] < 1000000) // Validation de la taille en octets
        {
            if (isset($_FILES['fichier']['type'][$i]))  //Validation de la présence d'un fichier
            {
                if (in_array($_FILES['fichier']['type'][$i], array('image/gif', 'image/png', 'image/jpg', 'image/jpeg'))) // Validation du format de fichier
                {
                    $uploadFile = $uploadDir . 'image' . uniqid() . '.' . pathinfo($_FILES['fichier']['name'][$i], PATHINFO_EXTENSION); //préparation du nommage du fichier et du chemin d'acces
                    $ok = move_uploaded_file($_FILES['fichier']['tmp_name'][$i], $uploadFile); //Déplacement du ficher depuis le fichier temp jusqu'au repertoire final

                } else
                {
                    $typeError = "Mauvais type de fichier";
                }
            }
        }else
        {
            $sizeError = "Taille de fichier trop importante";
        }


    }

}
/**
 * Deleting files
 */
if (isset($_GET["d"]))
{
    unlink('images/' . $_GET["d"]);
}



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
<center style="padding-top: 300px">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fichier[]" multiple="multiple" />
        <input type="submit" name="Send" value="Send" />

    <br><br>
    <?php if (isset($typeError)){echo '<h1 style="color: red;">' . $typeError . '</h1>';}
          if (isset($sizeError)){echo '<h1 style="color: red;">' . $sizeError . '</h1>';}
          if (isset($ok)){echo '<h1 style="color: green;">Fichier(s) uploadé(s) !</h1>';}
    ?>
    </form>
</center>
<br>
<hr><br>


<div class="container">
    <div class="row justify-content-around">
        <?php
        $it = new FilesystemIterator('images/');
        foreach ($it as $fileinfo)
        {
        ?>
        <div class="col-2">
            <img src="images/<?= $fileinfo->getFilename()?>" alt="htr" class="img-thumbnail">
            <center><a href="index.php?d=<?= $fileinfo->getFilename()?>"><button>Delete</button></a></center>
        </div>
        <?php } ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>