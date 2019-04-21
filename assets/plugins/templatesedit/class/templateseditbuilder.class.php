<?php
/**
 * Created by PhpStorm.
 * @author 64j <64j@mail.ru>
 */

class templateseditbuilder
{
    protected $evo;
    protected $lang;
    protected $params;
    protected $config;
    protected $basePath = MODX_BASE_PATH . 'assets/plugins/templatesedit/';
    protected $default_fields = [];
    protected $unused_fields = [];
    protected $fields = [];
    protected $default_tvars = [];
    protected $unused_tvars = [];
    protected $tvars = [];
    protected $default_categories = [];
    protected $unused_categories = [];
    protected $categories = [];
    protected $field_types = [];

    public function __construct()
    {
        $this->evo = evolutionCMS();

        $this->getTranslate();
        $this->setParams();
        $this->getConfig();
        $this->setDefaultParams();
        $this->getDefaultFields();
        $this->getDefaultTvars();
        $this->getDefaultCategories();
        $this->getFieldTypes();
        $this->fillData();
    }

    public function renderTemplate()
    {
        return $this->view('tab', [
            'name' => 'templatesEditBuilder',
            'title' => 'template Builder',
            'tabsObject' => 'tp',
            'content' => $this->view('builder', [
                'config' => $this->json_encode($this->config),
                'data_fields' => $this->json_encode($this->default_fields),
                'data_tvars' => $this->json_encode($this->default_tvars),
                'data_categories' => $this->json_encode($this->default_categories),
                'data_types' => $this->json_encode($this->field_types)
            ])
        ]);
    }

    protected function setParams()
    {
        $this->params = $this->evo->event->params;
        $this->params['excludeTvCategory'] = !empty($this->params['excludeTvCategory']) ? array_map('trim', explode(',', $this->params['excludeTvCategory'])) : [];
        $this->params['templatesedit_builder_role'] = isset($_REQUEST['templatesedit_builder_role']) ? (int)$_REQUEST['templatesedit_builder_role'] : 1;
        $this->params['config'] = $this->params['id'] . '__' . $this->params['templatesedit_builder_role'];
        $this->params['action'] = isset($_POST['templatesedit_builder_action']) && $_POST['templatesedit_builder_action'] != '' ? $_POST['templatesedit_builder_action'] : '';

        $this->params['config_is_default'] = false;
        $this->params['check_this_config'] = false;
        $this->params['check_base_config'] = false;
        $this->params['check_default_config'] = false;
    }

    protected function setDefaultParams()
    {
        $this->params['default.tab'] = 'General';

        foreach ($this->config as $tabId => &$tab) {
            if (!isset($tab['title'])) {
                $tab['title'] = 'Tab';
            }
            if (!empty($tab['default'])) {
                $this->params['default.tab'] = $tabId;
            }
            if (isset($tab['fields'])) {
                $tab['col:0:12']['fields'] = $tab['fields'];
                unset($tab['fields']);
            }
        }
    }

