<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 30.04.2017
 * Time: 16:39
 */

namespace AppBundle\Service;


class ItemToView
{

    public function itemToArray($items)
    {
        $newItem = array();

        foreach ($items as $item){
            $newItem['id'] = $item->getId();
            $newItem['active'] = $item->getActive();
            $newItem['name'] = $item->getName();
            $newItem['description'] = $item->getDescription();
            $newItem['image'] = $item->getImage();
            $newItem['category'] = $item->getCategory();
            $newItem['sku'] = $item->getSku();
        }
        return $newItem;
    }


    public function getItemName($item)
    {
        return $item['name'];
    }

    public function getItemDescription($item)
    {
        return $item['description'];
    }

    public function getItemImage($item)
    {
        return $item['image'];
    }

    public function getItemCategory($item)
    {
        return $item['category'];
    }


}