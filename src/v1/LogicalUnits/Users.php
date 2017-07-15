<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-15
 * Time: 12:29:11
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\UserBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\UserCollection;
use Fr\Nj2\Api\models\extended\User;
use Fr\Nj2\Api\models\store\UserStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Users as Right;

class Users extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'user';

    public function getByIds($ids)
    {
        return $this->filterCollection(UserStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new UserCollection();
        foreach($queryBody as $userData) {
            if(!isset($userData['idUser'])) continue;
            if(Right::canWrite($userData)) {
                $user = UserStore::getById($userData['idUser']);
                $user->edit(Right::writeableFields($userData));
                $user->save();
                $ret->ajout($user);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new UserCollection();
            foreach ($queryBody as $userData) {
                if (isset($userData['idUser'])) continue;
                
                if (Right::canWrite($userData)) {
                    $user = new User();
                    $user->edit(Right::writeableFields($userData));
                    $user->save();
                    $ret->ajout($user);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = UserStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = UserBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new UserCollection();
        foreach($ret as $user) {
            if(Right::canDelete($user)) $user->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(UserBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $users
     * @return array
     */
    public static function filterCollection(BaseCollection $users)
    {
        $ret = [];
        foreach ($users as $user) {
            if(Right::canSee($user)) $ret[] = Right::readableFields($user);
        }
        return $ret;
    }


}