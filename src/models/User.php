<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\UserBusiness;


class User implements Bean {

    /**
     * @var int
     */
    private $idUser;

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var int
     */
    private $role = 0;

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        if(empty($this->idUser)) $this->idUser = $idUser;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
    
    /**
     * Incremente $this->role de $increment
     * @param int $increment
     */
    public function incrRole($increment) {
        $this->setRole($this->getRole() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        UserBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdUser();
    }

    /**
     * @return void
     */
    public function delete()
    {
        UserBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdUser($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idUser'=>$this->idUser
            ,'email'=>$this->email
            ,'password'=>$this->password
            ,'role'=>$this->role
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(UserBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}