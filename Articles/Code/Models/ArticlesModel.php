<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Knowledgebase\Articles\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class ArticlesModel extends BaseModel {

    public function appendSearchQuery($query) {

        $ids = array('-1');
        $factory = new KazistFactory();
        $user = $factory->getUser();

        $user_groups = $factory->getRecords('#__users_users_groups', 'uug', array('uug.user_id=:user_id'), array('user_id' => $user->id));

        foreach ($user_groups as $user_group) {
            $ids[] = $user_group->id;
        }

        $query = parent::appendSearchQuery($query);
        $query->andWhere('ka.group_id IS NULL OR ka.group_id IN (' . $ids . ')');
        $query->where('ka.published=1');

        return $query;
    }

}
