<?php
/******************************************************************************
 * File:				record.delcommentfrom.php
 * Description:			form to delete user comment
 * Authors:				Thorsten Rinne <thorsten@phpmyfaq.de>
 * Date:				2003-02-23
 * Last change:			2004-11-01
 * Copyright:           (c) 2001-2004 Thorsten Rinne
 * 
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 * 
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 ******************************************************************************/

print "<h2>".$PMF_LANG["ad_entry_aor"]."</h2>\n";
if ($permission["delcomment"]) {
?>
	<form action="<?php print $_SERVER["PHP_SELF"].$linkext; ?>" method="post">
	<input type="hidden" name="aktion" value="deletecomment" />
	<input type="hidden" name="artid" value="<?php print $_REQUEST["artid"]; ?>" />
	<input type="hidden" name="cmtid" value="<?php print $_REQUEST["cmtid"]; ?>" />
	<input type="hidden" name="lang" value="<?php print $_REQUEST["lang"]; ?>" />
<?php
	$result = $db->query("SELECT usr, email, comment FROM ".SQLPREFIX."faqcomments WHERE id = '".$_REQUEST["artid"]."' AND id_comment = '".$_REQUEST["cmtid"]."'");
	list($usr,$eml,$cmt) = $db->fetch_row($result);
?>
    <p align="center"><?php print $PMF_LANG["ad_entry_delcom_1"]; ?> <a href="mailto:<?php print $eml; ?>"><?php print $usr; ?></a> <?php print $PMF_LANG["ad_entry_delcom_2"]; ?></p>
    <p align="center"><?php print $cmt; ?></p>
    <p align="center"><input class="submit" type="submit" value="<?php print $PMF_LANG["ad_gen_yes"]; ?>" name="subm" /> <input class="submit" type="submit" value="<?php print $PMF_LANG["ad_gen_no"]; ?>" name="subm" /></p>
	</form>
<?php
	}
else {
	print $PMF_LANG["err_NotAuth"];
	}
?>
