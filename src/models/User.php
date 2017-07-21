<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\UserBusiness;
use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\extended\Player;


class User implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idUser;

    /**
     * 
     * @var string
     */
    protected $email = '';

    /**
     * 
     * @var string
     */
    protected $password = '';

    /**
     * 
     * @var int
     */
    protected $role = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @var PlayerCollection|Player[]
     */
    protected $cachePlayers = null;

    /**
     * Primary key
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
     * 
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
     * 
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
     * 
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
     * Remet à null le cache des players liés à this
     */
    public function resetCachePlayers() {
        $this->cachePlayers = null;
    }

    /**
    * Force la collection de players de this
    * @param PlayerCollection $players
    */
    public function setPlayers(PlayerCollection $players)
    {
        $this->cachePlayers = $players;
    }

    /**
     * Renvoie les players liés à ce User
     * @return PlayerCollection|Player[]
     */
    public function getPlayers() {
        if(is_null($this->cachePlayers)) {
            $this->cachePlayers = PlayerBusiness::getByUser($this);
            $this->cachePlayers->store();
        }
        return $this->cachePlayers;
    }

    /**
     * Crée un player lié à ce User
     * @return extended\Player
     */
    public function createPlayer(){
        $player = new extended\Player();
        $player->setIdUserRef($this->idUser);
        return $player;
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

    /**
     * @return boolean
     */
    public function isExtendedData()
    {
        return $this->extendedData;
    }

    /**
     * @param boolean $extendedData
     */
    public function setExtendedData($extendedData)
    {
        $this->extendedData = $extendedData;
    }
}