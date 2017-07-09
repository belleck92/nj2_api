<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Stock;
use Fr\Nj2\Api\models\store\StockStore;

class StockCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Stock $stock
     */
    public function ajout(Stock $stock) {
        parent::append($stock);
    }

    /**
     * Met les Stocks de la collection dans le StockStore
     * Vérifie si le Stock était déjà storé, dans ce cas, remplace le Stock concerné par celui du StockStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$stock) {/** @var Stock $stock */
            if(StockStore::exists($stock->getId())) $replaces[$offset] = $stock;
            else StockStore::store($stock);
        }
        unset($offset);
        foreach($replaces as $offset=>$stock) {
            $this->offsetSet($offset, StockStore::getById($stock->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Stock
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}