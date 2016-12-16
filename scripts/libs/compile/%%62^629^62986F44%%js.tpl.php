<?php /* Smarty version 2.6.26, created on 2011-01-29 19:55:46
         compiled from subtpl/js.tpl */ ?>

<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery.livequery.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery.alerts.js" ></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/editor/tiny_mce.js" ></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/player/flowplayer-3.2.4.min.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery.tokeninput.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/scripts/js/jquery.fancybox-1.2.6.pack.js"></script>
<?php echo '
<script type="text/javascript">
    var site = new Object();
    site.url = "'; ?>
<?php echo @URL; ?>
<?php echo '"; 
    $(document).ready(function() {
        $(\'li\').hover(function() {
                $(this).addClass(\'hover\');
            }, function() {
                $(this).removeClass(\'hover\');
            }
        );
    });
</script>
'; ?>