<?php
/**
 * File: views/categories_demo.php
 * 
 * This demo provides a working example of using nested sets to
 * read and manipulate hierarchical data in Code Igniter
 * Please see the documentation for more info
 *
 * @author Thunder <ravenvelvet@gmail.com>
 * @copyright (c)2007 Thunder
 * @package Nested_sets
 * @subpackage Categories_demo
 */
 

?>
<html>
<head>
<title>Categories Demo</title>
<style type="text/css">
BODY {
    font-family: Tahoma, Arial, Helvetica;
    font-size: 12px;
    color:#666666;
    background: #666666; 
    
}


H3 {
    font-family: Tahoma, Arial, Helvetica;
    font-weight: bold;
    font-size: 14px;
    color:#c60000;
}
#content {
    width: 600px;
    border: dashed 1px #cccccc;
    margin: auto;
    padding: 10px;
    background:#ffffff; 
}
.seperator {
    border-top: solid 1px #999999;
}

.formTitle {
    font-weight: bold;
}
.formInput {
    padding: 2px;
}

</style>
</head>
<body>
<div id="content">
<h3>Nested Sets demo using categories</h3>
<p> HTML representation of the tree, using spaces to represent the levels </p>
<p> <?=$treehtml?> </p>

<div class="seperator">
    <h3>Add a new category</h3>
</div>

<form name="form1" method="post" action="/categories_demo/insert_category">
    <p class="formTitle">Category Name: <input type="text" name="categoryname"></p>
    <p class="formTitle">As sub category of: <?=$categorySelect?></p>
    <p class="formInput"><input type="submit" name="addcat" value="Add Category"></p>
</form>


<div class="seperator">
    <h3>Move category</h3>
</div>

<form name="form2" method="post" action="/categories_demo/move_category">
    <p class="formTitle">Which category: <?=$moveCategorySourceSelect?></p>
    <p class="formTitle">How?:<br />
    <input type="radio" name="move_mode" value="firstchild">As first child of 
    <input type="radio" name="move_mode" value="lastchild">As last child of
    <input type="radio" name="move_mode" value="prevsibling">As previous sibling of
    <input type="radio" name="move_mode" value="nextsibling">As next sibling of
    </p>
    <p class="formTitle">Target category: <?=$moveCategoryTargetSelect?></p>
    <p class="formInput"><input type="submit" name="domove" value="perform move"></p>
</form>

<div class="seperator">
    <h3>Delete a category</h3>
</div>
<p>Delete a category and all of its children</p>

<form name="form3" method="post" action="/categories_demo/delete_category">
    <p class="formTitle">Select category to delete: <?=$deleteSelect?></p>
    <p class="formInput"><input type="submit" name="delete" value="Remove category"></p>
</form>

</div>
</body>
</html>
