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

