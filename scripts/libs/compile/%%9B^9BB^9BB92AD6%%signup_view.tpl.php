<?php /* Smarty version 2.6.26, created on 2010-03-24 02:23:46
         compiled from signup_view.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
        $(\'#birthdate\').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: \'1900:2010\'
        });       
   });
</script>
'; ?>

<div style="width:735px;">
    <div id="errors"></div>
    <?php if ($this->_tpl_vars['msg'] != null): ?>
        <div id="admininfo">
            <?php echo $this->_tpl_vars['msg']; ?>

        </div>
    <?php endif; ?>
    <p class="subtitle">Conveylive.com ensures your privacy; to know more, check our <a href="<?php echo @URL; ?>
/static/privacy">Privacy Policy</a>.</p>
    <form id="frmsignup" method="post" action="<?php echo @URL; ?>
/signup.php">
        <fieldset title="Signup form">
            <legend><b>Let us know about you!</b></legend>
            <div>
                <span>
                    <div style="float:left; width:80px;">
                        <label for="fname">First Name:</label>
                    </div>
                    <input type="text" name="fname" id="fname" style="width:200px;" />
                    <label style="margin-left:50px;" for="lname">Last Name:</label>
                    <input type="text" name="lname" id="lname" style="margin-left:20px; width:200px;"/>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:80px;"><label for="email">Email:</label></div>
                    <input type="text" name="email" id="email" style="width:200px;" />
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:80px;"><label for="password">Password:</label></div>
                    <input type="password" name="password" id="password" style="width:200px;" />
                    <label style="margin-left:50px;" for="rpass">Re-type:</label>
                    <input type="password" name="rpass" id="rpass" style="margin-left:35px; width:200px;" />
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:80px;"><label for="sex">Sex: </label></div>
                    <select name="sex" id="sex" style="width:198px;">
                        <option value="">Select</option>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select>
                    <label style="margin-left:55px;">Birth Date: </label>
                    <input type="text" id="birthdate" name="birthdate" style="margin-left:20px; width:200px;" />
                </span>
            </div>
            <div>
                <span class="ad" align="left">
                    <label for='agree'><input type="checkbox" name="agree" value="1" style="border: none;" id="agree"/>
                    I agree with the <a href='<?php echo @URL; ?>
/static/privacy'>Privacy Policy</a> and <a href='<?php echo @URL; ?>
/static/terms'>Terms and Conditions</a>
                    </label><br/>
                </span>
            </div>
            <div>
                <span align="left">
                    <input type="submit" name="submit" id="button" value="Sign up" class="frmbtn"/>
                    <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                </span>
            </div>
        </fieldset>
    </form>
</div>

<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmsignup").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               fname:{ required: true , maxlength: 50 },
               lname:{ required: true , maxlength: 50 },
               email:{ required: true, email: true , maxlength: 50},
               password:{ required: true, minlength: 5 , maxlength: 20},
               rpass:{ required: true, minlength: 5, maxlength: 20, equalTo: "#password" },
               sex:{ required: true },
               birthdate:{required:true },
               agree: { required:true }
           },
           messages:{
               fname: "Please enter your first name.",
               lname: "Please enter your last name.",
               email: "Please enter a valid email address.",
               password: "Please enter a minimum 5 character password",
               rpass: {
                   required: "Your re-typed password does not match the new password you entered.",
                   minlength: "Password must be at laest 5 characters long"
               },
               sex: "Please select sex",
               birthdate: "Please provide your birthdate",
               agree: "You must select the checkbox to agree to our terms and conditions before you signup"
           }
       });
   });
</script>
'; ?>