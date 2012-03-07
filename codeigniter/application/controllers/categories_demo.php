<?php
/**
 * File: controllers/categories_demo.php
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
 
class Categories_demo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        
        // Load the nested sets "base" model
	    $this->load->model('nested_sets_model');
        
        // Load the purpose specific extension model class
        $this->load->model('categories_demo_model','cats');
        
    }
	
	function index()
	{
        // Simply call the page display method
        $this->_render_page();
    }
    
    function insert_category()
    {
        $category_name = trim($this->input->post('categoryname'));
        $parentid = (int)$this->input->post('categoryid');
        $parentNode = $this->cats->getNodeFromId($parentid);
        
        $fields_array = array("categoryname"=>$category_name);
        $this->cats->appendNewChild($parentNode,$fields_array);
        
        $this->_render_page();
    }
    
    function move_category() 
    {
        // which category to move and where to
        $srcid = (int)$this->input->post('sourceid');
        $dstid = (int)$this->input->post('targetid');
        
        // get the corresponding node data
        $sourceNode = $this->cats->getNodeFromId($srcid);
        $targetNode = $this->cats->getNodeFromId($dstid);
        
        // now switch on mode to identify how to effect the move
        $mode = $this->input->post('move_mode');
        switch($mode) {
            case "firstchild":
                $method = "setNodeAsFirstChild";
                break;
            case "lastchild":
                $method = "setNodeAsLastChild";
                break;
            case "prevsibling":
                $method = "setNodeAsPrevSibling";
                break;
            case "nextsibling":
                $method = "setNodeAsNextSibling";
                break;
        }
        
        // Now to effect the move
        $this->cats->$method($sourceNode,$targetNode);
        
        $this->_render_page();
        
    }
    
    
    function delete_category()
    {
        // get the categoryid of the chosen category
        $deleteid = (int) $this->input->post('deleteid');
        
        // Retrieve the node data for this category
        $targetNode = $this->cats->getNodeFromId($deleteid);
        
        // perform the deletion
        $this->cats->deleteNode($targetNode);
        
        
        $this->_render_page();
        
    }
    
    // Common output page for the demo
    // Displays the current tree as a space-indented list
    // and three forms for the manipulation of the tree
    function _render_page()
    {
        $data['treehtml'] = $this->cats->getTreeAsHTML();
        $data['categorySelect'] = $this->cats->getCategorySelect("categoryid");
    
        $data['moveCategorySourceSelect'] = $this->cats->getCategorySelect("sourceid");
        $data['moveCategoryTargetSelect'] = $this->cats->getCategorySelect("targetid");
        
        $data['deleteSelect'] = $this->cats->getCategorySelect("deleteid");
        
        $this->load->view('categories_demo_view',$data);
    
    }
    
} // END: class Categories_demo
?>