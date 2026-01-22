<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let's Read Presentation</title>
    <link rel="stylesheet" href="./presentation.css">
</head>
<body>
    <br><br><br>
    <h1>Let's Read📚📖</h1>
    <h3>
        Un site de librairie en ligne où vous pourriez télécharger ou acheter vos livres <br>
        En toute sécurité et respecte vos droit de critique😁
    </h3>
    <br><br>
    <button id="connexion" onclick="document.getElementById('id01').style.display='block' ">Connexion</button>

    <!-- Le popup login-->
<div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'"
  class="close" title="Close Modal">&times;</span>
  
    <!-- Modele-->
    <form class="modal-content animate" action="PageBienvenu.html">
      <div class="imgcontainer">
        <img src="avatar2.png" alt="Avatar" class="avatar">
      </div>
  
      <div class="container">
        <label for="uname"><b>Anarana</b></label>
        <input type="text" placeholder="Anarana" name="uname" required>
  
        <label for="psw"><b>Teny Miafina</b></label>
        <input type="password" placeholder="ampidiro ny teny miafina" name="psw" required>
  
        <button id="login" type="submit">Login</button>
        <label>
          <input type="checkbox" checked="checked" name="remember"> Tadidio aho
        </label>
      </div>
  
      <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Hiverina</button>
        <span class="psw">adino<a href="#"> teny miafina?</a></span>
      </div>
    </form>
</div>

</body>
</html>