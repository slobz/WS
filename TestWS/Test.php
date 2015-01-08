<!-- Ahout user -->
<form action="../index.php" method="POST">
    Login: <input type="text" name="login"/></br>
    MDP: <input type="text" name="pwd"/></br>
    <input type="hidden" name="service" value="utilisateur"/>
    <input type="hidden" name="methode" value="add"/>
    <input type="submit" text="k">
</form>

<br/><br/><br/>

<!-- Ajout Commentaire -->
<form action="../index.php" method="POST">
    Message: <input type="text" name="texte"/></br>
    Note   : <input type="text" name="note"/><br/>
    <input type="hidden" name="methode" value="add"/>
    <input type="hidden" name="idUser" value="8"/>
    <input type="hidden" name="idResto" value="1"/>
    <input type="hidden" name="service" value="commentaire"/>
    <input type="submit" text="ajouter">
</form>

<!-- Ajout restaurant -->
<form action="../index.php" method="POST">
    Nom: <input type="text" name="nom"/></br>
    Desc   : <input type="text" name="description"/><br/>
    X   : <input type="text" name="x"/><br/>
    Y   : <input type="text" name="y"/><br/>
    Rue   : <input type="text" name="rue"/><br/>
    CP   :  <input type="text" name="cp"/><br/>
    VILLE   : <input type="text" name="ville"/><br/>
    IMG. B64 <input type="text" name="img1"/>
    
    
    <input type="hidden" name="methode" value="add"/>
    <input type="hidden" name="service" value="restaurant"/>
    <input type="submit" text="ajouter">
</form>

<!-- Ajout image -->
<form action="../index.php" method="post">
    IMG. B64 <input type="text" name="image"/>
    <input type="hidden" name="idRestaurant" value="1"/>
    <input type="hidden" name="nom" value="yolo"/>
    <input type="hidden" name="service" value="image"/>
    <input type="hidden" name="methode" value="add"/>
    <input type="submit" text="k">
    <input type="submit" text="ajouter">
</form>


<!-- Test Regex -->
<?php
echo preg_match("/^[a-zA-Z0-9]{6,15}$/", "2435434dsdé");
echo "<br/>";

echo preg_match("/^.{6,60}$/", "fdsfddsqdsqdqsd:;,:;-'(-'");
echo "<br/>";



?>