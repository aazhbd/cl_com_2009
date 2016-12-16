<?php /* Smarty version 2.6.26, created on 2010-02-15 11:57:37
         compiled from subtpl/friend_js.tpl */ ?>
<?php echo '           
<script type="text/javascript">
$(document).ready(function(){ 
    $("#to").tokenInput("'; ?>
<?php echo @URL; ?>
<?php echo '/getfriends.php", {
        classes: {
            tokenList: "token-input-list-facebook",
            token: "token-input-token-facebook",
            tokenDelete: "token-input-delete-token-facebook",
            selectedToken: "token-input-selected-token-facebook",
            highlightedToken: "token-input-highlighted-token-facebook",
            dropdown: "token-input-dropdown-facebook",
            dropdownItem: "token-input-dropdown-item-facebook",
            dropdownItem2: "token-input-dropdown-item2-facebook",
            selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
            inputToken: "token-input-input-token-facebook"
        }
    });
});
</script>
'; ?>