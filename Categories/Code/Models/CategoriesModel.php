<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Knowledgebase\Categories\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class CategoriesModel extends BaseModel {

    public function getProcessRecords($records) {

        $factory = new KazistFactory();

        foreach ($records as $key => $record) {
            $records[$key]->articles = $factory->getRecords('#__knowledgebase_articles', 'ka', array('ka.category_id=:category_id'), array('category_id' => $record->id));
        }

        return $records;
    }

    public function getProcessRecord($record) {

        $factory = new KazistFactory();

        $record->articles = $factory->getRecords('#__knowledgebase_articles', 'ka', array('ka.category_id=:category_id'), array('category_id' => $record->id));

        return $record;
    }

}
