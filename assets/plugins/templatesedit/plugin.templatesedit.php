<?php
if (!defined('MODX_BASE_PATH')) {
    die('HACK???');
}

$e = $modx->event;

if ($e->name == 'OnDocFormTemplateRender') {
    global $content;
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templatesedit.class.php';
    $e->addOutput(templatesedit::getInstance($content)->renderTemplate());
}

if ($e->name == 'OnDocFormRender') {
    global $content;
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templatesedit.class.php';
    $e->addOutput(templatesedit::getInstance($content)->renderAfterTemplate());
}

if ($e->name == 'OnDocFormSave') {
    global $content;
    require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templatesedit.class.php';
    (new templatesedit())->OnDocFormSave($id, $mode);
}

if ($e->name == 'OnTempFormRender') {
    if (file_exists(MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php')) {
        require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php';
        $e->addOutput((new templateseditbuilder())->renderTemplate());
    }
}

if ($e->name == 'OnTempFormSave') {
    if (file_exists(MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php')) {
        require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php';
        (new templateseditbuilder())->saveTemplate();
    }
}

if ($e->name == 'OnTempFormDelete') {
    if (file_exists(MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php')) {
        require_once MODX_BASE_PATH . 'assets/plugins/templatesedit/class/templateseditbuilder.class.php';
        (new templateseditbuilder())->deleteTemplate();
    }
}