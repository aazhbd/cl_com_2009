<?php /* Smarty version 2.6.26, created on 2010-01-22 02:33:32
         compiled from moresearch_view.tpl */ ?>
<div style="width:745px;">
<div id="pginfo">
    Here you can Search People by their profile information, Email etc. You can add people as friends from search results. If they approve, then you can become friends with them. You can also send messages to people.
</div>
<br />
<?php if ($this->_tpl_vars['searchtype'] == 'People'): ?>

<form name="srchform" id="srchform" method="post" action="<?php echo @URL; ?>
/moresearchpost.php">
    <fieldset>
    <legend>Enter your search text and/or select the category for searching people</legend>
        <input type="hidden" name="email" value="<?php echo $this->_tpl_vars['data']['user_email']; ?>
" />
        
        <div style="font-weight:bold; font-size: 16px; float:left: width:98%;  margin-top: 10px; color:#069; ">Personal Information</div>
        
        <div>
            <div style="float:left;width:150px;"><label for="name">Name:</label></div>
            <span><input type="text" name="name" id="name" style="float:left; width:200px;" /></span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="sex">Sex:</label></div>
            <span>
                <select name="sex" id="sex" style="float:left; width:200px;">
                     <option value=""></option>
                     <option value="m">Male</option>
                     <option value="f">Female</option>
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="rel_status">Relationship Status:</label></div>
            <span>
                <select name="rel_status" id="rel_status" style="float:left; width:200px;">
                     <option value=""> </option>
                        <?php $_from = $this->_tpl_vars['data']['relStatusList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['status']):
?>
                            <option value="<?php echo $this->_tpl_vars['status']; ?>
"><?php echo $this->_tpl_vars['status']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="user_email">Email:</label></div>
            <input type="text" name="user_email" id="user_email"  style="float:left; width:202px;"/>
        </div>        
        <div>
            <div style="float:left;width:150px;"><label for="year">Birth Year:</label></div>
            <span>
                <select name="year" id="year" style="width:200px; float:left;">
                    <option value=""></option>
                    <?php unset($this->_sections['y']);
$this->_sections['y']['name'] = 'y';
$this->_sections['y']['start'] = (int)1950;
$this->_sections['y']['loop'] = is_array($_loop=2051) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['y']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['y']['show'] = true;
$this->_sections['y']['max'] = $this->_sections['y']['loop'];
if ($this->_sections['y']['start'] < 0)
    $this->_sections['y']['start'] = max($this->_sections['y']['step'] > 0 ? 0 : -1, $this->_sections['y']['loop'] + $this->_sections['y']['start']);
else
    $this->_sections['y']['start'] = min($this->_sections['y']['start'], $this->_sections['y']['step'] > 0 ? $this->_sections['y']['loop'] : $this->_sections['y']['loop']-1);
if ($this->_sections['y']['show']) {
    $this->_sections['y']['total'] = min(ceil(($this->_sections['y']['step'] > 0 ? $this->_sections['y']['loop'] - $this->_sections['y']['start'] : $this->_sections['y']['start']+1)/abs($this->_sections['y']['step'])), $this->_sections['y']['max']);
    if ($this->_sections['y']['total'] == 0)
        $this->_sections['y']['show'] = false;
} else
    $this->_sections['y']['total'] = 0;
if ($this->_sections['y']['show']):

            for ($this->_sections['y']['index'] = $this->_sections['y']['start'], $this->_sections['y']['iteration'] = 1;
                 $this->_sections['y']['iteration'] <= $this->_sections['y']['total'];
                 $this->_sections['y']['index'] += $this->_sections['y']['step'], $this->_sections['y']['iteration']++):
$this->_sections['y']['rownum'] = $this->_sections['y']['iteration'];
$this->_sections['y']['index_prev'] = $this->_sections['y']['index'] - $this->_sections['y']['step'];
$this->_sections['y']['index_next'] = $this->_sections['y']['index'] + $this->_sections['y']['step'];
$this->_sections['y']['first']      = ($this->_sections['y']['iteration'] == 1);
$this->_sections['y']['last']       = ($this->_sections['y']['iteration'] == $this->_sections['y']['total']);
?>
                        <option value="<?php echo $this->_sections['y']['index']; ?>
"><?php echo $this->_sections['y']['index']; ?>
</option>
                    <?php endfor; endif; ?>                    
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="month">Birth Month:</label></div>
            <span>
                <select name="month" id="month" style="width:200px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['monthList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['m']):
?>
                        <option value="<?php echo $this->_tpl_vars['k']; ?>
"><?php echo $this->_tpl_vars['m']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>                    
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Religion:</label></div>
            <span>
                <select name="religion" id="religion" style="width:202px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['data']['religionList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                        <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>            
            <div style="float:left;width:80px;margin-left:25px;"><label for="religion">Language:</label></div>
            <span>
                <select name="language" id="language" style="width:202px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['data']['languageList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                        <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Interests:</label></div>
            <span><input type="text" name="interests" id="interests" style="width:200px; float:left;" /></span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="religion">Favorites:</label></div>
            <span><input type="text" name="favorites" id="favorites" style="width:200px; float:left;" /></span>
        </div>        
        
        <div style="font-weight:bold; float:left: width:98%; margin-top: 10px; font-size: 16px; color:#069;">Contact Information</div>
        
        <div>
            <div style="float:left;width:150px;"><label for="country">Country:</label></div>
            <span>
                <select name="country" id="country" style="width:200px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['data']['countryList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                        <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="city">City:</label></div>
            <span>
                <select name="city" id="city" style="width:200px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['data']['cityList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                        <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Address:</label></div>
            <span><input type="text" name="address" id="address" style="float:left; width:200px;" /></span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="home_town">Hometown:</label></div>
            <span>
                <select name="home_town" id="home_town" style="width:202px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['data']['htownList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                        <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
        </div>
        
        <div style="font-weight:bold; float:left: width:98%; margin-top: 10px; font-size: 16px; color:#069;">Education and Work Information</div>
        
        <div>
            <div style="float:left;width:150px;"><label for="religion">Educational Info:</label></div>
            <span><input type="text" name="eduinfo" id="eduinfo" style="width:200px; float:left;" /></span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="religion">Work Info:</label></div>
            <span><input type="text" name="workinfo" id="workinfo" style="width:200px; float:left;" /></span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Occupation:</label></div>
            <span>
                <select name="occupation" id="occupation" style="width:202px; float:left;">
                    <option value=""></option>
                    <?php $_from = $this->_tpl_vars['data']['occupationList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                        <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="weburl">Web URL:</label></div>
            <span><input type="text" name="weburl" id="weburl" style="width:200px; float:left;" /></span>                        
        </div>
        <div>
            <input type="hidden" name="searchtype" id="searchtype" size="40" value="<?php echo $this->_tpl_vars['searchtype']; ?>
" />
            <div style="float:left;width:150px;"><label for="submit">&nbsp;</label></div>
            <span><input type="submit" name="submit" id="button" value="Search" class="frmbtn"/>
            <input type="reset" name="reset" id="button" value="Reset" class="frmbtn" /></span>
        </div>
        </fieldset>
</form>
<?php endif; ?>
</div>