<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of CategoriesController
 *
 * @author sbc
 */

namespace Knowledgebase\Categories\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;

class CategoriesController extends BaseController {

    public function indexAction($offset = 0, $limit = 10) {

        $tmp_items = $this->model->getRecords();
        $items = $this->model->getProcessRecords($tmp_items);

        $this->data_arr['items'] = $items;

        return parent::indexAction($offset, $limit);
    }

    public function detailAction($id = '', $slug = '') {

        $tmp_item = $this->model->getRecord();
        $item = $this->model->getProcessRecord($tmp_item);

        $this->data_arr['item'] = $item;

        return parent::detailAction($id, $slug);
    }

}
