<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File: models/Categories_model.php
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
 
class Categories_demo_model extends Nested_sets_model 
{
    
    function Categories_demo_model() {
    
        parent::__construct();
        
        // Initialise parameters to configure the Nested_sets model
        // to interact with the categories table. This extension class
        // is the thing that defines the role of the nested sets model
        
        // The three parameters passed in here are:
        //  1) the table name
        //  2) the column name representing the "left value"
        //  3) the column name representing the "right value"
        $this->setControlParams('categories_demo','leftval','rightval');
        
        // Here we tell the nested sets model which column is used as the
        // primary key. In our example, it's the auto_incrementing "categoryid"
        // column in the categories table.
        $this->setPrimaryKeyColumn('categoryid');
    }
    
    /**
     * Returns a form select / drop down.
     * Provide the form field name and this method will return an HTML snippet
     * suitable for using in a form
     * @param string $fieldname The form field name to use
     * @return string Html snippet appropriate for an HTML form
     */
    function getCategorySelect($fieldname) 
    {
        $retVal = "<select name=\"$fieldname\">\n";
        $cats_handle = $this->getTreePreOrder($this->getRoot());
        
        if(!empty($cats_handle['result_array'])) {
            while($this->getTreeNext($cats_handle)) 
            {
                // get indent value
                $indent = (str_repeat("&nbsp;", $this->getTreeLevel($cats_handle)*2));
                $retVal .= "<option value=\""  .$cats_handle['row']['categoryid'] . "\">$indent".$cats_handle['row']['categoryname']."</option>\n";
                
            }
        }
        
        $retVal .= "</select>\n";
        return $retVal;
        
    
    }
    
    /**
     * Overrides the nested_sets_model method to define the dataset field to
     * display in the tree by passing array("categoryname") to the getSubTree 
     * method
     * @return string html snippet representing the tree
     */
    function getTreeAsHTML()
    { 
        return $this->getSubTreeAsHTML($this->getRoot(), array("categoryname"));
    }
}
?>
