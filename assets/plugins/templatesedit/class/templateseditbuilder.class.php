<?php
/**
 * Created by PhpStorm.
 * @author 64j <64j@mail.ru>
 */

class templateseditbuilder
{
    protected $evo;
    protected $params;
    protected $config;
    protected $basePath = MODX_BASE_PATH . 'assets/plugins/templatesedit/';
    protected $default_fields = [];

    public function __construct()
    {
        $this->evo = evolutionCMS();
        $this->params = $this->evo->event->params;
    }

    public function renderTemplate()
    {
        $content = $this->tpl('templateHeader');

        $this->getConfig();

        return $this->tpl('tab', [
            'name' => 'templatesEditBuilder',
            'title' => 'template Builder',
            'tabsObject' => 'tp',
            'content' => $this->tpl('builder', [
                'content' => $content
            ])
        ]);
    }

    protected function setDefaultFields()
    {
        $this->default_fields = require_once $this->basePath . 'configs/fields.php';

        return $this->default_fields;
    }

    protected function getConfig()
    {
        $this->config = [];
        if (file_exists($this->basePath . 'configs/template_' . $this->params['id'] . '.php')) {
            $this->config = require_once $this->basePath . 'configs/template_' . $this->params['id'] . '.php';
        } else {
            $this->config = require_once $this->basePath . 'configs/template_default.php';
        }

        //print_r(json_encode($this->config, JSON_UNESCAPED_UNICODE));

        return $this->config;
    }

    protected function tpl($tpl, $data = [])
    {
        if (file_exists($this->basePath . 'tpl/' . $tpl . '.tpl')) {
            $out = file_get_contents($this->basePath . 'tpl/' . $tpl . '.tpl');
        } else {
            $out = 'File "' . $tpl . '" not found.';
        }

        if ($tpl == 'element' && !isset($data['tag'])) {
            $data['tag'] = 'div';
        }

        foreach ($data as $k => $v) {
            if (!is_array($v)) {
                $out = str_replace('[+' . $k . '+]', $v, $out);
            }
        }

        $out = preg_replace('~\[\+(.*?)\+\]~', '', $out);

        return $out;
    }
}
