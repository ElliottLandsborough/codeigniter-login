PACKAGE:    Nested_sets
AUTHOR:     Thunder
COPYRIGHT:  (c)2007 Thunder
WARRANTY:   None whatsoever. Use entirely at your own risk.
FILE:       README.txt
LINK:       http://www.codeigniter.com/wiki/Nested_sets/

DETAILS:

This package provides a nested sets model for use with the rather excellent
PHP web framework, Code Igniter (http://www.codeigniter.com). Nested sets
(or Modified Pre Order Tree Traversal) provides a system for quickly and easily
navigating around a tree-like structure and for identifying parts and subparts
of the given tree-like hierarchy.

Please see the references listed at the foot of this document for more 
information regarding the theory.

Importantly though, the nested sets approach to working with trees of hierarchical
data is a significantly more efficient method than the almost ubiquitous
adjacency model that is in common use.

CONTENTS

Nested_sets_model.php

This is the meat of the package, the model class that provides the necessary
methods for modifying and querying the data tree. It's _not_ intended to be 
used directly in your Code Igniter applications, but to be extended by another
model class designed specifically for the task in hand. To illustrate this,
I've also provided a Categories demo in the form of a model, view and controller.
The categories demo model extends the nested sets model using regular OOP syntax

class Categories_demo_model extends Nested_sets_model 
{
    ...
}

Categories_demo.php          -   Demo controller file
Categories_demo_model.php    -   Demo model file
Categories_demo_view.php     -   Demo view file

The demo files provide a working example to illustrate the usage of the Nested
sets model. It will also provide a basis for the initial input of the tree data
since adding tree nodes by hand is notoriously difficult using this methodology.

One last note here - The nested sets model is, to my mind, a much better approach
to data trees than the adjacency model; particularly in circumstances where
the data tree needs to be read far more often than it needs to be modified

See the install file for further details on usage.

Happy tree traversals!
Thunder  <ravenvelvet@gmail.com>
January 2007


---------------------------------------------------------------------------
REFERENCES:
 http://www.dbmsmag.com/9604d06.html
 http://www.sitepoint.com/article/hierarchical-data-database/2
 http://www.edutech.ch/contribution/nstrees/index.php