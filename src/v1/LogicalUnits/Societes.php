<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 15:25:33
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\SocieteBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\SocieteCollection;
use Fr\Nj2\Api\models\Societe;
use Fr\Nj2\Api\models\store\SocieteStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Societes as Right;

class Societes extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'societe';

    public function getByIds($ids)
    {
        return $this->filterCollection(SocieteStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'contacts':
                return Contacts::filterCollection(SocieteStore::getByIds($segments[0])->getContacts());
            }
        }
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new SocieteCollection();
        foreach($queryBody as $societeData) {
            if(!isset($societeData['idSociete'])) continue;
            if(Right::canWrite($societeData)) {
                $societe = SocieteStore::getById($societeData['idSociete']);
                $societe->edit(Right::writeableFields($societeData));
                $societe->save();
                $ret->ajout($societe);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new SocieteCollection();
            foreach ($queryBody as $societeData) {
                if (isset($societeData['idSociete'])) continue;
                
                if (Right::canWrite($societeData)) {
                    $societe = new Societe();
                    $societe->edit(Right::writeableFields($societeData));
                    $societe->save();
                    $ret->ajout($societe);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            
            if($segments[1] == "contacts") {
                foreach ($queryBody as &$contact) {
                    $contact['idSociete'] = $segments[0];
                }
                $unit = new Contacts();
                return $unit->create('', $parameters, $queryBody);
            }

            
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = SocieteStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = SocieteBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new SocieteCollection();
        foreach($ret as $societe) {
            if(Right::canDelete($societe)) $societe->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(SocieteBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $societes
     * @return array
     */
    public static function filterCollection(BaseCollection $societes)
    {
        $ret = [];
        foreach ($societes as $societe) {
            if(Right::canSee($societe)) $ret[] = Right::readableFields($societe);
        }
        return $ret;
    }


}