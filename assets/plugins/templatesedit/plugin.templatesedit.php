<?php
if (!defined('MODX_BASE_PATH')) {
    die('HACK???');
}

spl_autoload_register(function ($class) {
    if (file_exists($class = __DIR__ . '/class/' . $class . '.class.php')) {
        require_once $class;
    }
});

$e = evolutionCMS()->event;

switch ($e->name) {
    case 'OnDocFormTemplateRender':
        global $content;
        $e->addOutput(templatesedit::getInstance($content)
            ->renderTemplate());
        break;

    case 'OnDocFormRender':
        global $content;
        $e->addOutput(templatesedit::getInstance($content)
            ->renderAfterTemplate());
        break;

    case 'OnDocFormSave':
        (new templatesedit())->OnDocFormSave((int) $id, (string) $mode);
        break;

    case 'OnTempFormRender':
        $e->addOutput((new templateseditbuilder())->renderTemplate());
        break;

    case 'OnTempFormSave':
        (new templateseditbuilder())->saveTemplate();
        break;

    case 'OnTempFormDelete':
        (new templateseditbuilder())->deleteTemplate((int) $id);
        break;
}
