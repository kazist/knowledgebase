<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Knowledgebase\Addons\Category\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class CategoryModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getArticleCategory() {

        $query = $this->getQuery();

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('kc.*');
        $query->from('#__knowledgebase_categories', 'kc');
        $query->where('kc.published=1');
        $query->orderBy('kc.id ', 'DESC');

        return $query;
    }

}
