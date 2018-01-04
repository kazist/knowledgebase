<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Knowledgebase\Addons\Article\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ArticleModel {

    public $block_id = '';

    public function getInfo() {
        return 'Hello World!';
    }

    public function getLatestArticles($category_id, $limit, $filter_type) {

        $factory = new KazistFactory;

        $query = $this->getQuery($category_id, $limit, $filter_type);

        $query->setFirstResult(0);
        $query->setMaxResults($limit);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery($category_id, $limit, $filter_type) {

        $query = new Query();
        $factory = new KazistFactory;

        $request = $factory->getRequest();
        $id = $request->request->get('id');

        $ids = array('-1');
        $user = $factory->getUser();

        $user_groups = $factory->getRecords('#__users_users_groups', 'uug', array('uug.user_id=:user_id'), array('user_id' => $user->id));

        foreach ($user_groups as $user_group) {
            $ids[] = $user_group->id;
        }

        $query->select('ka.*, uu.name as author_name');
        $query->from('#__knowledgebase_articles', 'ka');
        $query->leftJoin('ka', '#__users_users', 'uu', 'uu.id = ka.created_by');
        $query->andWhere('ka.group_id = 0 OR ka.group_id IS NULL ka.group_id = \'\' OR  OR ka.group_id IN (' . $ids . ')');
        $query->andWhere('ka.published=1');

        switch ($filter_type) {
            case 'popular':
                $query->orderBy('ka.hit', 'DESC');
                break;
            case 'featured':
                $query->orderBy('ka.featured', 'DESC');
                break;
            case 'related':
                $article = $factory->getRecord('knowledgebase_articles', 'ka', array('id=:id'), array('id' => $id));
                $query->where('ka.category_id = :category_id');
                $query->setParameter('category_id', (int) $article->category_id);
                break;
            case 'latest':
            default:
                $query->orderBy('ka.date_created', 'DESC');
                break;
        }

        return $query;
    }

}
