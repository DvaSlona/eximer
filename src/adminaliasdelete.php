<?php
include_once dirname(__FILE__) . '/config/authpostmaster.php';
  if ($_GET['confirm'] == '1') {
    $query = "DELETE FROM users 
      WHERE user_id='{$_GET['user_id']}'
      AND domain_id='{$_SESSION['domain_id']}'
	  AND (type='alias' OR type='catch')";
    $result = $db->query($query);
    if (!DB::isError($result)) {
      header ("Location: adminalias.php?deleted={$_GET['localpart']}");
      die;
    } else {
      header ("Location: adminalias.php?faildeleted={$_GET['localpart']}");
      die;
    }
  } else if ($_GET['confirm'] == 'cancel') {
    header ("Location: adminalias.php?faildeleted={$_GET['localpart']}");
    die;
  }
$tmplVars['title'] = _('Confirm Delete');
include 'templates/header.php';
?>
    <div id="menu">
      <a href="adminaliasadd.php"><?php echo _('Add Alias'); ?></a><br>
      <a href="admin.php"><?php echo _('Main Menu'); ?></a><br>
      <br><a href="logout.php"><?php echo _('Logout'); ?></a><br>
    </div>
    <div id="Content">
      <form name="aliasdelete" method="get" action="adminaliasdelete.php">
        <table align="center">
          <tr>
            <td colspan="2">
              <?php printf (_('Please confirm deleting alias %s@%s'),
                $_GET['localpart'] ,
                $_SESSION['domain']);
              ?>:
            </td>
          </tr>
          <tr>
            <td>
              <input name='confirm' type='radio' value='cancel' checked>
              <b><?php printf (_('Do Not Delete %s@%s'),
                $_GET['localpart'],
                $_SESSION['domain']);
              ?></b>
            </td>
          </tr>
          <tr>
            <td>
              <input name='confirm' type='radio' value='1'>
              <b><?php printf (_('Delete %s@%s'),
                $_GET['localpart'],
                $_SESSION['domain']);
              ?></b>
            </td>
          </tr>
          <tr>
            <td>
              <input name='domain' type='hidden'
                value='<?php echo $_SESSION['domain']; ?>'>
              <input name='user_id' type='hidden'
                value='<?php echo $_GET['user_id']; ?>'>
              <input name='localpart' type='hidden'
                value='<?php echo $_GET['localpart']; ?>'>
              <input name='submit' type='submit'
                value='<?php echo _('Continue'); ?>'>
            </td>
          </tr>
        </table>
      </form>
    </div>
<?php
include 'templates/footer.php';
