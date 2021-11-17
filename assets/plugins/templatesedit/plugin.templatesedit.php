<?php
if (!defined('MODX_BASE_PATH')) {
    die('HACK???');
}

$e = evolutionCMS()->event;
$templateEditClass = __DIR__ . '/class/templatesedit.class.php';
$templateEditBuilderClass = __DIR__ . '/class/templateseditbuilder.class.php';

if ($e->name == 'OnDocFormTemplateRender') {
    global $content;
    require_once $templateEditClass;
    $e->addOutput(templatesedit::getInstance($content)
        ->renderTemplate());
}

if ($e->name == 'OnDocFormRender') {
    global $content;
    require_once $templateEditClass;
    $e->addOutput(templatesedit::getInstance($content)
        ->renderAfterTemplate());
}

if ($e->name == 'OnDocFormSave') {
    global $content;
    require_once $templateEditClass;
    (new templatesedit())->OnDocFormSave((int) $id, (string) $mode);
}

if ($e->name == 'OnTempFormRender') {
    require_once $templateEditBuilderClass;
    $e->addOutput((new templateseditbuilder())->renderTemplate());
}

if ($e->name == 'OnTempFormSave') {
    require_once $templateEditBuilderClass;
    (new templateseditbuilder())->saveTemplate();
}

if ($e->name == 'OnTempFormDelete') {
    require_once $templateEditBuilderClass;
    (new templateseditbuilder())->deleteTemplate((int) $id);
}
