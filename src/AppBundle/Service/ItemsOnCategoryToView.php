<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 30.04.2017
 * Time: 16:39
 */

namespace AppBundle\Service;


class ItemsOnCategoryToView
{

    private function items_to_array($items)
    {
        $newItem = array();
        $newItems = array();

        foreach ($items as $item){
            $newItem['id'] = $item->getId();
            $newItem['active'] = $item->getActive();
            $newItem['name'] = $item->getName();
            $newItem['description'] = $item->getDescription();
            $newItem['image'] = $item->getImage();
            $newItem['category'] = $item->getCategory();
            $newItem['sku'] = $item->getSku();
            array_push($newItems, $newItem);
        }
        return $newItems;
    }


    private function check_is_active($items)
    {

        foreach ($items as $key => $item) {
            if ($item["active"] == false){
                unset($items[$key]);
            }
        }
        return $items;
    }


    private function build_string_to_view($items)
    {
        if($items == null){
            $viewstring = $this->build_string_without_items();
        } else{
            $viewstring = $this->build_string_with_items($items);
        }
        return $viewstring;
    }


    private function build_string_without_items()
    {
        return "<h2>This catagory doesn't have any items yet</h2>";
    }


    private function build_string_with_items($items)
    {
        $view_string = '';
        $i = 0;
        foreach ($items as $item){
            if($i%3 == 0){
                $view_string .= '<row>';
            }
            $view_string .= '<div class="col-xs-12 col-sm-4"><div class="card">';
            $view_string .= "<a class='img-card' href='/item/".$item['id']."'><img src='".$item['image']."'></a>";
            $view_string .= "<br/><div class='card-content'><h4 class='card-title'><a href='item/".$item['id']."'>";
            $view_string .= $item['name'];
            $view_string .= "</a></h4></div><div class='card-read-more'><a class='btn btn-link btn-block' href='/item/".$item['id']."'>";
            $view_string .= "Open Item</a></div></div></div>";
            if($i%3 == 0 && $i/3>0){
                $view_string .= '</row>';
            }
            $i++;
        }
        return $view_string;
    }


    public function getViewString($items)
    {
        $items = $this->items_to_array($items);
        $items = $this->check_is_active($items);
        $items = $this->build_string_to_view($items);
        return $items;
    }


}