<?php include 'header.php'; ?>

    <div id="Centered">
    <form style="margin-top:3em;" name="login" method="post" action="login.php">
        <table align="center">
            <tr>
                <td>
                    <label for="username-input"><?php echo _('Username'); ?></label>:
                </td>
                <td>
                    <input name="localpart" id="username-input" type="text" class="textfield"
                        autofocus> @
                </td>
                <td>
                    <?php
                    if ('dropdown' == $settings['domaininput'])
                    {
                        ?>
                        <select name="domain" class="textfield">
                            <option></option>
                            <?php foreach ($domains as $domain): ?>
                            <option><?php echo $domain->getName(); ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php
                    }
                    elseif ('textbox' == $settings['domaininput'])
                    {
                        ?>
                        <input type="text" name="domain" class="textfield">
                        <?php
                        _('(domain name)');
                    }
                    elseif ('static' == $settings['domaininput'])
                    {
                        echo $domain->getName();
                        ?>
                        <input type="hidden" name="domain" value="<?php echo $domain->getName(); ?>">
                        <?php
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
                    <button name="submit" type="submit" class="longbutton"><?php echo _("Submit"); ?></button>
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

include 'footer.php';

