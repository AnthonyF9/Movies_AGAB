<?php
$title = 'Gestion des utilisateurs de Movies AGAB';
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}

?>

      <main>
        <div id="gamma">
          <h1></h1>
          <?php
          $sql = "SELECT * FROM users WHERE 1=1 ORDER BY created_at";
          $query = $pdo->prepare($sql);
          $query->execute();
          $users = $query->fetchAll();
          ?>
          <table class="list-users">
            <tr>
              <th>Non d'utilisateur</th>
              <th>Email</th>
              <th>Créé le</th>
              <th>Rôle</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($users as $user) { ?>
              <tr>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['created_at'] ?></td>
                <td><?php echo $user['role'] ?></td>
                <td>
                  <span><a href="back-modif-user.php?token=<?php echo $user['token'] ?>">Modifier</a> </span>
                  <span><a href="back-delete-user.php?token=<?php echo $user['token'] ?>">Supprimer</a></span>
                </td>
              </tr>
              <?php
            }
            ?>
          </table>
        </div>
      </main>

<?php
include_once('./inc/footer.php');
?>
