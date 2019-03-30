<?php
/**
 * Created by PhpStorm.
 * @author 64j <64j@mail.ru>
 */

class templatesedit
{
    protected $evo;
    protected $doc;
    protected $params;
    protected $config;
    protected $basePath = MODX_BASE_PATH . 'assets/plugins/templatesedit/';
    protected $richtexteditorOptions = [];
    protected $richtexteditorIds = [];
    protected $default_fields = [];
    protected $added_fields = [];
    protected $counters = [];

    public function __construct()
    {
        $this->evo = evolutionCMS();
        $this->params = $this->evo->event->params;
        $this->params['showTvImage'] = !empty($this->params['showTvImage']) && $this->params['showTvImage'] == 'yes';
        $this->params['excludeTvCategory'] = !empty($this->params['excludeTvCategory']) ? explode(',', $this->params['excludeTvCategory']) : [];
        $this->params['defaultTemplateType'] = !empty($this->params['defaultTemplateType']) && $this->params['defaultTemplateType'] == 1 ? 'default' : 'default_' . $this->params['defaultTemplateType'];
        // default
        $this->params['default.tab'] = 'General';
        $this->params['default.dateGroupClass'] = '';
    }

    public function renderTemplate($doc = [])
    {
        $this->doc = $doc;
        $this->doc['template'] = $this->getTemplateId();

        if (isset($_REQUEST['pid'])) {
            $this->doc['parent'] = $_REQUEST['pid'];
        }

        if ($this->evo->manager->action == 85 || (isset($_REQUEST['isfolder']) && $_REQUEST['isfolder'] == 1)) {
            $this->doc['isfolder'] = 1;
        }

        if ($this->evo->manager->action == 85 || $this->evo->manager->action == 4) {
            $this->doc['type'] = 'document';
        }

        if ($this->evo->manager->action == 72) {
            $this->doc['type'] = 'reference';
        }

        if ((isset($this->doc['published']) && $this->doc['published'] == 1) || (!isset($this->doc['published']) && $this->evo->config['publish_default'] == 1)) {
            $this->doc['published'] = 1;
        }

        if (!isset($this->doc['alias_visible'])) {
            $this->doc['alias_visible'] = 1;
        }

        if ((isset($this->doc['searchable']) && $this->doc['searchable'] == 1) || (!isset($this->doc['searchable']) && $this->evo->config['search_default'] == 1)) {
            $this->doc['searchable'] = 1;
        }

        if ((isset($this->doc['cacheable']) && $this->doc['cacheable'] == 1) || (!isset($this->doc['cacheable']) && $this->evo->config['cache_default'] == 1)) {
            $this->doc['cacheable'] = 1;
        }

        if ($this->doc['richtext'] == 0 && $this->evo->manager->action == 27) {
            $this->doc['richtext'] = 0;
        } else {
            $this->doc['richtext'] = 1;
        }

        $this->doc['syncsite'] = 1;

        $this->setDefaultFields();
        $this->getConfig();

        return $this->tpl('documentWrap', [
            'content' => $this->renderFields(),
            'MODX_SITE_URL' => MODX_SITE_URL
        ]);
    }

    protected function getTemplateId()
    {
        if (isset($_REQUEST['newtemplate'])) {
            $this->doc['template'] = $_REQUEST['newtemplate'];
        } elseif (!isset($this->doc['template'])) {
            $this->doc['template'] = getDefaultTemplate();
        }

        return $this->doc['template'];
    }

    protected function setDefaultFields()
    {
        $this->default_fields = require_once $this->basePath . 'configs/fields.php';

        return $this->default_fields;
    }

    protected function getConfig()
    {
        $this->config = [];

        if (file_exists($this->basePath . 'configs/template_' . $this->doc['template'] . '.php')) {
            $this->config = require_once $this->basePath . 'configs/template_' . $this->doc['template'] . '.php';
        } else {
            $this->config = require_once $this->basePath . 'configs/template_' . $this->params['defaultTemplateType'] . '.php';
        }

        return $this->getTemplateVariables();
    }

