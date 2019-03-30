<style>
    .builder .row { display: flex; flex-wrap: wrap; margin-left: -.25rem; margin-right: -.25rem }
    .builder .row.col { max-width: none }
    .builder .col-1, .builder .col-2, .builder .col-3, .builder .col-4, .builder .col-5, .builder .col-6, .builder .col-7, .builder .col-8, .builder .col-9, .builder .col-10, .builder .col-11, .builder .col-12, .builder .col, .builder .col-auto { position: relative; width: 100%; min-height: 0; padding-left: .25rem; padding-right: .25rem; padding-bottom: .5rem }
    .builder .col { flex-basis: 0; flex-grow: 1; max-width: 100% }
    .builder .col-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none }
    .builder .col-1 { -ms-flex: 0 0 8.333333%; flex: 0 0 8.333333%; max-width: 8.333333% }
    .builder .col-2 { -ms-flex: 0 0 16.666667%; flex: 0 0 16.666667%; max-width: 16.666667% }
    .builder .col-3 { -ms-flex: 0 0 25%; flex: 0 0 25%; max-width: 25% }
    .builder .col-4 { -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 33.333333% }
    .builder .col-5 { -ms-flex: 0 0 41.666667%; flex: 0 0 41.666667%; max-width: 41.666667% }
    .builder .col-6 { -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 50% }
    .builder .col-7 { -ms-flex: 0 0 58.333333%; flex: 0 0 58.333333%; max-width: 58.333333% }
    .builder .col-8 { -ms-flex: 0 0 66.666667%; flex: 0 0 66.666667%; max-width: 66.666667% }
    .builder .col-9 { -ms-flex: 0 0 75%; flex: 0 0 75%; max-width: 75% }
    .builder .col-10 { -ms-flex: 0 0 83.333333%; flex: 0 0 83.333333%; max-width: 83.333333% }
    .builder .col-11 { -ms-flex: 0 0 91.666667%; flex: 0 0 91.666667%; max-width: 91.666667% }
    .builder .col-12 { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100% }
    .builder .align-items-center { align-items: center }
    .builder .b-header { overflow: hidden; }
    .builder .b-content { }
    .builder .b-tab { padding: 1rem; margin-bottom: 1rem; border: 1px solid #ddd }
    .builder [contenteditable] { padding: .25rem; border: 1px solid #ddd; background-color: #fff }
    .builder .b-tab-options { line-height: 1 }
    .builder .b-tab-options label { padding: .5rem; margin: 0 0 .25rem }
    .builder .b-tab-options input[type="radio"] { margin-top: -.25rem }
    .builder .b-fields-wrap { padding-bottom: 1.5rem }
    .builder .b-fields { width: 15rem; border: 1px solid #ddd; background-color: #fbfbfb }
</style>
<div class="container container-body builder">
    <div class="b-header">
        <div class="float-xs-right">
            <a href="javascript:;" class="btn btn-primary btn-sm btn-reset">Сбросить по умолчанию</a>
            <a href="javascript:;" class="btn btn-danger btn-sm btn-empty">Очистить</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <b>Доступные поля</b>
        </div>
    </div>
    <div class="row">
        <div class="col-auto b-fields-wrap">
            <div class="h-100 b-fields">

            </div>
        </div>
        <div class="col">
            <div id="builder" class="b-content">

            </div>
        </div>
    </div>
</div>
<script>
  var builder_config = {
    'General': {
      'title': 'Общие',
      'fields': {
        'pagetitle': {
          'class': 'form-control-lg'
        },
        'longtitle': [],
        'description': [],
        'menutitle': [],
        'parent': [],
        'weblink': [],
        'template': []
      }
    },
    'Content': {
      'title': 'Описание',
      'fields': {
        'introtext': {
          'titleClass': 'col-xs-12',
          'fieldClass': 'col-xs-12',
          'rows': 5
        },
        'content': {
          'titleClass': 'col-xs-12 form-row pt-1',
          'fieldClass': 'col-xs-12',
          'selectClass': 'float-xs-right',
          'rows': 15
        },
        'richtext': []
      }
    },
    'TVs': {
      'default': true,
      'titleClass': 'col-xs-12',
      'fieldClass': 'col-xs-12',
      'dateGroupClass': 'd-block',
      'title': 'TVs'
    },
    'Seo': {
      'title': 'SEO',
      'fields': {
        'metaTitle': [],
        'titl': [],
        'metaDescription': [],
        'desc': [],
        'metaKeywords': [],
        'keyw': [],
        'alias': [],
        'link_attributes': [],
        'menuindex': [],
        'hidemenu': [],
        'noIndex': [],
        'sitemap_exclude': [],
        'sitemap_priority': [],
        'sitemap_changefreq': []
      }
    },
    'Settings': {
      'title': 'Настройка страницы',
      'fields': {
        'published': [],
        'alias_visible': [],
        'isfolder': [],
        'donthit': [],
        'contentType': [],
        'type': [],
        'content_dispo': [],
        'pub_date': [],
        'unpub_date': [],
        'createdon': [],
        'editedon': [],
        'searchable': [],
        'cacheable': [],
        'syncsite': []
      }
    }
  };

  var templates = {
    tab: '' +
        '<div class="b-tab b-draggable">' +
        '   <div class="row align-items-center">' +
        '       <div class="col-auto"><i class="fa fa-bars float-xs-left b-move"></i></div>' +
        '       <div class="col"><input type="text" class="b-title" value="{title}" placeholder="название вкладки"></div>' +
        '   </div>' +
        '   <div class="row align-items-center b-tab-options">' +
        '       <input type="radio" id="tab-options-radio-{id}" name="tab-options-radio" {checked}>' +
        '       <label for="tab-options-radio-{id}">по умолчанию</label>' +
        '       <div class="col">' +
        '           <input type="text" class="form-control form-control-sm b-tab-titleClass" value="{titleClass}" placeholder="общий класс для названий полей">' +
        '       </div>' +
        '       <div class="col">' +
        '           <input type="text" class="form-control form-control-sm b-tab-fieldClass" value="{fieldClass}" placeholder="общий класс для полей">' +
        '       </div>' +
        '       <div class="col">' +
        '           <input type="text" class="form-control form-control-sm b-tab-dateGroupClass" value="{dateGroupClass}" placeholder="общий класс для групп дат">' +
        '       </div>' +
        '   </div>' +
        '   <div class="row col">{content}</div>' +
        '</div>',
    cols: '',
    col: '',
    fields: ''
  };

  function renderTab(tab)
  {
    var out = '';
    for (var k in tab) {
      if (tab.hasOwnProperty(k)) {
        if (typeof tab[k]['cols'] !== 'undefined') {
          out += renderCols(tab[k]['cols']);
        } else if (typeof tab[k]['fields'] !== 'undefined') {
          out += renderFields(tab[k]['fields']);
        }
      }
    }
    return out;
  }

  function renderCols(cols)
  {
    var out = '';
    for (var k in cols) {
      if (cols.hasOwnProperty(k)) {
        if (typeof cols[k]['fields'] !== 'undefined') {
          out += renderFields(cols[k]['fields']);
        }
      }
    }
    return out;
  }

  function renderFields(fields)
  {

  }

  function renderField(field)
  {

  }

  function _tpl(template, data, isDom, cleanKeys)
  {
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

  var builder_wrap = document.getElementById('builder');
  var out = '';
  for (var k in builder_config) {
    if (builder_config.hasOwnProperty(k)) {
      var tab = builder_config[k];
      out += _tpl(templates.tab, {
        id: k,
        title: tab['title'] ? tab['title'] : '',
        checked: tab['default'] ? 'checked' : '',
        titleClass: tab['titleClass'] ? tab['titleClass'] : '',
        fieldClass: tab['fieldClass'] ? tab['fieldClass'] : '',
        dateGroupClass: tab['dateGroupClass'] ? tab['dateGroupClass'] : '',
        content: renderTab(builder_config[k])
      });
    }
  }

  builder_wrap.innerHTML = out;
</script>
