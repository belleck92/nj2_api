<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\StockStore;
use Fr\Nj2\Api\models\extended\Stock;

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
        return parent::offsetGet($index);
    }
}