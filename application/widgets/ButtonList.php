<?php

namespace app\widgets;

use rmrevin\yii\fontawesome\component\Icon;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

class ButtonList extends \yii\bootstrap\Nav {
    public function renderItems() {
        $items = [];
        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            if (isset($item['url']) && is_array($item['url']) && !\Yii::$app->user->can($item['url'][0], array_slice($item['url'], 1, null, true))) {
                continue;
            }

            $items[] = $this->renderItem($item);
        }

        return Html::tag('div', implode("\n", $items), $this->options);
    }

    public function renderItem($item) {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($active) {
            Html::addCssClass($options, 'active');
        }

        Html::addCssClass($options, ['btn']);

        $label = isset($item['icon']) ? new Icon($item['icon']) . ' ' . $label : $label;

        if (empty($items)) {
            return Html::a($label, $url, $options);
        } else {
            return DropDownButton::widget($items);
        }
    }
}