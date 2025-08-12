<?php 
	require_once dirname(__DIR__).'/inc/init.php';
?>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const RACINE = "<?php echo RACINE_SITE; ?>";
    const  node_env = "<?php echo NODE_ENV; ?>";
</script>
<script src="<?php echo RACINE_SITE.'js/backoffice.js' ?>"></script>
</body>
</html>