var TemplatesEditBuilder = function(el, config) {
  'use strict';

  function TemplatesEdit(el, config)
  {
    this.settings = {
      tab: {},
      field: {
        title: '',
        description: '',
        help: '',
        default: '',
        elements: '',
        type: '',
        size: 'md',
        position: 'l',
        reverse: '',
        required: '',
        rows: '',
        pattern: '',
        choices: ''
      }
    };
    this.el = el;
    this.dataEl = config.dataEl;
    this.data_fields = config.data_fields;
    this.data_tvars = config.data_tvars;
    this.data_categories = config.data_categories;
    this.data_types = config.data_types;
    this.elUnusedFields = document.querySelector('.builder .b-unused-fields');
    this.elUnusedTvars = document.querySelector('.builder .b-unused-tvars');
    this.elUnusedCategories = document.querySelector('.builder .b-unused-categories');
    this.init();
    this.initDraggable();
    this.events();
  }

  TemplatesEdit.prototype.templates = {
    tab: '' +
        '<div class="b-tab b-item {class}" data-id="{id}">\n' +
        '    <input type="checkbox" id="tab-options-radio-{id}" class="b-tab-default b-hidden" data-id="{id}" name="b-tab-default" {checked}>\n' +
        '    <div class="b-tab-title sectionHeader">\n' +
        '        <div class="row align-items-center">\n' +
        '            <div class="col-auto"><i class="fa fa-arrows b-move"></i></div>\n' +
        '            <div class="col-auto b-tab-title-input">\n' +
        '                <input type="text" class="form-control form-control-sm pr-2 b-title" value="{title}" placeholder="title tab">\n' +
        '                <label for="tab-options-radio-{id}" class="fa fa-check-circle b-tab-check-default" title="Default Tab"></label>\n' +
        '            </div>\n' +
        '            <div class="col-auto"><i class="fa fa-minus-circle text-danger b-btn-del"></i></div>\n' +
        '            <div class="col-auto"><i class="fa fa-plus-circle text-success b-btn-add"></i></div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    {content}' +
        '</div>',
    col: '' +
        '<div class="row col row-col-wrap b-draggable col-{col}" data-name="{name}" data-settings="{settings}">\n' +
        '    <div class="row-col col">{content}</div>\n' +
        '    <i class="b-resize b-resize-r"></i>\n' +
        '    <div class="b-btn-wrap b-btn-wrap-center">\n' +
        '        <i class="fa fa-arrows b-move"></i>\n' +
        '    </div>\n' +
        '    <div class="b-btn-wrap">\n' +
        '        <i class="fa fa-cog b-btn-settings"></i>\n' +
        '        <i class="fa fa-minus-circle text-danger b-btn-del"></i>\n' +
        '        <i class="fa fa-plus-circle text-success b-btn-add"></i>\n' +
        '    </div>\n' +
        '</div>',
    fields: '' +
        '<div class="b-items-fields">{content}</div>',
    category: '' +
        '<div class="col-12 b-category b-item b-draggable" data-name="{name}" data-title="{title}" data-id="{id}">\n' +
        '    <div class="row b-category-title">\n' +
        '        <div class="col-auto"><i class="fa fa-bars b-move"></i></div>\n' +
        '        <div class="col b-field-name">{title}</div>\n' +
        '        <div class="col-auto"><i class="fa fa-minus-circle text-danger b-btn-del"></i></div>\n' +
        '    </div>\n' +
        '</div>',
    field: '' +
        '<div class="col-12 b-field b-item b-draggable {hidden} b-required-{required}" title="{title}" data-name="{name}" data-type="{type}" data-category="{category}" data-settings="{settings}">\n' +
        '  <div class="row align-items-center">\n' +
        '    <div class="col-auto"><i class="fa fa-bars b-move"></i></div>\n' +
        '    <div class="col b-field-name">{name}</div>\n' +
        '    <div class="col-auto"><i class="fa fa-cog b-btn-settings"></i></div>\n' +
        '    <div class="col-auto"><i class="fa fa-minus-circle text-danger b-btn-del"></i></div>\n' +
        '  </div>\n' +
        '</div>',
    settings: '' +
        '<div class="row col b-field-settings b-settings nu-context-menu">\n' +
        '    <input type="checkbox" id="b-input-more-{name}" class="b-input-more b-hidden">\n' +
        '    <div class="row b-settings-header">\n' +
        '        <div class="col text-center"><b class="text-primary">{name}</b></div>\n' +
        '        <label class="col-auto b-btn-more {classBtnMore}" for="b-input-more-{name}">...</label>\n' +
        '        <label class="col-auto b-btn-close btn-danger" for="b-input-close-{name}">&times;</label>\n' +
        '    </div>\n' +
        '    <div class="b-settings-body">{content}</div>\n' +
        '</div>',
    settingsContent: '' +
        '<div class="b-settings-content">{content}</div>',
    setting: '' +
        '<div class="row b-setting {class}">\n' +
        '    <div class="col-4">{title}</div>\n' +
        '    <div class="col-8 b-btn-group">{content}</div>\n' +
        '</div>',
    select: '' +
        '<select class="form-control form-control-sm" data-name="{name}">{options}</select>',
    selectOptgroup: '' +
        '<optgroup label="{label}">{options}</optgroup>',
    selectOption: '' +
        '<option value="{value}" {selected}>{title}</option>',
    textarea: '' +
        '<textarea class="form-control form-control-sm" rows="{rows}" placeholder="{placeholder}" data-name="{name}">{value}</textarea>',
    input: '' +
        '<input class="form-control form-control-sm" value="{value}" placeholder="{placeholder}" data-name="{name}">',
    checkbox: '' +
        '<label>\n' +
        '    <input type="checkbox" class="b-input-radio b-hidden" value="{value}" data-name="{name}" {checked}>\n' +
        '    <i class="{icon}"></i>\n' +
        '</label>',
    radio: '' +
        '<label>\n' +
        '    <input type="radio" class="b-input-radio b-hidden" value="{value}" name="b-radio-{parent}-{name}" data-name="{name}" {checked}>\n' +
        '    <i class="{icon}">{title}</i>\n' +
        '</label>'
  };

  TemplatesEdit.prototype.init = function() {
    this.data = this.dataEl.value ? JSON.parse(this.dataEl.value) : {};
    this.el.innerHTML = this.renderTabs(this.data);
  };

  TemplatesEdit.prototype.initDraggable = function() {
    this.draggable(document.querySelectorAll('.builder .b-content'), 'tabs');
    this.draggable(document.querySelectorAll('.builder .row-col'), 'items');
    this.draggable(document.querySelectorAll('.builder .b-tab'), 'row');
    this.draggableItems(document.querySelectorAll('.builder .b-fields-wrap .b-items'), 'items');
    this.resizable(document.querySelectorAll('.builder .b-resize'));
  };

  TemplatesEdit.prototype.build = function() {
    this.data = {};
    var self = this,
        checkFields = false,
        settings;

    this.el.querySelectorAll('.b-tab').forEach(function(tab) {
      var tabId = tab.getAttribute('data-id');

      self.data[tabId] = {
        title: tab.querySelector('.b-tab-title .b-title').value
      };
      if (tab.firstElementChild.checked) {
        self.data[tabId]['default'] = tab.firstElementChild.checked;
      }

      tab.querySelectorAll('.row-col-wrap').forEach(function(col, i) {
        var fields = 0, colId = 'col:' + i + ':' + col.className.match(/col-(\d+)/)[1];
        self.data[tabId][colId] = {};
        settings = JSON.parse(col.getAttribute('data-settings'));
        if (Object.keys(settings).length) {
          self.data[tabId][colId]['settings'] = settings;
        }

        col.querySelectorAll('.b-item').forEach(function(item) {
          if (item.classList.contains('b-category')) {
            self.data[tabId][colId][item.getAttribute('data-name')] = {};
            fields++;
          } else {
            if (!self.data[tabId][colId]['fields:' + fields]) {
              self.data[tabId][colId]['fields:' + fields] = {};
            }
            settings = JSON.parse(item.getAttribute('data-settings'));
            for (var k in settings) {
              if (settings.hasOwnProperty(k) && (typeof self.settings.field[k] === 'undefined' || settings[k] === self.settings.field[k])) {
                delete settings[k];
              }
            }
            self.data[tabId][colId]['fields:' + fields][item.getAttribute('data-name')] = settings;
            checkFields = true;
          }
        });

      });
    });

    this.dataEl.value = checkFields ? JSON.stringify(this.data) : '';
  };

  TemplatesEdit.prototype.events = function() {
    var self = this;

    document.addEventListener('click', function(e) {
      var target = e.target;
      self.hideSettings(target);
      if (target.classList.contains('b-btn-empty')) {
        self.onDelete(target);
      }
      if (target.id === 'builder_import') {
        self.import(document.getElementById('builder_file'));
      }
      if (target.id === 'builder_export') {
        self.export();
      }
    });

    this.el.addEventListener('click', function(e) {
      var target = e.target;
      if (target.classList.contains('b-btn-settings')) {
        self.onSettings(target);
      }
      if (target.classList.contains('b-btn-del')) {
        self.onDelete(target);
      }
      if (target.classList.contains('b-btn-add')) {
        self.onAdd(target);
      }
    });

    this.el.addEventListener('change', function(e) {
      var target = e.target;
      if (target.classList.contains('b-tab-default')) {
        this.querySelectorAll('.b-tab-default:checked').forEach(function(el) {
          if (el !== target) {
            el.checked = false;
          }
        });
        self.build();
      }
    });

    this.el.addEventListener('keyup', function(e) {
      var target = e.target, parent;
      if (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA') {
        clearTimeout(self.timer);
        self.timer = setTimeout(function() {
          parent = target.closest('.b-item').querySelector('.b-settings');
          if (parent) {
            parent.closest('.b-item').setAttribute('data-settings', JSON.stringify(self.serialize(parent, 'data-name')));
          }
          self.build();
        }, 300);
      }
    });
  };

  TemplatesEdit.prototype.hideSettings = function(target) {
    var close = false;
    document.querySelectorAll('.b-open').forEach(function(el) {
      if (!target.closest('.b-settings') || target.classList.contains('b-btn-close')) {
        el.classList.remove('b-open');
      }
      close = true;
    });
    if (close) {
      this.build();
    }
  };

  TemplatesEdit.prototype.onDelete = function(target) {
    var self = this, parent = target.closest('.b-item');
    if (target.classList.contains('b-btn-empty')) {
      this.el.querySelectorAll('.row-col .b-item').forEach(function(el) {
        self.delItem(el);
      });
      this.el.querySelectorAll('.b-tab').forEach(function(el) {
        el.parentElement.removeChild(el);
      });
    } else if (target.parentElement.classList.contains('b-btn-wrap')) {
      parent = target.closest('.row-col-wrap');
      parent.firstElementChild.querySelectorAll('.b-item').forEach(function(el) {
        self.delItem(el);
      });
      if (parent.parentNode.querySelectorAll('.row-col-wrap').length > 1) {
        parent.parentNode.removeChild(parent);
      }
    } else if (parent.classList.contains('b-tab')) {
      parent.querySelectorAll('.b-item').forEach(function(el) {
        self.delItem(el);
      });
      parent.parentNode.removeChild(parent);
    } else {
      this.delItem(parent);
    }
    if (this.el.children.length === 1) {
      this.addTab(null, true, true);
      this.el.firstElementChild.querySelector('[name="b-tab-default"]').checked = true;
    }
    this.sortItems(this.elUnusedFields, 'name');
    this.sortItems(this.elUnusedTvars, 'name');
    this.sortItems(this.elUnusedCategories, 'title');
    this.build();
  };

  TemplatesEdit.prototype.onAdd = function(target) {
    var parent = target.closest('.b-item');
    if (target.parentElement.classList.contains('b-btn-wrap')) {
      this.addRow(target.parentElement.closest('.row-col-wrap'), false);
    } else if (parent.classList.contains('b-tab')) {
      this.addTab(parent, false);
    }
    this.build();
  };

  TemplatesEdit.prototype.onSettings = function(target) {
    var parent = target.closest('.b-draggable'),
        settingsBlock = parent.lastElementChild.classList.contains('b-settings') && parent.lastElementChild;
    if (parent.classList.contains('b-open')) {
      parent.classList.remove('b-open');
    } else {
      if (!settingsBlock) {
        if (parent.classList.contains('b-field')) {
          settingsBlock = this.getFieldSettings(parent.getAttribute('data-name'), JSON.parse(parent.getAttribute('data-settings')));
        } else if (parent.classList.contains('row-col-wrap')) {
          settingsBlock = this.getColSettings(parent.getAttribute('data-name'), JSON.parse(parent.getAttribute('data-settings')));
        } else if (parent.classList.contains('b-tab')) {
          settingsBlock = false;
        }
        if (settingsBlock) {
          parent.appendChild(settingsBlock);
        }
      }
      if (settingsBlock) {
        setTimeout(function() {
          parent.classList.add('b-open');
        }, 20);
      }
    }
    this.build();
  };

  TemplatesEdit.prototype.getColSettings = function(name, data) {
    var self = this,
        settings,
        settingsTabs,
        settingsBlock;

    for (var k in this.settings.field) {
      if (this.settings.field.hasOwnProperty(k)) {
        if (typeof data[k] === 'undefined') {
          data[k] = this.settings.field[k];
        }
      }
    }

    settings = this.tpl(this.templates.setting, {
      title: 'Title',
      content: this.tpl(this.templates.input, {
        name: 'title',
        value: this.escapeHtml(data['title'])
      })
    });

    settings += this.tpl(this.templates.setting, {
      title: 'Size',
      content: this.tpl(this.templates.radio, {
        name: 'size',
        parent: name,
        value: 'sm',
        checked: data['size'] === 'sm' ? 'checked' : '',
        title: 'S'
      }) + this.tpl(this.templates.radio, {
        name: 'size',
        parent: name,
        value: 'md',
        checked: data['size'] === 'md' ? 'checked' : '',
        title: 'M'
      }) + this.tpl(this.templates.radio, {
        name: 'size',
        parent: name,
        value: 'lg',
        checked: data['size'] === 'lg' ? 'checked' : '',
        title: 'L'
      })
    });

    settings += this.tpl(this.templates.setting, {
      title: 'Position',
      content: this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'l',
        checked: data['position'] === 'l' ? 'checked' : '',
        icon: 'fa fa-list'
      }) + this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'c',
        checked: data['position'] === 'c' ? 'checked' : '',
        icon: 'fa fa-align-justify'
      }) + this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'r',
        checked: data['position'] === 'r' ? 'checked' : '',
        icon: 'fa fa-list'
      }) + this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'a',
        checked: data['position'] === 'a' ? 'checked' : '',
        title: 'A'
      })
    });

    settings += this.tpl(this.templates.setting, {
      title: 'Reverse',
      content: this.tpl(this.templates.checkbox, {
        name: 'reverse',
        parent: name,
        value: 1,
        checked: data['reverse'] ? 'checked' : '',
        icon: 'fa fa-exchange'
      })
    });

    settingsTabs = this.tpl(this.templates.settingsContent, {
      content: settings
    });

    settingsBlock = this.tpl(this.templates.settings, {
      name: name,
      classBtnMore: 'b-hidden',
      content: settingsTabs,
      settings: this.escapeHtml(JSON.stringify(data))
    }, true);

    settingsBlock.addEventListener('change', function(e) {
      var target = e.target,
          parent,
          name,
          settings;
      if (target.tagName === 'INPUT' || target.tagName === 'SELECT') {
        parent = target.closest('.b-settings');
        name = target.getAttribute('data-name');
        if (parent && name) {
          settings = self.serialize(parent, 'data-name');
          for (var k in settings) {
            if (settings.hasOwnProperty(k)) {
              if (settings[k] === self.settings.field[k]) {
                delete settings[k];
              }
            }
          }
          parent.closest('.row-col-wrap').setAttribute('data-settings', JSON.stringify(settings));
          self.build();
        }
      }
    });

    return settingsBlock;
  };

  TemplatesEdit.prototype.getFieldSettings = function(name, data) {
    var self = this,
        settingsBlock,
        fieldType,
        title,
        help,
        description,
        settingsTabs,
        settings,
        _t = ~['textarea', 'textareamini', 'richtext'].indexOf(data['type']);

    self.timer = 0;

    if (this.data_fields[name]) {
      fieldType = 'field';
      title = this.data_fields[name]['title'];
      help = this.data_fields[name]['help'];
      description = this.data_fields[name]['description'];
    } else {
      fieldType = 'tv';
      title = this.data_tvars[name]['title'];
      help = this.data_tvars[name]['help'];
      description = this.data_tvars[name]['description'];
    }

    settingsTabs = '';
    settings = '';

    for (var k in this.settings.field) {
      if (this.settings.field.hasOwnProperty(k)) {
        if (typeof data[k] === 'undefined') {
          data[k] = this.settings.field[k];
        }
      }
    }

    settings += this.tpl(this.templates.setting, {
      title: 'Title',
      content: this.tpl(this.templates.input, {
        name: 'title',
        value: this.escapeHtml(data['title']),
        placeholder: title
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Description',
      content: this.tpl(this.templates.input, {
        name: 'description',
        value: this.escapeHtml(data['description']),
        placeholder: description
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Help',
      content: this.tpl(this.templates.input, {
        name: 'help',
        value: this.escapeHtml(data['help']),
        placeholder: help
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Required',
      content: this.tpl(this.templates.checkbox, {
        name: 'required',
        value: 1,
        checked: data['required'] ? 'checked' : '',
        icon: 'fa fa-check-circle'
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Size',
      content: this.tpl(this.templates.radio, {
        name: 'size',
        parent: name,
        value: 'sm',
        checked: data['size'] === 'sm' ? 'checked' : '',
        title: 'S'
      }) + this.tpl(this.templates.radio, {
        name: 'size',
        parent: name,
        value: 'md',
        checked: data['size'] === 'md' ? 'checked' : '',
        title: 'M'
      }) + this.tpl(this.templates.radio, {
        name: 'size',
        parent: name,
        value: 'lg',
        checked: data['size'] === 'lg' ? 'checked' : '',
        title: 'L'
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Position',
      content: this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'l',
        checked: data['position'] === 'l' ? 'checked' : '',
        icon: 'fa fa-list'
      }) + this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'c',
        checked: data['position'] === 'c' ? 'checked' : '',
        icon: 'fa fa-align-justify'
      }) + this.tpl(this.templates.radio, {
        name: 'position',
        parent: name,
        value: 'r',
        checked: data['position'] === 'r' ? 'checked' : '',
        icon: 'fa fa-list'
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Reverse',
      content: this.tpl(this.templates.checkbox, {
        name: 'reverse',
        parent: name,
        value: 1,
        checked: data['reverse'] ? 'checked' : '',
        icon: 'fa fa-exchange'
      })
    });
    settingsTabs += this.tpl(this.templates.settingsContent, {
      content: settings
    });

    settings = '';
    if (fieldType === 'field') {
      settings += this.tpl(this.templates.setting, {
        title: 'Default value',
        content: this.tpl(this.templates.input, {
          name: 'default',
          value: this.escapeHtml(data['default'])
        })
      });
      settings += this.tpl(this.templates.setting, {
        title: 'Type',
        content: this.tpl(this.templates.select, {
          name: 'type',
          options: (function(a) {
            var optgroup, options;
            optgroup = a.tpl(a.templates.selectOption, {
              value: '',
              title: 'default'
            });
            for (var g in a.data_types) {
              if (a.data_types.hasOwnProperty(g)) {
                options = '';
                for (var o in a.data_types[g]) {
                  if (a.data_types[g].hasOwnProperty(o)) {
                    options += a.tpl(a.templates.selectOption, {
                      title: a.data_types[g][o],
                      value: o,
                      selected: o === data['type'] ? 'selected' : ''
                    });
                  }
                }
                optgroup += a.tpl(a.templates.selectOptgroup, {
                  label: g,
                  options: options
                });
              }
            }
            return optgroup;
          })(this)
        })
      });
      settings += this.tpl(this.templates.setting, {
        title: 'Rows',
        class: _t ? '' : 'b-hidden',
        content: this.tpl(this.templates.input, {
          name: 'rows',
          value: _t ? data['rows'] : ''
        })
      });
      settings += this.tpl(this.templates.setting, {
        title: 'Possible values',
        content: this.tpl(this.templates.textarea, {
          name: 'elements',
          value: data['elements'],
          rows: 2
        })
      });
    }
    settings += this.tpl(this.templates.setting, {
      title: 'Pattern',
      content: this.tpl(this.templates.input, {
        name: 'pattern',
        value: data['pattern']
      })
    });
    settings += this.tpl(this.templates.setting, {
      title: 'Choices (tags)',
      content: this.tpl(this.templates.input, {
        name: 'choices',
        value: data['choices'],
        placeholder: 'delimiter'
      })
    });
    settingsTabs += this.tpl(this.templates.settingsContent, {
      content: settings
    });

    settingsBlock = this.tpl(this.templates.settings, {
      name: name,
      content: settingsTabs
    }, true);

    settingsBlock.addEventListener('change', function(e) {
      var target = e.target,
          parent,
          settings,
          _t = ~['textarea', 'textareamini', 'richtext'].indexOf(target.value);

      if (target.tagName === 'INPUT' || target.tagName === 'SELECT') {
        parent = target.closest('.b-settings');
        name = target.getAttribute('data-name');
        if (parent && name) {
          settings = self.serialize(parent, 'data-name');
          for (var k in settings) {
            if (settings.hasOwnProperty(k)) {
              if (settings[k] === self.settings.field[k]) {
                delete settings[k];
              }
            }
          }
          parent.closest('.b-item').setAttribute('data-settings', JSON.stringify(settings));
          switch (name) {
            case 'required':
              parent.closest('.b-item').classList.toggle('b-required-checked', target.checked);
              break;
            case 'type':
              parent.querySelector('[data-name="rows"]').closest('.b-setting').classList.toggle('b-hidden', !_t);
              break;
          }
          self.build();
        }
      }
    });

    return settingsBlock;
  };

  TemplatesEdit.prototype.sortItems = function(el, name) {
    var list = [].slice.call(el.children).sort(function(a, b) {
      return a.getAttribute('data-' + name).toLowerCase().localeCompare(b.getAttribute('data-' + name).toLowerCase());
    });
    for (var i = 0; i < list.length; i++) {
      list[i].parentNode.appendChild(list[i]);
    }
  };

  TemplatesEdit.prototype.addRow = function(row, d) {
    if (d) {
      row.insertAdjacentHTML('beforeend', this.tpl(this.templates.col, {
        col: 12,
        content: '',
        settings: '{}'
      }));
    } else {
      row.insertAdjacentHTML('afterend', this.tpl(this.templates.col, {
        col: 12,
        content: '',
        settings: '{}'
      }));
    }
    this.initDraggable();
  };

  TemplatesEdit.prototype.addTab = function(tab, d, f) {
    var tabs = {}, id = 'tab' + new Date().getTime();
    f = typeof f !== 'undefined' ? f : false;
    tabs[id] = {
      id: id,
      title: 'New tab',
      default: d,
      'col:0:12': {}
    };
    if (f) {
      id = '#Static';
      tabs[id] = {
        id: id,
        title: 'Static',
        default: false,
        'col:0:12': {}
      };
    }
    if (tab) {
      tab.insertAdjacentHTML('afterend', this.renderTabs(tabs));
    } else {
      this.el.innerHTML = this.renderTabs(tabs);
    }
    this.initDraggable();
  };

  TemplatesEdit.prototype.delItem = function(el) {
    var name = el.getAttribute('data-name');
    if (el.classList.contains('b-category')) {
      if (!this.elUnusedCategories.querySelectorAll('[data-name="' + name + '"]').length) {
        this.elUnusedCategories.appendChild(el);
      }
      this.elUnusedTvars.querySelectorAll('[data-category="' + el.getAttribute('data-id') + '"]:not(.b-add)').forEach(function(el) {
        el.hidden = false;
      });
    } else {
      el.classList.remove('b-required-checked');
      if (el.getAttribute('data-type') === 'tv') {
        if (!this.elUnusedTvars.querySelectorAll('[data-name="' + name + '"]:not([hidden])').length) {
          this.elUnusedTvars.appendChild(el);
        }
      } else {
        if (!this.elUnusedFields.querySelectorAll('[data-name="' + name + '"]').length) {
          this.elUnusedFields.appendChild(el);
        }
      }
    }
  };

  TemplatesEdit.prototype.draggable = function(els, group) {
    var self = this;
    if (els.length) {
      els.forEach(function(el) {
        Sortable.create(el, {
          animation: 150,
          draggable: '.b-draggable',
          dragClass: 'placeholder',
          ghostClass: 'active',
          selectedClass: 'placeholder',
          filter: '.b-settings, .b-tab-title-input, .b-btn-settings, .b-btn-add',
          preventOnFilter: false,
          //handle: '.b-move',
          group: group,
          onEnd: function(e) {
            if (e.pullMode) {
              if (e.from.classList.contains('b-tab') && !e.from.querySelectorAll('.row-col-wrap').length) {
                self.addRow(e.from, true);
              }
            }
            self.build();
          }
        });
      });
    }
  };

  TemplatesEdit.prototype.draggableItems = function(els, group) {
    var self = this;
    if (els.length) {
      els.forEach(function(el) {
        Sortable.create(el, {
          animation: 150,
          draggable: '.b-draggable',
          dragClass: 'placeholder',
          ghostClass: 'active',
          selectedClass: 'placeholder',
          //handle: '.b-move',
          group: {
            name: group,
            put: false
          },
          sort: false,
          onEnd: function(e) {
            if (e.pullMode) {
              var name = e.item.getAttribute('data-name'), title = e.item.getAttribute('data-title'), id = e.item.getAttribute('data-id');
              if (e.item.classList.contains('b-category')) {
                e.item.insertAdjacentHTML('afterend', self.renderCategory({
                  title: title
                }, id));
              } else {
                e.item.insertAdjacentHTML('afterend', self.renderField({}, name));
              }
              if (id) {
                self.elUnusedTvars.querySelectorAll('[data-category="' + id + '"]').forEach(function(el) {
                  el.hidden = true;
                });
              }
              e.item.parentNode.removeChild(e.item);
            }
            self.build();
          }
        });
      });
    }
  };

  TemplatesEdit.prototype.resizable = function(els) {
    if (els.length) {
      var self = this, cols, widthCol;
      els.forEach(function(el) {
        var _w, parent, drag = false;

        el.onmousedown = function(e) {
          if (e.button) {
            return true;
          }
          e.preventDefault();
          e.stopPropagation();
          window.getSelection().removeAllRanges();

          parent = e.target.parentElement;
          parent.pos = parent.getBoundingClientRect();
          widthCol = self.el.offsetWidth / 12;
          cols = Math.round(parent.offsetWidth / widthCol);
          _w = e.clientX - parent.pos.left;

          document.onmousemove = function(e) {
            _w = e.clientX - parent.pos.left;
            if (Math.round(_w / widthCol) !== cols) {
              cols = Math.round(_w / widthCol);
              if (cols >= 12) {
                cols = 12;
              }/* else if (cols < 4) {
                cols = 4;
              }*/
              drag = true;
              parent.className = 'row col row-col-wrap b-draggable col-' + cols;
            }
          };

          document.onmouseup = function(e) {
            if (!drag) {
              return false;
            }
            drag = false;
            cols = Math.round(parent.offsetWidth / widthCol);
            parent.className = 'row col row-col-wrap b-draggable col-' + cols;
            var name = parent.getAttribute('data-name').split(':');
            name[2] = cols;
            parent.setAttribute('data-name', name.join(':'));
            if (parent.lastElementChild.classList.contains('b-settings') && parent.lastElementChild) {
              parent.removeChild(parent.lastElementChild);
            }
            self.build();
            document.onmousemove = null;
            e.preventDefault();
            e.stopPropagation();
          };
        };
      });
    }
  };

  TemplatesEdit.prototype.renderTabs = function(data) {
    var out = '';
    for (var k in data) {
      if (data.hasOwnProperty(k)) {
        var tab = data[k],
            title = tab['title'] || '';
        out += this.tpl(this.templates.tab, {
          id: k,
          title: title,
          class: k === '#Static' ? '' : 'b-draggable',
          checked: tab['default'] ? 'checked' : '',
          content: this.renderTab(data[k]),
          settings: this.escapeHtml(JSON.stringify({
            id: k,
            title: title,
            default: tab['default']
          }))
        });
      }
    }
    return out;
  };

  TemplatesEdit.prototype.renderTab = function(data) {
    var out = '', type, id;
    for (var k in data) {
      if (data.hasOwnProperty(k)) {
        [type, id] = k.split(':');
        switch (type) {
          case 'category':
            out += this.renderCategory(data[k], id);
            break;

          case 'col':
            out += this.renderCol(data[k], k);
            break;

          case 'fields':
            out += this.renderFields(data[k]);
            break;

          default:
            break;
        }
      }
    }
    return out;
  };

  TemplatesEdit.prototype.renderCategory = function(data, id) {
    return this.tpl(this.templates.category, {
      name: 'category:' + id,
      id: id,
      title: this.data_categories[id]['title']
    });
  };

  TemplatesEdit.prototype.renderCol = function(data, name) {
    var type, id, col, settings = {};
    [type, id, col] = name.split(':');
    if (typeof data['settings'] !== 'undefined') {
      settings = data['settings'];
      delete data['settings'];
    }
    return this.tpl(this.templates.col, {
      col: col,
      name: name,
      settings: this.escapeHtml(JSON.stringify(settings)),
      content: this.renderTab(data, settings)
    });
  };

  TemplatesEdit.prototype.renderFields = function(data) {
    var out = '';
    for (var k in data) {
      if (data.hasOwnProperty(k)) {
        out += this.renderField(data[k], k);
      }
    }
    return out;
  };

  TemplatesEdit.prototype.renderField = function(data, name) {
    var title, help, category;
    if (this.data_fields[name]) {
      title = this.data_fields[name]['title'];
      help = this.data_fields[name]['help'];
      category = '';
    }
    if (this.data_tvars[name]) {
      title = this.data_tvars[name]['title'];
      help = this.data_tvars[name]['help'];
      category = this.data_tvars[name]['category'];
    }
    return this.tpl(this.templates.field, {
      name: this.escapeHtml(name),
      type: this.data_tvars[name] ? 'tv' : 'field',
      category: category,
      title: this.escapeHtml(data['title'] && data['title'] !== title ? data['title'] : title),
      help: this.escapeHtml(data['help'] && data['help'] !== help ? data['help'] : help),
      default: {
        title: this.escapeHtml(title),
        help: this.escapeHtml(help),
        value: this.escapeHtml(data['default'])
      },
      required: data['required'] ? 'checked' : '',
      settings: this.escapeHtml(JSON.stringify(data))
    });
  };

  TemplatesEdit.prototype.import = function(el) {
    if (typeof el.files !== 'undefined') {
      var self = this, file = el.files[0], reader = new FileReader();
      if (file && ~file.name.indexOf('.json')) {
        reader.onload = function() {
          self.dataEl.value = reader.result;
          self.init();
          self.initDraggable();
        };
        reader.readAsText(file);
      }
    }
  };

  TemplatesEdit.prototype.export = function() {
    this.build();
    var blob = new Blob([this.dataEl.value]);
    var a = document.createElement('a');
    a.href = URL.createObjectURL.call(this, blob, {
      type: 'text/json;charset=utf-8;'
    });
    a.download = 'template.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };

  TemplatesEdit.prototype.tpl = function(template, data, isDom, cleanKeys) {
    data = data || {};
    isDom = isDom || false;
    if (typeof cleanKeys === 'undefined') {
      cleanKeys = true;
    }
    var html = template.replace(/\{([\w\.]*)\}/g, function(str, key) {
      var keys = key.split('.'), value = data[keys.shift()];
      [].slice.call(keys).forEach(function(item) {
        value = typeof value !== 'undefined' && value[item] || '';
      });
      return (value === null || value === undefined) ? (cleanKeys ? '' : str) : value;
    });
    if (typeof data === 'boolean') {
      isDom = data;
    }
    if (isDom) {
      var fragment = document.createElement('div');
      fragment.innerHTML = html;
      return fragment.children[0];
    } else {
      return html;
    }
  };

  TemplatesEdit.prototype.serialize = function(form, attrName, ignoreEmpty, string) {
    var serialized = string ? [] : {};
    string = string || false;
    attrName = attrName || 'name';
    ignoreEmpty = ignoreEmpty || true;
    if (form.tagName !== 'FORM') {
      form.elements = form.querySelectorAll('input, select, textarea, button');
    }
    for (var i = 0; i < form.elements.length; i++) {
      var field = form.elements[i], name = field.getAttribute(attrName);
      if (!name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;
      if (field.type === 'select-multiple') {
        for (var n = 0; n < field.options.length; n++) {
          if ((!field.options[n].selected) || (field.options[n].value === '' && ignoreEmpty)) continue;
          if (string) {
            serialized.push(encodeURIComponent(name) + '=' + encodeURIComponent(field.options[n].value));
          } else {
            serialized[name] = field.options[n].value;
          }
        }
      } else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
        if (string) {
          serialized.push(encodeURIComponent(name) + '=' + encodeURIComponent(field.value));
        } else {
          if (field.value === '' && ignoreEmpty) {
            continue;
          }
          serialized[name] = field.value;
        }
      }
    }
    return string ? serialized.join('&') : serialized;
  };

  TemplatesEdit.prototype.escapeHtml = function(text) {
    text = text || '';
    return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  };

  return new TemplatesEdit(el, config);
};
