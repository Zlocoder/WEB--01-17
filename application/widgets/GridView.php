<?php

namespace app\widgets;

class GridView extends \yii\grid\GridView {
    public $dataColumnClass = 'app\widgets\DataColumn';

    public $tableOptions = ['class' => 'table table-striped'];

    public $summary = 'Всего: {totalCount}';

    public $layout = "{items}\n{summary}\n{pager}";
}