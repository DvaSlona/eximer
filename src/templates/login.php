<div id="Centered">
    <form style="margin-top:3em;" name="login" method="post" action="login.php">
        <table align="center">
            <tr>
                <td>
                    <label for="username-input"><?php echo _('Username'); ?></label>:
                </td>
                <td>
                    <input name="localpart" id="username-input" type="text" class="textfield"
                        autofocus>&nbsp;@&nbsp;
                </td>
                <td>
                    <?php
                    $domain = preg_replace ("/^mail\./", "", $_SERVER["SERVER_NAME"]);
                    if ($domaininput == 'dropdown')
                    {
                        $query = "SELECT domain FROM domains WHERE type='local' AND domain!='admin' ORDER BY domain";
                        $result = $db->query($query);
                        ?>
                        <select name="domain" class="textfield">
                        <option value=''>
                        <?php
                        if ($result->numRows())
                        {
                            while ($row = $result->fetchRow())
                            {
                                print "<option value='{$row['domain']}'>{$row['domain']}"
                                    . '</option>';
                            }
                        }
                        print '</select>';
                    }
                    elseif ($domaininput == 'textbox')
                    {
                        print '<input type="text" name="domain" class="textfield"> (domain name)';
                    }
                    elseif ($domaininput == 'static')
                    {
                        print $domain
                            . '<input type="hidden" name="domain" value='
                            . $domain
                            . '>';
                    }
                ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo _("Password"); ?>:
                </td>
                <td>
                    <input name="crypt" type="password" class="textfield">
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center;padding-top:1em">
                    <input name="submit" type="submit"
                        value="<?php echo _("Submit"); ?>" class="longbutton">
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
if (isset($_GET['login']) && ($_GET['login'] == "failed"))
{
    print "<div id='status'>" . _("Login failed") . "</div>";
}

