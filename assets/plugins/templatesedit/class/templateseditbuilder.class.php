<?php
/**
 * TemplatesEdit Builder
 *
 * @author 64j
 */

declare(strict_types=1);

/**
 * Class templateseditbuilder
 */
class templateseditbuilder
{
    /**
     * @var DocumentParser
     */
    protected $evo;

    /**
     * @var array
     */
    protected $lang;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var array
     */
    protected $defaultFields = [];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $defaultTvars = [];

    /**
     * @var array
     */
    protected $tvars = [];

    /**
     * @var array
     */
    protected $defaultCategories = [];

    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var array
     */
    protected $fieldTypes = [];

    /**
     *
     */
    public function __construct()
    {
        $this->evo = evolutionCMS();
        $this->basePath = dirname(__DIR__) . '/';

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

    /**
     * @return string
     */
    public function renderTemplate(): string
    {
        return $this->view('tab', [
            'name' => 'templatesEditBuilder',
            'title' => 'template Builder',
            'tabsObject' => 'tp',
            'content' => $this->view('builder', [
                'config' => $this->json_encode($this->config),
                'data_fields' => $this->json_encode($this->defaultFields),
                'data_tvars' => $this->json_encode($this->defaultTvars),
                'data_categories' => $this->json_encode($this->defaultCategories),
                'data_types' => $this->json_encode($this->fieldTypes)
            ])
        ]);
    }

    /**
     *
     */
    protected function setParams(): void
    {
        $this->params = $this->evo->event->params;
        $this->params['excludeTvCategory'] = !empty($this->params['excludeTvCategory']) ? array_map('trim', explode(',', $this->params['excludeTvCategory'])) : [];
        $this->params['templatesedit_builder_role'] = isset($_REQUEST['templatesedit_builder_role']) ? (int) $_REQUEST['templatesedit_builder_role'] : 1;
        $this->params['config'] = $this->params['id'] . '__' . $this->params['templatesedit_builder_role'];
        $this->params['action'] = isset($_POST['templatesedit_builder_action']) && $_POST['templatesedit_builder_action'] != '' ? $_POST['templatesedit_builder_action'] : '';

        $this->params['config_default'] = [];
        $this->params['config_is_default'] = false;
        $this->params['check_this_config'] = false;
        $this->params['check_base_config'] = false;
        $this->params['check_default_config'] = 0;
    }

    /**
     *
     */
    protected function setDefaultParams(): void
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

        if (!isset($this->config['#Static'])) {
            $this->config['#Static'] = [
                'title' => 'Static',
                'col:0:12' => []
            ];
        }
    }

