<?php
if (!defined('MODX_BASE_PATH')) {
    die('HACK???');
}

$e = $modx->event;

if ($e->name == 'OnDocFormTemplateRender') {
    global $content;
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templatesedit.class.php';
    $e->addOutput((new templatesedit())->renderTemplate($content));
}

if ($e->name == 'OnTempFormRender') {
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php';
    $e->addOutput((new templateseditbuilder())->renderTemplate());
}

if ($e->name == 'OnTempFormSave') {
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php';
    $e->addOutput((new templateseditbuilder())->saveTemplate());
}

if ($e->name == 'OnTempFormDelete') {
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php';
    $e->addOutput((new templateseditbuilder())->deleteTemplate());
}