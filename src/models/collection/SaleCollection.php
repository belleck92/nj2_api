<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\SaleStore;
use Fr\Nj2\Api\models\extended\Sale;

class SaleCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Sale $sale
     */
    public function ajout(Sale $sale) {
        parent::append($sale);
    }

    /**
     * Met les Sales de la collection dans le SaleStore
     * Vérifie si le Sale était déjà storé, dans ce cas, remplace le Sale concerné par celui du SaleStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$sale) {/** @var Sale $sale */
            if(SaleStore::exists($sale->getId())) $replaces[$offset] = $sale;
            else SaleStore::store($sale);
        }
        unset($offset);
        foreach($replaces as $offset=>$sale) {
            $this->offsetSet($offset, SaleStore::getById($sale->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Sale
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}