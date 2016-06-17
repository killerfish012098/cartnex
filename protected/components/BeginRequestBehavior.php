<?php
    class BeginRequestBehavior extends CBehavior
    {
        public function attach($owner)
        {
            $owner->attachEventHandler('onBeginRequest', array($this, 'switchThemes'));
        }

        public function switchThemes($event)
        {
           //Some logic that will determine which theme to use
            Yii::app()->theme = Yii::app()->config->getData('CONFIG_WEBSITE_TEMPLATE');
        }
     }