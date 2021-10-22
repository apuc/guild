<?php

namespace Common\Behaviors;

use yii\base\Event;
use yii\db\ActiveRecord;
use yii\base\Behavior;

class LogBehavior extends Behavior
{
    public function events()
    {
        return[
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeUpdate(Event $event)
    {
        $model = $event->sender;
        $dirtyAttributes = $model->getDirtyAttributes();

        foreach ($dirtyAttributes as $key => $value)
        {
            if($model->getOldAttribute($key) == $value)
            {
                continue;
            }
            $change = new \common\models\ChangeHistory([
                'type' => get_class($model),
                'type_id' => $model->getAttribute('id'),
                'field_name' => $key,
                'label' => $model->getAttributeLabel($key),
                'old_value' => $model->getOldAttribute($key),
                'new_value' => $value,
                'created_at' => date('Y-m-d-H:i:s', time()),
            ]);
            $change->save();
        }
    }
}