    protected function getTemplateVariables()
    {
        $docgrp = '';
        if (!empty($_SESSION['mgrDocgroups'])) {
            $docgrp = implode(',', $_SESSION['mgrDocgroups']);
        }

        foreach ($this->config as $k => $v) {
            if (!empty($v['default'])) {
                $this->params['default.tab'] = $k;
                if (!empty($v['titleClass'])) {
                    $this->params['default.titleClass'] = $v['titleClass'];
                }
                if (!empty($v['fieldClass'])) {
                    $this->params['default.fieldClass'] = $v['fieldClass'];
                }
                if (!empty($v['dateGroupClass'])) {
                    $this->params['default.dateGroupClass'] = $v['dateGroupClass'];
                }
            }
        }

        $sql = $this->evo->db->select('
            DISTINCT tv.*, IF(tvc.value!="",tvc.value,tv.default_text) as value', $this->evo->getFullTableName('site_tmplvars') . ' AS tv
            INNER JOIN ' . $this->evo->getFullTableName('site_tmplvar_templates') . ' AS tvtpl ON tvtpl.tmplvarid = tv.id
            LEFT JOIN ' . $this->evo->getFullTableName('site_tmplvar_contentvalues') . ' AS tvc ON tvc.tmplvarid=tv.id AND tvc.contentid="' . $this->doc['id'] . '"
            LEFT JOIN ' . $this->evo->getFullTableName('site_tmplvar_access') . ' AS tva ON tva.tmplvarid=tv.id', 'tvtpl.templateid="' . $this->doc['template'] . '" AND (1="' . $_SESSION['mgrRole'] . '" OR ISNULL(tva.documentgroup)' . (!$docgrp ? '' : ' OR tva.documentgroup IN (' . $docgrp . ')') . ')', 'tvtpl.rank, tv.rank, tv.id');

        if ($this->evo->db->getRecordCount($sql)) {

            while ($row = $this->evo->db->getRow($sql)) {
                foreach ($this->config as $k => &$v) {
                    if (isset($v['fields'][$row['name']])) {
                        $field = $v['fields'][$row['name']];
                        $v['fields'][$row['name']] = $row;
                        if (isset($field['help'])) {
                            $v['fields'][$row['name']]['help'] = $field['help'];
                        }
                        if (isset($field['title'])) {
                            $v['fields'][$row['name']]['caption'] = $field['title'];
                            $v['fields'][$row['name']]['description'] = '';
                        }
                        if (!empty($field['required'])) {
                            $v['fields'][$row['name']]['required'] = true;
                        }
                        if (!empty($field['choices'])) {
                            $v['fields'][$row['name']]['choices'] = $field['choices'];
                        }
                        if (!empty($field['hide'])) {
                            $v['fields'][$row['name']]['hide'] = true;
                        }
                        if (isset($field['default'])) {
                            $v['fields'][$row['name']]['default_text'] = $field['default'];
                        }
                        if (isset($field['default_text'])) {
                            $v['fields'][$row['name']]['default_text'] = $field['default_text'];
                        }
                        if (empty($this->doc['id'])) {
                            $v['fields'][$row['name']]['value'] = $v['fields'][$row['name']]['default_text'];
                        }
                        unset($row);
                        break;
                    }
                }

                if (!empty($row) && !in_array($row['category'], $this->params['excludeTvCategory'])) {
                    if (!isset($this->config[$this->params['default.tab']]['fields'])) {
                        $this->config[$this->params['default.tab']]['fields'] = [];
                    }
                    $this->config[$this->params['default.tab']]['fields'][$row['name']] = $row;
                }
            }
        }

        return $this->config;
    }

    protected function renderFields()
    {
        global $_lang, $richtexteditorIds, $richtexteditorOptions;

        $out = '';
        $this->added_fields = [];

        require_once MODX_MANAGER_PATH . 'includes/tmplvars.inc.php';
        require_once MODX_MANAGER_PATH . 'includes/tmplvars.commands.inc.php';

        if (($this->doc['richtext'] == 1 || $this->evo->manager->action == 4) && $this->evo->config['use_editor'] == 1) {
            $this->richtexteditorIds[$this->evo->config['which_editor']][] = 'ta';
            $this->richtexteditorOptions[$this->evo->config['which_editor']]['ta'] = '';
        }

        foreach ($this->config as $tabName => &$tab) {
            if ($tabName == 'General' && empty($tab['title'])) {
                $tab['title'] = $_lang['settings_general'];
            }
            if (!empty($tab['roles'])) {
                $roles = explode(',', $tab['roles']);
                foreach ($roles as $role) {
                    if (($role[0] != '!' && trim($role) != $_SESSION['mgrRole']) || ($role[0] == '!' && ltrim($role, '!') == $_SESSION['mgrRole'])) {
                        $tab['hide'] = true;
                    }
                }
            }

            if ($tab['title']) {
                $tabContent = '';
                $this->counters['counter'] = 0;
                $this->counters['split'] = 0;
                $this->counters['hide'] = 0;

                foreach ($tab as $k => $fields) {
                    if ($k == 'cols') {
                        $cols = '';
                        foreach ($fields as $col) {
                            if (!empty($col['fields'])) {
                                $cols .= $this->tpl('element', [
                                    'class' => !empty($col['class']) ? $col['class'] : 'col-12 col-xs-12',
                                    'content' => $this->renderTab($col['fields'], $tabName)
                                ]);
                            }
                        }
                        $tabContent .= $this->tpl('element', [
                            'class' => 'row form-row',
                            'content' => $cols
                        ]);
                    } elseif ($k == 'fields') {
                        $tabContent .= $this->renderTab($fields, $tabName);
                    }
                }

                if ($tabContent) {
                    if ($tabContent && $this->counters['split'] != $this->counters['counter']) {
                        $out .= $this->tpl('tab', [
                            'name' => $tabName,
                            'title' => $tab['title'],
                            'tabsObject' => 'tpSettings',
                            'content' => $tabContent
                        ]);
                    }
                } else {
                    unset($this->config[$tabName]);
                }
            }
        }

        $default_fields = array_diff(array_keys($this->default_fields), $this->added_fields);
        if ($default_fields) {
            $out .= '<!-- hidden fields -->';
            foreach ($default_fields as $fieldName) {
                if (in_array($fieldName, ['introtext', 'content'])) {
                    continue;
                }
                $out .= $this->form('input', [
                    'type' => 'hidden',
                    'name' => $fieldName,
                    'value' => isset($this->doc[$fieldName]) ? $this->doc[$fieldName] : ''
                ]);
            }
            $out .= '<!-- end hidden fields -->';
        }

        $richtexteditorIds = $this->richtexteditorIds;
        $richtexteditorOptions = $this->richtexteditorOptions;

        return $out;
    }

    protected function renderTab($fields, $tabName)
    {
        $out = '';

        foreach ($fields as $fieldName => $field) {
            if ($fieldName == 'richtext' && $this->doc['type'] == 'reference') {
                $field['hide'] = true;
            }
            if (!isset($field['class'])) {
                $field['class'] = '';
            }
            if (isset($field['type']) && ($field['type'] == 'split' || $field['type'] == 'splitter')) {
                $out .= $field['title'];
                $this->counters['counter']++;
                $this->counters['split']++;
                if (!empty($field['hide'])) {
                    $this->counters['hide']++;
                }
            } else {
                if (!empty($field['roles'])) {
                    $roles = explode(',', $field['roles']);
                    foreach ($roles as $role) {
                        if (($role[0] != '!' && trim($role) != $_SESSION['mgrRole']) || ($role[0] == '!' && ltrim($role, '!') == $_SESSION['mgrRole'])) {
                            $field['hide'] = true;
                        }
                    }
                }
                if (empty($this->doc['id']) && !isset($field['id'])) {
                    if (isset($field['default'])) {
                        $this->doc[$fieldName] = $field['default'];
                    }
                }
                if (!empty($field['hide']) || !empty($this->config[$tabName]['hide'])) {
                    unset($this->config[$tabName]['fields'][$fieldName]);
                    $this->counters['hide']++;
                } else {
                    if (!isset($field['id']) && !isset($this->default_fields[$fieldName])) {
                        unset($this->config[$tabName]['fields'][$fieldName]);
                    } else {
                        if (isset($this->default_fields[$fieldName])) {
                            if (!isset($field['title'])) {
                                $field['title'] = $this->default_fields[$fieldName]['title'];
                            }
                            if (!isset($data['help'])) {
                                $field['help'] = $this->default_fields[$fieldName]['help'];
                            }
                            array_push($this->added_fields, $fieldName);
                        }
                        $render_field = $this->renderField($fieldName, $field, $tabName);
                        if ($render_field) {
                            $out .= $render_field;
                            $this->counters['counter']++;
                        }
                    }
                }
            }
        }

        return $out;
    }

    protected function renderField($name, $data, $tabName)
    {
        global $_lang;
        $field = '';
        $required = !empty($data['required']) ? ' required' : '';
        $help = !empty($data['help']) ? '<i class="fa fa-question-circle" data-tooltip="' . stripcslashes($data['help']) . '"></i>' : '';
        $title = isset($data['title']) ? $data['title'] : '';

        list($item_title, $item_description) = explode('||||', $title . '||||');
        $fieldDescription = (!empty($item_description)) ? '<br><span class="comment">' . $item_description . '</span>' : '';

        if (isset($this->default_fields[$name])) {
            $title = '<label for="' . $name . '" class="warning">' . $item_title . '</label>' . $fieldDescription;

            if (isset($data['type'])) {
                $default = isset($data['default']) ? $data['default'] : '';
                $elements = !empty($data['elements']) ? $data['elements'] : '';
                $value = isset($this->doc[$name]) && $this->doc[$name] != '' ? $this->doc[$name] : $default;
                $renderField = renderFormElement($data['type'], $name, $default, $elements, $value, '', $data);
                if ($required) {
                    $renderField = str_replace([' id="tv', ' name="tv'], [' id="', $required . ' name="'], $renderField);
                }
                if (!empty($data['rows'])) {
                    $renderField = preg_replace('/rows="(.*?)"/is', 'rows="' . $data['rows'] . '"', $renderField);
                }
                $field .= $renderField;
            } else {
                switch ($name) {
                    case 'published':
                    case 'richtext':
                    case 'donthit':
                    case 'searchable':
                    case 'cacheable':
                    case 'syncsite':
                    case 'alias_visible':
                    case 'isfolder':
                    case 'hidemenu':
                        $value = empty($this->doc[$name]) ? 0 : 1;
                        if ($name == 'donthit' || $name == 'hidemenu') {
                            $checked = !$value ? 'checked' : '';
                        } else {
                            $checked = $value ? 'checked' : '';
                        }
                        $field .= $this->form('input', [
                            'type' => 'checkbox',
                            'name' => $name . 'check',
                            'class' => 'form-checkbox ' . $data['class'],
                            'attr' => 'onclick="changestate(document.mutate.' . $name . ');" ' . $checked . $required
                        ]);
                        $field .= $this->form('input', [
                            'type' => 'hidden',
                            'name' => $name,
                            'value' => $value
                        ]);
                        break;

                    case 'pub_date':
                    case 'unpub_date':
                    case 'createdon':
                    case 'editedon':
                        $field .= $this->form('date', [
                            'name' => $name,
                            'value' => ((isset($this->doc[$name]) && $this->doc[$name] == 0) || !isset($this->doc[$name]) ? '' : $this->evo->toDateFormat($this->doc[$name])),
                            'class' => $data['class'],
                            'dateGroupClass' => $this->params['default.dateGroupClass'],
                            'placeholder' => $this->evo->config['datetime_format'] . ' HH:MM:SS',
                            'icon' => 'fa fa-calendar-times-o',
                            'icon.title' => $_lang['remove_date']
                        ]);
                        break;

                    case 'menusort':
                    case 'menuindex':
                        $field .= $this->tpl('element', [
                            'class' => 'input-group',
                            'content' => $this->tpl('element', [
                                    'class' => 'input-group-btn',
                                    'content' => $this->tpl('element', [
                                            'tag' => 'span',
                                            'class' => 'btn btn-secondary fa fa-angle-left',
                                            'attr' => 'onclick="var elm = document.mutate.menuindex;var v=parseInt(elm.value+\'\')-1;elm.value=v>0? v:0;elm.focus();documentDirty=true;return false;" style="cursor: pointer;"'
                                        ]) . $this->tpl('element', [
                                            'tag' => 'span',
                                            'class' => 'btn btn-secondary fa fa-angle-right',
                                            'attr' => 'onclick="var elm = document.mutate.menuindex;var v=parseInt(elm.value+\'\')+1;elm.value=v>0? v:0;elm.focus();documentDirty=true;return false;" style="cursor: pointer;"'
                                        ])
                                ]) . $this->form('input', [
                                    'name' => $name,
                                    'value' => $this->doc['menuindex'],
                                    'maxlength' => 6
                                ])
                        ]);
                        break;

                    case 'introtext':
                        $field .= $this->form('textarea', [
                            'name' => 'introtext',
                            'value' => $this->evo->htmlspecialchars(stripslashes($this->doc['introtext'])),
                            'class' => $data['class'],
                            'rows' => empty($data['rows']) ? 3 : $data['rows']
                        ]);
                        break;

                    case 'content':
                        if ($this->doc['type'] == 'document') {
                            $field .= $this->form('textarea', [
                                'name' => 'ta',
                                'value' => $this->evo->htmlspecialchars(stripslashes($this->doc['content'])),
                                'class' => $data['class'],
                                'rows' => empty($data['rows']) ? 20 : $data['rows']
                            ]);
                        }
                        break;

                    case 'weblink':
                        if ($this->doc['type'] == 'reference') {
                            $field .= $this->tpl('element', [
                                'tag' => 'i',
                                'id' => 'llock',
                                'class' => 'fa fa-chain',
                                'attr' => 'onclick="enableLinkSelection(!allowLinkSelection);"'
                            ]);
                            $field .= $this->form('input', [
                                'name' => 'ta',
                                'value' => !empty($this->doc['content']) ? stripslashes($this->doc['content']) : 'http://',
                                'class' => $data['class']
                            ]);
                        }
                        break;

                    case 'template':
                        $rs = $this->evo->db->select('t.templatename, t.id, c.category', $this->evo->getFullTableName('site_templates') . ' AS t LEFT JOIN ' . $this->evo->getFullTableName('categories') . ' AS c ON t.category = c.id', '', 'c.category, t.templatename ASC');
                        $optgroup = [];
                        while ($row = $this->evo->db->getRow($rs)) {
                            $category = !empty($row['category']) ? $row['category'] : $_lang['no_category'];
                            $optgroup[$category][$row['id']] = $row['templatename'];
                        }
                        $field .= $this->form('select', [
                            'name' => 'template',
                            'value' => $this->doc['template'],
                            'options' => [
                                0 => '(blank)'
                            ],
                            'optgroup' => $optgroup,
                            'class' => $data['class'],
                            'onchange' => 'templateWarning();'
                        ]);
                        break;

                    case 'parent':
                        $parentlookup = false;
                        $parentname = $this->evo->config['site_name'];
                        if (!empty($_REQUEST['id']) && !empty($this->doc['parent'])) {
                            $parentlookup = $this->doc['parent'];
                        } elseif (!empty($_REQUEST['pid'])) {
                            $parentlookup = $_REQUEST['pid'];
                        } elseif (!empty($_POST['parent'])) {
                            $parentlookup = $_POST['parent'];
                        } else {
                            $this->doc['parent'] = 0;
                        }
                        if ($parentlookup !== false && is_numeric($parentlookup)) {
                            $rs = $this->evo->db->select('pagetitle', $this->evo->getFullTableName('site_content'), "id='{$parentlookup}'");
                            $parentname = $this->evo->db->getValue($rs);
                            if (!$parentname) {
                                $this->evo->webAlertAndQuit($_lang["error_no_parent"]);
                            }
                        }
                        $field .= $this->tpl('element', [
                            'class' => 'form-control ' . $data['class'],
                            'content' => $this->tpl('element', [
                                    'tag' => 'i',
                                    'id' => 'plock',
                                    'class' => 'fa fa-folder-o',
                                    'attr' => 'onclick="enableParentSelection(!allowParentSelection);"'
                                ]) . $this->tpl('element', [
                                    'tag' => 'b',
                                    'id' => 'parentName',
                                    'content' => $this->doc['parent'] . ' (' . $parentname . ')'
                                ]) . $this->tpl('input', [
                                    'type' => 'hidden',
                                    'name' => 'parent',
                                    'value' => $this->doc['parent']
                                ])
                        ]);
                        break;

                    case 'type':
                        if ($_SESSION['mgrRole'] == 1 || $this->evo->manager->action != 27 || $_SESSION['mgrInternalKey'] == $this->doc['createdby']) {
                            $field .= $this->form('select', [
                                'name' => 'type',
                                'value' => $this->doc['type'],
                                'options' => [
                                    'document' => $_lang["resource_type_webpage"],
                                    'reference' => $_lang["resource_type_weblink"]
                                ],
                                'class' => $data['class']
                            ]);
                        } else {
                            $field .= $this->form('input', [
                                'type' => 'hidden',
                                'name' => 'type',
                                'value' => $this->doc['type'] != 'reference' && $this->evo->manager->action != 72 ? 'document' : 'reference'
                            ]);
                        }
                        break;

                    case 'contentType':
                        if ($_SESSION['mgrRole'] == 1 || $this->evo->manager->action != 27 || $_SESSION['mgrInternalKey'] == $this->doc['createdby']) {
                            $custom_contenttype = isset($this->evo->config['custom_contenttype']) ? $this->evo->config['custom_contenttype'] : 'text/html,text/plain,text/xml';
                            $options = explode(',', $custom_contenttype);
                            $field .= $this->form('select', [
                                'name' => 'contentType',
                                'value' => $this->doc['contentType'] ? $this->doc['contentType'] : 'text/html',
                                'options' => array_combine($options, $options),
                                'class' => $data['class']
                            ]);
                        } else {
                            $field .= $this->form('input', [
                                'type' => 'hidden',
                                'name' => 'type',
                                'value' => $this->doc['type'] == 'reference' ? 'text/html' : ($this->doc['contentType'] ? $this->doc['contentType'] : 'text/html')
                            ]);
                            if ($this->doc['type'] == 'reference') {
                                $field .= $this->form('input', [
                                    'type' => 'hidden',
                                    'name' => 'contentType',
                                    'value' => 'text/html'
                                ]);
                            } else {
                                $field .= $this->form('input', [
                                    'type' => 'hidden',
                                    'name' => 'contentType',
                                    'value' => isset($this->doc['contentType']) ? $this->doc['contentType'] : 'text/html'
                                ]);
                            }
                        }
                        break;

                    case 'content_dispo':
                        if ($_SESSION['mgrRole'] == 1 || $this->evo->manager->action != 27 || $_SESSION['mgrInternalKey'] == $this->doc['createdby']) {
                            $field .= $this->form('select', [
                                'name' => 'content_dispo',
                                'value' => $this->doc['content_dispo'],
                                'options' => [
                                    0 => $_lang['inline'],
                                    1 => $_lang['attachment']
                                ],
                                'class' => $data['class']
                            ]);
                        } else {
                            if ($this->doc['type'] != 'reference') {
                                $field .= $this->form('input', [
                                    'type' => 'hidden',
                                    'name' => 'content_dispo',
                                    'value' => isset($this->doc['content_dispo']) ? $this->doc['content_dispo'] : 0
                                ]);
                            }
                        }
                        break;

                    default:
                        $field .= $this->form('input', [
                            'name' => $name,
                            'value' => $this->evo->htmlspecialchars(stripslashes($this->doc[$name])),
                            'class' => 'form-control ' . $data['class'],
                            'attr' => 'spellcheck="true"' . $required
                        ]);
                        break;
                }
            }
        } else {
            if (array_key_exists('tv' . $data['id'], $_POST)) {
                if ($data['type'] == 'listbox-multiple') {
                    $value = implode('||', $_POST['tv' . $data['id']]);
                } else {
                    $value = $_POST['tv' . $data['id']];
                }
            } else {
                $value = $data['value'];
            }
            if (isset($data['title'])) {
                $title = '<label for="tv' . $data['id'] . '" class="warning">' . $item_title . '</label>' . $fieldDescription;
            } else {
                $item_title = $data['caption'];
                //$item_title .= '<small class="protectedNode d-block">[*' . $data['name'] . '*]</small>';
                $item_description = $data['description'];
                $tvDescription = (!empty($item_description)) ? '<div class="comment">' . $item_description . '</div>' : '';
                $tvInherited = (substr($value, 0, 8) == '@INHERIT') ? '<div class="comment inherited">(' . $_lang['tmplvars_inherited'] . ')</div>' : '';
                $title = '<div class="warning">' . $item_title . '</div>' . $tvDescription . $tvInherited;
            }
            if ($data['type'] == 'richtext' || $data['type'] == 'htmlarea') {
                $tvOptions = $this->evo->parseProperties($data['elements']);
                $editor = $this->evo->config['which_editor'];
                if (!empty($tvOptions)) {
                    $editor = isset($tvOptions['editor']) ? $tvOptions['editor'] : $this->evo->config['which_editor'];
                };
                $this->richtexteditorIds[$editor][] = 'tv' . $data['id'];
                $this->richtexteditorOptions[$editor]['tv' . $data['id']] = $tvOptions;
            }
            $renderField = renderFormElement($data['type'], $data['id'], $data['default_text'], $data['elements'], $value, '', $data);
            // show required
            if ($required) {
                $renderField = str_replace(' name="', $required . ' name="', $renderField);
            }
            $field .= $renderField;
            // show tv image
            if ($data['type'] == 'image' && $this->params['showTvImage']) {
                $field .= $this->form('thumb', [
                    'name' => $data['id'],
                    'value' => $value ? MODX_SITE_URL . $value : '',
                    'width' => $this->evo->config['thumbWidth']
                ]);
            }
            // show datalist
            if (($data['type'] == 'text' || $data['type'] == 'number') && $data['elements']) {
                $options = explode('||', $data['elements']);
                $field .= $this->form('datalist', [
                    'id' => $data['id'],
                    'class' => '',
                    'options' => array_combine($options, $options)
                ]);
            }
            // show choices
            if (!empty($data['choices'])) {
                $field .= $this->showChoices($data['id'], $value, $data['choices']);
            }
        }

        $out = '';
        if (!empty($field)) {
            $content = '';

            if (empty($data['titleClass'])) {
                if (isset($this->config[$tabName]['titleClass'])) {
                    $data['titleClass'] = $this->config[$tabName]['titleClass'];
                } elseif (isset($this->params['default.titleClass'])) {
                    $data['titleClass'] = $this->params['default.titleClass'];
                }
                if (empty($data['titleClass'])) {
                    $data['titleClass'] = !empty($data['title']) || !empty($data['caption']) ? 'col-md-3 col-lg-2' : '';
                }
            }

            if (empty($data['fieldClass'])) {
                if (isset($this->config[$tabName]['fieldClass'])) {
                    $data['fieldClass'] = $this->config[$tabName]['fieldClass'];
                } elseif (isset($this->params['default.fieldClass'])) {
                    $data['fieldClass'] = $this->params['default.fieldClass'];
                }
                if (empty($data['fieldClass'])) {
                    $data['fieldClass'] = !empty($data['title']) || !empty($data['caption']) ? 'col-md-9 col-lg-10' : 'col-xs-12 col-12';
                }
            }

            if (!empty($data['title']) || !empty($data['caption'])) {
                $afterTitle = '';
                if ($name == 'content') {
                    $options = [
                        'none' => $_lang['none']
                    ];
                    $evtOut = $this->evo->invokeEvent("OnRichTextEditorRegister");
                    if (is_array($evtOut)) {
                        for ($i = 0; $i < count($evtOut); $i++) {
                            $editor = $evtOut[$i];
                            $options[$editor] = $editor;
                        }
                    }
                    $afterTitle .= $this->tpl('element', [
                        'class' => empty($data['selectClass']) ? '' : $data['selectClass'],
                        'content' => $this->tpl('element', [
                                'content' => $_lang['which_editor_title'],
                                'class' => 'float-xs-left'
                            ]) . $this->form('select', [
                                'name' => 'which_editor',
                                'value' => $this->evo->config['which_editor'],
                                'options' => $options,
                                'class' => 'form-control form-control-sm float-xs-none ml-1',
                                'onchange' => 'changeRTE();'
                            ])
                    ]);
                }
                $content .= $this->tpl('element', [
                    'class' => $data['titleClass'],
                    'content' => $title . $help . $afterTitle
                ]);
            }

            $content .= $this->tpl('element', [
                'class' => $data['fieldClass'],
                'content' => $field
            ]);

            $out .= $this->tpl('element', [
                'class' => 'row form-row',
                'content' => $content
            ]);
        }

        return $out;
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
                $options .= $this->form('option', [
                    'value' => $k,
                    'title' => $v,
                    'selected' => $k == $data['value'] ? 'selected' : ''
                ]);
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

        return $this->tpl($tpl, $data);
    }

    protected function showChoices($id, $value = '', $separator = ', ')
    {
        $out = '';
        $separator = is_bool($separator) ? ', ' : $this->evo->htmlspecialchars($separator);

        $rs = $this->evo->db->query('
        SELECT value 
        FROM ' . $this->evo->getFullTableName('site_tmplvar_contentvalues') . '
        WHERE tmplvarid=' . $id . '
        GROUP BY value
        ORDER BY value ASC
        ');

        if ($this->evo->db->getRecordCount($rs)) {
            $out .= '<div class="choicesList" data-target="tv' . $id . '" data-separator="' . $separator . '">';
            $separator = trim(htmlspecialchars_decode($separator));
            $value = trim($value, $separator);
            $list = [];
            while ($row = $this->evo->db->getRow($rs)) {
                $list = array_merge($list, array_map('trim', explode($separator, $row['value'])));
            }
            $list = array_unique($list);
            sort($list);
            $value = array_map('trim', explode($separator, $value));
            foreach ($list as $val) {
                if (trim($val) != '') {
                    if (in_array($val, $value)) {
                        $out .= '<i class="selected">' . $val . '</i>';
                    } else {
                        $out .= '<i>' . $val . '</i>';
                    }
                }
            }
            $out .= '</div>';
        }

        return $out;
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