    protected function fillData()
    {
        foreach ($this->config as $tabId => &$tab) {
            if (is_array($tab)) {
                foreach ($tab as $colId => &$col) {
                    if (is_array($col)) {
                        foreach ($col as $fieldsId => &$fields) {
                            list($type, $id) = explode(':', $fieldsId . '::');
                            if ($type == 'category') {
                                $this->categories[$id] = $this->default_categories[$id];
                            } else {
                                foreach ($fields as $fieldId => $field) {
                                    if (is_array($field)) {
                                        if (isset($this->default_fields[$fieldId])) {
                                            $this->fields[$fieldId] = $field;
                                        } else {
                                            if (isset($this->default_tvars[$fieldId])) {
                                                $this->tvars[$fieldId] = array_merge($this->default_tvars[$fieldId], $field);
                                            } else {
                                                unset($fields[$fieldId]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getSelectRole()
    {
        $users = [];
        $sql = $this->evo->db->select('id, name', $this->evo->getFullTableName('user_roles'), '', 'id asc');
        if ($this->evo->db->getRecordCount($sql)) {
            while ($row = $this->evo->db->getRow($sql)) {
                $pf = '&nbsp;&nbsp;&nbsp; ';
                if (is_file($this->basePath . 'configs/template__' . $this->params['id'] . '__' . $row['id'] . '.json')) {
                    $pf = '★ ';
                }
                $users[] = [
                    'value' => $row['id'],
                    'title' => $pf . $row['name']
                ];
            }
        }

        return $this->form('select', [
            'name' => 'templatesedit_builder_role',
            'value' => $this->params['templatesedit_builder_role'],
            'options' => $users,
            'class' => 'form-control form-control-sm ' . $this->params['templatesedit_builder_role'],
            'onchange' => 'document.location.href=\'?a=16&id=' . $this->params['id'] . '&templatesedit_builder_role=\'+this.value'
        ]);
    }

    protected function getUnusedFields()
    {
        $out = '';
        $items = array_diff_key($this->default_fields, $this->fields);

        uksort($items, function ($a, $b) {
            return strcasecmp($a, $b);
        });

        foreach ($items as $k => $v) {
            $out .= $this->view('b_field', [
                'name' => $k,
                'title' => $v['title']
            ]);
        }

        return $out;
    }

    protected function getUnusedTvars()
    {
        $out = '';
        $items = $this->default_tvars;

        uksort($items, function ($a, $b) {
            return strcasecmp($a, $b);
        });

        foreach ($items as $k => $v) {
            $out .= $this->view('b_field', [
                'name' => $k,
                'title' => $v['caption'],
                'category' => $v['category'],
                'rowClass' => isset($this->tvars[$k]) ? ' b-add' : '',
                'attr' => isset($this->tvars[$k]) || isset($this->categories[$v['category']]) ? ' style="display: none"' : ''
            ]);
        }

        return $out;
    }

    protected function getUnusedCategories()
    {
        $out = '';
        $categories = [];

        foreach ($this->default_tvars as $item) {
            $categories[$item['category']][$item['name']] = $item;
        }

        foreach ($categories as $k => $category) {
            foreach ($category as $key => $item) {
                if (isset($this->tvars[$key])) {
                    unset($category[$key]);
                }
            }
            if (empty($category) || isset($this->categories[$k])) {
                unset($categories[$k]);
            } else {
                $categories[$k] = $this->default_categories[$k];
            }
        }

        uksort($categories, function ($a, $b) {
            return strcasecmp($a, $b);
        });

        foreach ($categories as $k => $v) {
            if (!in_array($k, $this->params['excludeTvCategory'])) {
                $out .= $this->view('b_field_category', [
                    'name' => $k,
                    'title' => $v['category']
                ]);
            }
        }

        return $out;
    }

    protected function getDefaultFields()
    {
        $this->default_fields = require_once $this->basePath . 'configs/fields.php';

        if (file_exists($this->basePath . 'configs/custom_fields.php')) {
            $this->default_fields += require_once $this->basePath . 'configs/custom_fields.php';
        }

        return $this->default_fields;
    }

    protected function getDefaultTvars()
    {
        global $_lang;

        if ($this->params['id']) {
            $sql = $this->evo->db->query('
            SELECT tv.id, tv.name, tv.caption AS title, tv.description, tv.category
            FROM ' . $this->evo->getFullTableName('site_tmplvar_templates') . ' AS tt
            LEFT JOIN ' . $this->evo->getFullTableName('site_tmplvars') . ' AS tv ON tv.id=tt.tmplvarid
            WHERE templateid=' . $this->params['id'] . '
            ORDER BY tt.rank DESC, tv.rank DESC, tv.caption DESC, tv.id DESC
            ');

            $default_categories = [];
            if ($this->evo->db->getRecordCount($sql)) {
                while ($row = $this->evo->db->getRow($sql)) {
                    $this->default_tvars[$row['name']] = $row;
                    $default_categories[$row['category']] = $row['category'];
                }
            }

            $this->default_categories = $default_categories;

            if (isset($default_categories[0])) {
                $this->default_categories[0] = [
                    'id' => 0,
                    'category' => $_lang['no_category'],
                    'title' => $_lang['no_category'],
                    'rank' => 0
                ];
            } else {
                unset($this->default_categories[0]);
            }
        }
    }

    protected function getDefaultCategories()
    {
        if (!empty($this->default_categories)) {
            $sql = $this->evo->db->query('
            SELECT *, category AS title
            FROM ' . $this->evo->getFullTableName('categories') . '
            WHERE id IN(' . implode(',', array_keys($this->default_categories)) . ')
            ORDER BY rank, category
            ');

            if ($this->evo->db->getRecordCount($sql)) {
                while ($row = $this->evo->db->getRow($sql)) {
                    $this->default_categories[$row['id']] = $row;
                }
            }
        }
    }

    protected function getFieldTypes()
    {
        $this->field_types = [
            'Standard Type' => [
                'text' => 'Text',
                'textarea' => 'Textarea',
                'textareamini' => 'Textarea (Mini)',
                'richtext' => 'RichText',
                'dropdown' => 'DropDown List Menu',
                'listbox' => 'Listbox (Single-Select)',
                'listbox-multiple' => 'Listbox (Multi-Select)',
                'option' => 'Radio Options',
                'checkbox' => 'Check Box',
                'image' => 'Image',
                'file' => 'File',
                'number' => 'Number',
                'date' => 'Date'
            ],
            'Custom Type' => [
                'custom_tv' => 'Custom Input'
            ]
        ];

        $custom_tvs = scandir(MODX_BASE_PATH . 'assets/tvs');
        foreach ($custom_tvs as $ctv) {
            if (strpos($ctv, '.') !== 0 && $ctv != 'index.html') {
                $this->field_types['Custom Type']['custom_tv:' . $ctv] = $ctv;
            }
        }
    }

    protected function getConfig()
    {
        $this->config = [];
        $json = '';

        if ($file = glob($this->basePath . 'configs/template_*_default.json')) {
            $json = $this->params['check_default_config'] = $file[0];
            if ($this->params['check_default_config'] == $this->basePath . 'configs/template_' . $this->params['id'] . '_default.json') {
                $this->params['config_is_default'] = $this->params['check_default_config'];
            }
        }

        if (file_exists($this->basePath . 'configs/template__' . $this->params['id'] . '__1.json')) {
            $json = $this->params['check_base_config'] = $this->basePath . 'configs/template__' . $this->params['id'] . '__1.json';
        }

        if (file_exists($this->basePath . 'configs/template__' . $this->params['config'] . '.json')) {
            $json = $this->params['check_this_config'] = $this->basePath . 'configs/template__' . $this->params['config'] . '.json';
        }

        if ($json) {
            $this->config = json_decode(file_get_contents($json), true);
        } else {
            if (file_exists($this->basePath . 'configs/template__' . $this->params['id'] . '.php')) {
                $this->config = require_once $this->basePath . 'configs/template__' . $this->params['id'] . '.php';
            } else {
                $this->config = require_once $this->basePath . 'configs/template__default.php';
            }
        }

        return $this->config;
    }

    public function saveTemplate()
    {
        $data = !empty($_POST['templatesedit_builder_data']) ? $this->evo->removeSanitizeSeed($_POST['templatesedit_builder_data']) : '';

        if (!empty($data)) {
            file_put_contents($this->basePath . 'configs/template__' . $this->params['config'] . '.json', $data);
        } else {
            if (is_file($this->basePath . 'configs/template__' . $this->params['config'] . '.json')) {
                unlink($this->basePath . 'configs/template__' . $this->params['config'] . '.json');
            }
        }

        switch ($this->params['action']) {
            case 'set_default':
                if (!empty($data)) {
                    file_put_contents($this->basePath . 'configs/template_' . $this->params['id'] . '_default.json', $data);
                }
                break;

            case 'del_default':
                if (is_file($this->basePath . 'configs/template_' . $this->params['id'] . '_default.json')) {
                    unlink($this->basePath . 'configs/template_' . $this->params['id'] . '_default.json');
                }
                break;

            case 'set_base':
                file_put_contents($this->basePath . 'configs/template__' . $this->params['config'] . '.json', file_get_contents($this->params['check_base_config']));
                break;

        }

        if (!empty($this->params['action'])) {
            $_POST['stay'] = 2;
        }

        if ($this->params['templatesedit_builder_role'] != 1) {
            header('Location: index.php?a=16&id=' . $this->params['id'] . '&r=2&stay=2&templatesedit_builder_role=' . $this->params['templatesedit_builder_role']);
            exit;
        }
    }

    public function deleteTemplate()
    {

    }

    protected function getTranslate()
    {
        $manager_language = $this->evo->getConfig('manager_language');
        if (file_exists($this->basePath . 'lang/' . $manager_language . '.php')) {
            $this->lang = require_once $this->basePath . 'lang/' . $manager_language . '.php';
        } else {
            $this->lang = require_once $this->basePath . 'lang/english.php';
        }

        return $this->lang;
    }

    protected function form($tpl, $data = [])
    {
        if (!isset($data['name'])) {
            $data['name'] = '';
        }

        if (!isset($data['type'])) {
            $data['type'] = 'text';
        }

        if (!isset($data['id'])) {
            $data['id'] = $data['name'];
        }

        if (!isset($data['value'])) {
            $data['value'] = '';
        }

        if (!isset($data['placeholder'])) {
            $data['placeholder'] = '';
        }

        if (!isset($data['maxlength'])) {
            $data['maxlength'] = '255';
        }

        if (empty($data['class'])) {
            $data['class'] = 'form-control';
        }

        if (!isset($data['attr'])) {
            $data['attr'] = '';
        }

        if (!isset($data['checked'])) {
            $data['checked'] = '';
        } else {
            if (is_bool($data['checked']) || is_numeric($data['checked'])) {
                $data['checked'] = $data['checked'] ? 'checked' : '';
            }
        }

        if (!isset($data['disabled'])) {
            $data['disabled'] = '';
        } else {
            if (is_bool($data['disabled']) || is_numeric($data['disabled'])) {
                $data['disabled'] = $data['disabled'] ? 'disabled' : '';
            }
        }

        $options = '';

        if (!empty($data['options'])) {
            $tmp = $data['options'];
            foreach ($tmp as $k => $v) {
                if (is_array($v)) {
                    $options .= $this->form('option', [
                        'value' => $v['value'],
                        'title' => $v['title'],
                        'selected' => $data['value'] == $v['value'] ? 'selected' : ''
                    ]);
                } else {
                    $options .= $this->form('option', [
                        'value' => $k,
                        'title' => $v,
                        'selected' => $k == $data['value'] ? 'selected' : ''
                    ]);
                }
            }
        }

        if (!empty($data['optgroup'])) {
            foreach ($data['optgroup'] as $label => $group) {
                $options .= '<optgroup label="' . $label . '">';
                foreach ($group as $value => $title) {
                    $options .= $this->form('option', [
                        'value' => $value,
                        'title' => $title,
                        'selected' => $value == $data['value'] ? 'selected' : ''
                    ]);
                }
                $options .= '</optgroup>';
            }
        }

        $data['options'] = $options;

        if (!isset($data['onchange'])) {
            $data['onchange'] = 'documentDirty=true;';
        }

        return $this->view($tpl, $data);
    }

    protected function view($tpl, $data = [])
    {
        $tpl = trim($tpl, '/');
        $tpl = $this->basePath . 'tpl/' . $tpl . '.tpl.php';
        if (file_exists($tpl)) {
            extract($data);
            ob_start();
            @require($tpl);
            $out = ob_get_contents();
            ob_end_clean();
        } else {
            $out = 'Error: Could not load template ' . $tpl . '!<br>';
        }

        return $out;
    }

    protected function json_encode($array)
    {
        return is_array($array) ? json_encode($array, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE) : '';
    }

    protected function dd($str = '', $exit = false)
    {
        print '<pre>';
        print_r($str);
        print '</pre>';
        if ($exit) {
            exit;
        }
    }
}
