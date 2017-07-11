<?php
/**
 * Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
 */
namespace Fr\Nj2\Api\models;

interface Bean {

    /**
     * @return void
     */
    public function save();

    /**
     * @return int Id primaire du bean
     */
    public function getId();

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id);

    /**
     * @return void
     */
    public function delete();

    /**
     * @return array
     */
    public function getAsArray();

    /**
     * @param array $data
     */
    public function edit($data);
}