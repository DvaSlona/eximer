<?php
include_once dirname(__FILE__) . '/config/authpostmaster.php';
  if ($_GET['confirm'] == '1') {
    # confirm that the user is deleting a group they are permitted to change before going further  
	$query = "SELECT * FROM groups WHERE id='{$_GET['group_id']}' AND domain_id='{$_SESSION['domain_id']}'";
	$result = $db->query($query);
	if ($result->numRows()<1) {
	  header ("Location: admingroup.php?group_faildeleted={$_GET['localpart']}");
	  die();  
	}
	
    # delete group member first
    $query = "DELETE FROM group_contents WHERE group_id='{$_GET['group_id']}'";
    $result = $db->query($query);
    if (!DB::isError($result)) {
      # delete group
      $query = "DELETE FROM groups
        WHERE id='{$_GET['group_id']}'
        AND domain_id='{$_SESSION['domain_id']}'";
      $result = $db->query($query);
      if (!DB::isError($result)) {
        header ("Location: admingroup.php?group_deleted={$_GET['localpart']}");
        die;
      } else {
        header ("Location: admingroup.php?group_faildeleted={$_GET['localpart']}");
        die;
      }
    } else {
      header ("Location: admingroup.php?group_faildeleted={$_GET['localpart']}");
      die;
    }
  } else if ($_GET['confirm'] == 'cancel') {
    header ("Location: admingroup.php?group_faildeleted={$_GET['localpart']}");
    die;
  }

$tmplVars['title'] = _('Confirm Delete');
include 'templates/header.php';
?>
    <div id="menu">
      <a href="admingroupadd.php"><?php echo _('Add Group'); ?></a><br>
      <a href="admin.php"><?php echo _('Main Menu'); ?></a><br>
      <br><a href="logout.php"><?php echo _('Logout'); ?></a><br>
    </div>
    <div id="Content">
      <form name="groupdelete" method="get" action="admingroupdelete.php">
        <table align="center">
          <tr>
            <td colspan="2">
              <?php printf (_('Please confirm deleting group %s@%s'),
                $_GET['localpart'],
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
              <input name='confirm' type='radio' value='1'><b>
              <?php printf (_('Delete %s@%s'),
                $_GET['localpart'],
                $_SESSION['domain']);
              ?></b>
            </td>
          </tr>
          <tr>
            <td>
              <input name='domain' type='hidden'
                value='<?php echo $_SESSION['domain']; ?>'>
              <input name='group_id' type='hidden'
                value='<?php echo $_GET['group_id']; ?>'>
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
