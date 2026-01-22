<?php 

    require_once('./../configDb/database.php');
    session_start();

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['btn_login'])) {
                if (isset($_POST['nom_membre']) && isset($_POST['mdp_membre'])) {
                    
                    $nom_membre = trim($_POST['nom_membre']);
                    $mdp_membre = trim($_POST['mdp_membre']);

                    if (!empty($nom_membre && $mdp_membre)) {
                        
                        $query = "SELECT * FROM membre WHERE nom_membre = :nom_membre AND mdp_membre = :mdp_membre";
                        $stmt = $connection->prepare($query);
                        $stmt->bindValue(':nom_membre', $nom_membre);
                        $stmt->bindValue(':mdp_membre', $mdp_membre);
                        $stmt->execute();
                        $membre = $stmt->fetch();

                        if ($membre) {
                            $_SESSION['id_membre'] = $membre['id_membre'];
                            $_SESSION['nom_membre'] = $membre['nom_membre'];
                            $_SESSION['role'] = $membre['role'];
                            if ($_SESSION['role'] === 'membre'){
                            echo "<script>
                                    alert('Connexion réussie $_SESSION[nom_membre]');
                                    window.location.href = './../accueil.php';
                                    </script>";
                            } else {
                                echo "<script>
                                alert('Connexion réussie $_SESSION[nom_membre]');
                                window.location.href = './../livre/admin.php';
                              </script>";
                            }
                        }else {
                            echo "<script>
                                alert('information incompatible, inscrivez vous');
                                window.location.href = './../authentification/login.php';
                              </script>";
                        }
                    }

                }
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

?>