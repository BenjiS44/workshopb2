<?php
include 'bootstrap.php';
include_once 'Config.php';
$idU = $_GET['idU'];
$idR = $_GET['idR'];
$db = new PDO("mysql:host=" . Config::SERVEUR . ";dbname=" . Config::BASE, Config::UTILISATEUR, Config::MOTDEPASSE);
?>


<!DOCTYPE html>

<html>
    <head>
        <title>PageResto</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="restaurant.css" rel="stylesheet" type="text/css"/>
        <?php include_once 'CDN.php'; ?>
        <link href="Navbar.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="home_header">
            <div class="user_info">
                <img class="profile_pict_small" src="medias/user.jpg">
                <?php
                $req = $db->prepare("SELECT `LastName`, `FirstName` FROM `User` WHERE idUser=$idU");
                $req->execute();
                $name = $req->fetchAll();
                $nom = $name[0]['LastName'];
                $prenom = $name[0]['FirstName'];
                ?>
                <p class="profile_name"><?php echo $prenom . " " . $nom ?></p>
            </div>
            <div class="searchbar">
                <input class="search_bar" type="text" placeholder="Rechercher">
                <input class="search-btn" type="submit" value="Rechercher">
            </div>
            <div class="disconnect">
                <input class="disconnect-btn" type="button" value="Déconnexion">
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <?php
                $req = $db->prepare("SELECT `Nom` FROM `resto` WHERE idR=$idR");
                $req->execute();
                $nameR = $req->fetch();
                $nomR = $nameR[0];
                ?>
                <br>
                <br>

            </div>
        </div>
        <h1><?php echo $nomR ?></h1><br>
        <div class="ui horizontal list">
            <div class="item">
                <i class="marker icon"></i>
                <div class="content">
                    <?php
                    $req = $db->prepare("SELECT `Ville` FROM `resto` WHERE idR=$idR");
                    $req->execute();
                    $CityR = $req->fetch();
                    $VilleR = $CityR[0];
                    ?>
                    <?php echo $VilleR ?>
                </div>
            </div>
            <div class="item">
                <i class="phone icon"></i>
                <div class="content">
                    <?php
                    $req = $db->prepare("SELECT `Telephone` FROM `resto` WHERE idR=$idR");
                    $req->execute();
                    $PhR = $req->fetch();
                    $TelR = $PhR[0];
                    ?>

                    <a>0<?php echo $TelR ?></a>
                </div>
            </div>
            <div class="item">
                <i class="linkify icon"></i>
                <div class="content">
                    <?php
                    $req = $db->prepare("SELECT `Site` FROM `resto` WHERE idR=$idR");
                    $req->execute();
                    $WR = $req->fetch();
                    $SiteR = $WR[0];
                    ?>

                    <a href="<?php echo $SiteR ?>">Le Site Internet</a>
                </div>
            </div>
            <div class="item">
                <i class="marker icon"></i>
                <div class="content">
                    <?php
                    $sqa = $db->prepare("SELECT COUNT(*) FROM avis where idU=$idU & idR=$idR");
                    $sqa->execute();
                    $tokken = $sqa->fetch();
                    if ($tokken[0] < 1) {
                        ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            Tokken +1
                        </button>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                Col1
            </div>
            <div class="col-md-1">
                Col2
            </div>
            <div class="col-md-2">
                Col3
            </div>
            <div class="col-md-1">
                Col4
            </div>

        </div>

        <div class="row">
            <div class="col-md-2">
                Col1
            </div>
            <div class="col-md-1">
                Col2
            </div>
            <div class="col-md-2">
                Col3
            </div>
            <div class="col-md-1">
                Col4
            </div>

        </div>

        <div class="row">
            <div class="col-md-2">
                Col1
            </div>
            <div class="col-md-1">
                Col2
            </div>
            <div class="col-md-2">
                Col3
            </div>
            <div class="col-md-1">
                Col4
            </div>

        </div>

        <div class="row">
            <div class="col-md-2">
                Col1
            </div>
            <div class="col-md-1">
                Col2
            </div>
            <div class="col-md-2">
                Col3
            </div>
            <div class="col-md-1">
                Col4
            </div>

        </div>
        <br>
        <?php
        $sql = $db->prepare("SELECT `Adresse`, `Code_Postal`, `Ville` FROM `resto` WHERE idR=$idR");
        $sql->execute();
        $result = $sql->fetchAll();
        $address = $result[0]['Adresse'] . " " . $result[0]['Code_Postal'] . " " . $result[0]['Ville'];


        //$address = "16 Boulevard Général de Gaulle, 44200 Nantes";
        echo '<iframe width="100%" height="170" frameborder="0" src="https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . str_replace(",", "", str_replace(" ", "+", $address)) . '&z=14&output=embed"></iframe>';
        ?>

        <h1>Commentaires</h1>
        <br>

        <?php
        $nombreA = "SELECT COUNT(*) AS nb FROM Avis where idR=$idR";
        $fromage = $db->query($nombreA);
        $columns = $fromage->fetch();
        $nb = $columns['nb'];
        for ($i = 0; $i < $nb; $i++) {
            $sql = $db->prepare("SELECT * FROM `avis` join `user` on user.idUser=avis.idU WHERE idR=$idR");
            $sql->execute();
            $comment = $sql->fetchAll();
            $nomU = $comment[$i]['FirstName']." ".$comment[$i]['LastName'];
            echo $nomU;
            echo '<br>';
            echo $comment[$i]['Avis'];
        }
            ?>






            <!--------------------------------------Popup---------------------------------------------------------------------------->

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Ajouter un commentaire (facultatif)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  action="CreationPost.php?idU=<?php echo $idU ?>&idR=<?php echo $idR ?>" method="post">

                            <div id="objet" class="form-group">

                                <label for="Commentaire">Commentaire</label>

                                <input type="text" class="form-control" name="Commentaire">
                                <!-- <div class="form-group">
                                                      <label for="inputdefault">Nom</label>
                                                      <input type='text' name='Nom' required placeholder="Votre nom d'utilisateur">-->
                            </div>
                            <div id="boutonform">
                                <input class="btn btn-outline-secondary" type="submit" value="Envoyer">
                            </div>

                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>