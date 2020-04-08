<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <?php  require_once("./web/templates/header.php") ?>
    </head>
    <body>

        <script>
            const UrlParams = <?php echo json_encode($GLOBALS['URL_VAR']); ?>;
            const UserParams = <?php echo json_encode($_SESSION['user']); ?>;
        </script>

        <div class='container-fluid'> 
            <?php  require_once($page) ?>
        </div>
        <footer>
            <?php  require_once("./web/templates/footer.php") ?>
        </footer>
    </body>
</html>
