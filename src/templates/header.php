<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php
            echo _('Eximer');
            if (null !== $tmplVars['title'])
            {
                echo ': ' . $tmplVars['title'];
            }
        ?></title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
