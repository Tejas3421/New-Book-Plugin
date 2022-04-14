<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  http://localhost/WordPress/
 * @since 1.0.0
 *
 * @package    Book_Plugin
 * @subpackage Book_Plugin/admin/partials
 */
?>
<html>
    <h2>Hii This is Book Setting Page</h2>
    <h4>Here you can set your currency no of post per page</h4>
    <form method=post>
        <div id='currency-container'>
            <label for="currency">Currency</label>
            <select id="currency" name="currency">
                <option value="₹">₹</option>
                <option value="$">$</option>
                <option value="€">€</option>
            </select>
        </div><br><br>
        <div id='no_of_post'>
            <label>No of Post Per page</label>
            <input type='number' id='no_of_post'><br><br>
        </div><br>
        <input type="submit" class="button-primary" value='<?php 'Save changes'; ?>' />
    <form>
</html>
<?php
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