    /**
     *
     */
    protected function fillData(): void
    {
        foreach ($this->config as &$tab) {
            if (is_array($tab)) {
                foreach ($tab as &$col) {
                    if (is_array($col)) {
                        foreach ($col as $fieldsId => &$fields) {
                            list($type, $id) = explode(':', $fieldsId . '::');
                            if ($type == 'category') {
                                $this->categories[$id] = $this->defaultCategories[$id];
                            } else {
                                foreach ($fields as $fieldId => $field) {
                                    if (is_array($field)) {
                                        if (isset($this->defaultFields[$fieldId])) {
                                            $this->fields[$fieldId] = $field;
                                        } else {
                                            if (isset($this->defaultTvars[$fieldId])) {
                                                $this->tvars[$fieldId] = array_merge($this->defaultTvars[$fieldId], $field);
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

    /**
     * @return string
     */
    public function renderSelectRole(): string
    {
        $users = [];
        $sql = $this->evo->db->select('id, name', $this->evo->getFullTableName('user_roles'), '', 'id asc');

        while ($row = $this->evo->db->getRow($sql)) {
            $pf = '&nbsp;&nbsp;&nbsp; ';
            if (is_file($this->basePath . 'configs/template__' . $this->params['id'] . '__' . $row['id'] . '.json') || (!is_file($this->basePath . 'configs/template__' . $this->params['id'] . '__' . $row['id'] . '.json') && !empty($this->params['config_default'][$row['id']]))) {
                $pf = '★ ';
            }
            $users[] = [
                'value' => $row['id'],
                'title' => $pf . $row['name']
            ];
        }

        return $this->form('select', [
            'name' => 'templatesedit_builder_role',
            'value' => $this->params['templatesedit_builder_role'],
            'options' => $users,
            'class' => 'form-control form-control-sm ' . $this->params['templatesedit_builder_role'],
            'onchange' => 'document.location.href=\'?a=16&id=' . $this->params['id'] . '&templatesedit_builder_role=\'+this.value'
        ]);
    }

    /**
     * @return string
     */
    protected function renderUnusedFields(): string
    {
        $out = '';
        $items = array_diff_key($this->defaultFields, $this->fields);

        uksort($items, function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        });

        foreach ($items as $k => $v) {
            $out .= $this->view('b_field', [
                'name' => $k,
                'type' => 'field',
                'title' => $v['title']
            ]);
        }

        return $out;
    }

    /**
     * @return string
     */
    protected function renderUnusedTvars(): string
    {
        $out = '';
        $items = $this->defaultTvars;

        uksort($items, function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        });

        foreach ($items as $k => $v) {
            $out .= $this->view('b_field', [
                'name' => $k,
                'type' => 'tv',
                'title' => $v['title'],
                'category' => $v['category'],
                'rowClass' => isset($this->tvars[$k]) ? ' b-add' : '',
                'attr' => isset($this->tvars[$k]) || isset($this->categories[$v['category']]) ? ' hidden' : ''
            ]);
        }

        return $out;
    }

    /**
     * @return string
     */
    protected function renderUnusedCategories(): string
    {
        $out = '';
        $categories = [];

        foreach ($this->defaultTvars as $item) {
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
                $categories[$k] = $this->defaultCategories[$k];
            }
        }

        uksort($categories, function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
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

    /**
     * @return array
     */
    protected function getDefaultFields(): array
    {
        $this->defaultFields = require_once $this->basePath . 'configs/fields.php';

        if (version_compare($this->evo->getConfig('settings_version'), '3.1.0') >= 0) {
            $position = array_search('donthit', array_keys($this->defaultFields));
            $fieldsBefore = array_slice($this->defaultFields, 0, $position);
            $fieldsAfter = array_slice($this->defaultFields, $position + 1);
            $addedFields = [
                'hide_from_tree' => $this->defaultFields['donthit']
            ];
            $this->defaultFields = $fieldsBefore + $addedFields + $fieldsAfter;
        }

        if (file_exists($this->basePath . 'configs/custom_fields.php')) {
            $this->defaultFields += require_once $this->basePath . 'configs/custom_fields.php';
        }

        return $this->defaultFields;
    }

    /**
     * @return array
     */
    protected function getDefaultTvars(): array
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

            $this->defaultCategories = [];

            while ($row = $this->evo->db->getRow($sql)) {
                $this->defaultTvars[$row['name']] = $row;
                $this->defaultCategories[$row['category']] = $row['category'];
            }

            $this->defaultCategories[0] = [
                'id' => 0,
                'category' => $_lang['no_category'],
                'title' => $_lang['no_category'],
                'rank' => 0
            ];
        }

        return $this->defaultTvars;
    }

    /**
     * @return array
     */
    protected function getDefaultCategories(): array
    {
        if (!empty($this->defaultCategories)) {
            $sql = $this->evo->db->query('
                SELECT *, category AS title
                FROM ' . $this->evo->getFullTableName('categories') . '
                ORDER BY category
            ');

            while ($row = $this->evo->db->getRow($sql)) {
                $this->defaultCategories[$row['id']] = $row;
            }
        }

        return $this->defaultCategories;
    }

    /**
     * @return array
     */
    protected function getFieldTypes(): array
    {
        $this->fieldTypes = [
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
                $this->fieldTypes['Custom Type']['custom_tv:' . $ctv] = $ctv;
            }
        }

        return $this->fieldTypes;
    }

    /**
     * @return array
     */
    protected function getConfig(): array
    {
        $this->config = [];
        $file = '';

        if ($files = glob($this->basePath . 'configs/template__*__default.json')) {
            preg_match('/template__(.*)__default\.json/', $files[0], $matches);
            if (!empty($matches[1])) {
                $this->setDefaultConfig((int) $matches[1]);
            }
        }

        if (!empty($_GET['d']) && file_exists($this->basePath . 'configs/template__' . $_GET['d'] . '__1.json')) {
            $this->params['id'] = $_GET['d'];
        }

        if (!empty($this->params['config_default']['default'])) {
            $file = $this->params['config_default']['default'];
            $this->params['config_is_default'] = $this->params['check_default_config'] == $this->params['id'];
        }

        if (!empty($this->params['config_default'][$this->params['templatesedit_builder_role']]) && file_exists($this->params['config_default'][$this->params['templatesedit_builder_role']])) {
            $file = $this->params['config_default'][$this->params['templatesedit_builder_role']];
        }

        if (file_exists($this->basePath . 'configs/template__' . $this->params['id'] . '__1.json')) {
            $file = $this->params['check_base_config'] = $this->basePath . 'configs/template__' . $this->params['id'] . '__1.json';
        }

        if (file_exists($this->basePath . 'configs/template__' . $this->params['config'] . '.json')) {
            $file = $this->params['check_this_config'] = $this->basePath . 'configs/template__' . $this->params['config'] . '.json';
        }

        if ($file) {
            $this->config = json_decode(file_get_contents($file), true);
        } else {
            if (file_exists($this->basePath . 'configs/template__' . $this->params['id'] . '.php')) {
                $this->config = require_once $this->basePath . 'configs/template__' . $this->params['id'] . '.php';
            } else {
                $this->config = require_once $this->basePath . 'configs/template__default.php';
            }
        }

        return $this->config;
    }

    /**
     * @param int $id
     */
    protected function setDefaultConfig(int $id = 0): void
    {
        if ($id) {
            $this->params['check_default_config'] = $id;
            if ($this->params['id'] != $id) {
                if (is_file($this->basePath . 'configs/template__' . $id . '__default.json')) {
                    $this->params['config_default']['default'] = $this->basePath . 'configs/template__' . $id . '__default.json';
                }
            } else {
                $files = glob($this->basePath . 'configs/template__' . $id . '__*.json');
                foreach ($files as $file) {
                    preg_match('/template__' . $id . '__(.*)\.json/', $file, $matches);
                    if (!empty($matches[1])) {
                        $this->params['config_default'][$matches[1]] = $file;
                    }
                }
            }
        }
    }

    /**
     *
     */
    public function saveTemplate(): void
    {
        $data = !empty($_POST['templatesedit_builder_data']) ? $this->evo->removeSanitizeSeed($_POST['templatesedit_builder_data']) : '';

        if (!empty($data)) {
            if ($this->params['check_default_config'] == $this->params['id'] || empty($this->params['config_default'][$this->params['templatesedit_builder_role']]) || (!empty($this->params['config_default'][$this->params['templatesedit_builder_role']]) && file_get_contents($this->params['config_default'][$this->params['templatesedit_builder_role']]) != $data)) {
                file_put_contents($this->basePath . 'configs/template__' . $this->params['config'] . '.json', $data);
            } else {
                if (is_file($this->basePath . 'configs/template__' . $this->params['config'] . '.json')) {
                    unlink($this->basePath . 'configs/template__' . $this->params['config'] . '.json');
                }
            }
        } else {
            if (is_file($this->basePath . 'configs/template__' . $this->params['config'] . '.json')) {
                unlink($this->basePath . 'configs/template__' . $this->params['config'] . '.json');
            }
            if (is_file($this->basePath . 'configs/template__' . $this->params['id'] . '__default.json')) {
                unlink($this->basePath . 'configs/template__' . $this->params['id'] . '__default.json');
            }
        }

        switch ($this->params['action']) {
            case 'set_default':
                $this->setDefaultConfig((int) $this->params['id']);

                if (!empty($data)) {
                    if ($files = glob($this->basePath . 'configs/template__*.json')) {
                        foreach ($files as $file) {
                            if (!in_array($file, $this->params['config_default'])) {
                                unlink($file);
                            }
                        }
                    }
                    file_put_contents($this->basePath . 'configs/template__' . $this->params['id'] . '__default.json', $data);
                    file_put_contents($this->basePath . 'configs/template__' . $this->params['id'] . '__1.json', $data);
                }
                break;

            case 'del_default':
                if (is_file($this->basePath . 'configs/template__' . $this->params['id'] . '__default.json')) {
                    unlink($this->basePath . 'configs/template__' . $this->params['id'] . '__default.json');
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

    /**
     * @param int $id
     */
    public function deleteTemplate(int $id = 0)
    {
        $files = glob($this->basePath . 'configs/template__' . $id . '__*.json');
        foreach ($files as $file) {
            unlink($file);
        }
    }

    /**
     * @return array
     */
    protected function getTranslate(): array
    {
        $manager_language = $this->evo->getConfig('manager_language');
        if (file_exists($this->basePath . 'lang/' . $manager_language . '.php')) {
            $this->lang = require_once $this->basePath . 'lang/' . $manager_language . '.php';
        } else {
            $this->lang = require_once $this->basePath . 'lang/english.php';
        }

        return $this->lang;
    }

    /**
     * @param string $tpl
     * @param array $data
     * @return string
     */
    protected function form(string $tpl, array $data = []): string
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

    /**
     * @param string $tpl
     * @param array $data
     * @return string
     */
    protected function view(string $tpl, array $data = []): string
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

    /**
     * @param array|null $array
     * @return string
     */
    protected function json_encode(?array $array = null): string
    {
        return is_array($array) ? json_encode($array, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE) : '';
    }
}
