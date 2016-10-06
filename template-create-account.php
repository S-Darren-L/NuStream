<?php

/*
Template Name: Create Account
*/

get_header();
?>

<div style="overflow-x:auto;">
    <form method="post">
        <table class="account-temp-table">
            <tr>
                <td class="title" colspan="2"><a>Email</a></td>
                <td class="content" colspan="10"><input class="input" type="text" name="email"></td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>First Name</a></td>
                <td class="content" colspan="4"><input class="input" type="text" name="firstName"></td>
                <td class="title" colspan="2"><a>Contact Number 1</a></td>
                <td class="content" colspan="4"><input class="input" type="text" name="LastName"></td>
            </tr>
            <tr>
                <td class="title" colspan="2"><a>Position</a></td>
                <td class="content" colspan="10">
                    <select class="drop-down" name="position">
                        <option value="ADMIN">Administrator</option>
                        <option value="AGENT">Agent</option>
                        <option value="ACCOUNTANT">Accountant</option>
                    </select>
                </td>
            </tr>
<!--            <tr>-->
<!--                <td class="title" colspan="2"><a>First Name</a></td>-->
<!--                <td class="small-sub-title" colspan="2"><a>Staging</a></td>-->
<!--                <td class="radio"><input type="radio" name="supplierType" value="STAGING"></td>-->
<!--                <td class="small-sub-title" colspan="2"><a>Photography</a></td>-->
<!--                <td class="radio"><input type="radio" name="supplierType" value="PHOTOGRAPHY"></td>-->
<!--                <td class="small-sub-title" colspan="2"><a>Clean up</a></td>-->
<!--                <td class="radio"><input type="radio" name="supplierType" value="CLEANUP"></td>-->
<!--                <td class="small-sub-title" colspan="2"><a>Relocate home</a></td>-->
<!--                <td class="radio"><input type="radio" name="supplierType" value="RELOCATEHOME"></td>-->
<!--            </tr>-->
            <tr>
                <td class="title" colspan="2"><a>Contact Number</a></td>
                <td class="content" colspan="10"><input class="input" type="text" name="contactNumber"></td>
            </tr>
        </table>
        <input type="submit" value="Create" name="create_supplier">
    </form>
</div>

<?php
get_footer();

?>
