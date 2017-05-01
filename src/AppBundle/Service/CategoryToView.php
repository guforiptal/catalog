<?php
/**
 * Created by PhpStorm.
 * User: zawar
 * Date: 25.04.2017
 * Time: 12:20
 */

namespace AppBundle\Service;


use AppBundle\Entity\Category;

class CategoryToView
{

    public function categories_to_array($categories)
    {
        $newCategory = array();
        $newCategories = array();

        foreach ($categories as $category){
            $newCategory['id'] = $category->getId();
            $newCategory['parent'] = $category->getParent();
            $newCategory['name'] = $category->getName();
            array_push($newCategories, $newCategory);
        }
        return $newCategories;
    }

    public function form_tree($mess)
    {
        if (!is_array($mess)) {
            return false;
        }
        $tree = array();
        foreach ($mess as $value) {
            $tree[$value['parent']][] = $value;
        }
        return $tree;
    }

    function build_tree($cats, $parent_id)
    {
        if (is_array($cats) && isset($cats[$parent_id])) {
            $tree = '<ul>';
            foreach ($cats[$parent_id] as $cat) {
                $tree .= "<li><a href='/catalog/category/".$cat['id']."'>".$cat['name']."</a>";
                $tree .= $this->build_tree($cats, $cat['id']);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        } else {
            return false;
        }
        return $tree;
    }

    public function getViewString($categories)
    {
        $categories = $this->categories_to_array($categories);
        $categories = $this->form_tree($categories);
        $categories = $this->build_tree($categories, 0);
        return $categories;
    }

}