<!------ templatesEdit ------->
<style>
    .input-group .input-group-btn { display: flex; -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none }
    .form-row .col-auto { padding-left: 0 }
    .form-row .col-title { width: 15rem }
    .form-row .row-col { display: flex; flex-wrap: wrap; flex-direction: row; align-content: start; padding-right: .75rem }
    .form-row .row-col > .row:not(.col):not(.col-sm):not(.col-md):not(.col-lg):not(.col-xl) { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100% }
    .form-row .row-col > .row.col, .form-row .row-col > .row.col-sm, .form-row .row-col > .row.col-md, .form-row .row-col > .row.col-lg, .form-row .row-col > .row.col-xl { align-content: start; padding: 0; margin-right: 0 }
    .form-row.form-row-date > div:last-child, .form-row.form-row-image > div:last-child, .form-row.form-row-file > div:last-child { display: flex; flex-wrap: wrap; flex-direction: row; align-items: flex-start }
    .form-row.form-row-date .DatePicker, .form-row.form-row-image input.form-control[type="text"], .form-row.form-row-file input.form-control[type="text"] { flex-basis: 0; flex-grow: 1; max-width: 100%; width: 100% !important; min-width: auto !important }
    .form-row.form-row-date .input-group-btn, .form-row.form-row-date input + a, .form-row.form-row-image input + input[type="button"], .form-row.form-row-file input + input[type="button"] { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none; margin: 0 }
    .form-row.form-row-date input + a, .form-row.form-row-image input + input[type="button"], .form-row.form-row-file input + input[type="button"] { margin-left: -1px }
    .form-row.form-row-date input + a .form-control { display: flex; flex-wrap: wrap; align-content: center; height: 100% }
    .form-control-sm, .input-group-sm > .form-control, .input-group-sm > .input-group-addon, .input-group-sm > .input-group-btn > .btn, input.form-control-sm, .btn-group-sm > .btn, .btn-sm, .input-group-addon.form-control-sm, .input-group-sm > .input-group-addon, .input-group-sm > .input-group-btn > .input-group-addon.btn, .input-group-sm > .form-control + a .form-control { padding: 0.46153846em .5rem !important; font-size: .6772rem !important; border-radius: .1rem }
    .input-group-sm .form-checkbox.form-control, .input-group-md .form-checkbox.form-control { padding: 0 !important }
    .row-reverse { flex-direction: row-reverse }
    .column-reverse { flex-direction: column-reverse }
    .form-row-checkbox { align-items: center }
    input[type=checkbox], input[type=radio] { padding: .5em }
    .warning + [data-tooltip].fa-question-circle { margin: 0.3rem 0.5rem 0; }
    input[name*="date"] + .input-group-addon, input[name="createdon"] + .input-group-addon, input[name="editedon"] + .input-group-addon, input[name="menuindex"] + .input-group-addon { float: left; width: auto }
    form#mutate input[name="menuindex"] { flex-basis: 0; flex-grow: 1; padding: 0.46153846em .5em; max-width: 100%; text-align: inherit }
    .form-control-lg, .input-group-lg > .form-control, .input-group-lg > .input-group-addon, .input-group-lg > .input-group-btn > .btn, input.form-control-lg, .btn-group-lg > .btn, .btn-lg, .input-group-addon.form-control-lg, .input-group-lg > .input-group-addon, .input-group-lg > .input-group-btn > .input-group-addon.btn, .input-group-lg > .input-group-btn > select.btn:not([size]):not([multiple]), .input-group-lg > select.form-control:not([size]):not([multiple]), .input-group-lg > select.input-group-addon:not([size]):not([multiple]), select.form-control-lg:not([size]):not([multiple]), .input-group-lg > .form-control + a { height: 2.5625rem }
    #documentPane input[name^=tv]:not([class*=mtv]) + input[type=button].form-control { margin-top: 0 }
    .input-group-lg > textarea.form-control { height: inherit }
    .image_for_field[data-image] { display: block; content: ""; width: 120px; height: 120px; margin: .1rem .1rem 0 0; border: 1px #ccc solid; background: #fff 50% 50% no-repeat; background-size: contain; cursor: pointer }
    .image_for_field[data-image=""] { display: none }
    .choicesList { float: left; padding: .25rem 0; width: 100% }
    .choicesList::after { content: ""; display: table; width: 100% }
    .choicesList i { float: left; padding: .15rem .35rem; margin: 0 .35rem .35rem 0; min-width: 1rem; text-align: center; font: normal .75rem/normal sans-serif; line-height: 1; background-color: rgba(130, 130, 130, 0.2); border-radius: .35rem; cursor: pointer }
    .choicesList i.selected { color: #fff; background-color: #1976d2 }
    .select-which-editor { float: right; position: relative; z-index: 9; margin: 0 0 .25rem }
    .select-which-editor ~ div { width: 100%; }
    .mce-tinymce, .mce-top-part::before { -webkit-box-shadow: none !important; box-shadow: none !important; }
    textarea:not([class]) { display: block }
    @media (max-width: 767.98px) {
        .form-row .col-title { width: 100% }
    }
</style>
<script>
  function renderTvImageCheck(a)
  {
    var b = document.getElementById('image_for_' + a.target.id),
        c = new Image;
    a.target.value ? (c.src = "<?= MODX_SITE_URL ?>" + a.target.value, c.onerror = function() {
      b.style.backgroundImage = '', b.setAttribute('data-image', '');
    }, c.onload = function() {
      b.style.backgroundImage = 'url(\'' + this.src + '\')', b.setAttribute('data-image', this.src);
    }) : (b.style.backgroundImage = '', b.setAttribute('data-image', ''));
  }

  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.choicesList').forEach(function(e) {
      e.addEventListener('click', function(e) {
        var t = e.target;
        if ('I' === t.tagName) {
          var n = document.getElementById(this.getAttribute('data-target')), a = this.getAttribute('data-separator'), i = {}, c = '' + t.innerHTML;
          if ('' === n.value) {
            i[c] = !0, t.classList.add('selected');
          } else {
            var d = new RegExp(a.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'));
            i = n.value.split(d), i = Object.keys(i).filter(i.hasOwnProperty.bind(i)).reduce(function(e, t) {return e[i[t].trim()] = t, e;}, {}), t.classList.contains('selected') ? (delete i[c], t.classList.remove('selected')) : (i[c] = !0, t.classList.add('selected'));
          }
          n.value = Object.keys(i).join(a);
        }
      }, !0);
    }), document.mutate.save.addEventListener('click', function() {
      var e = document.querySelector('[required]:invalid');
      if (e) {
        var t = e.closest('.tab-page').id;
        for (var n in tpSettings.pages) {
          if (tpSettings.pages.hasOwnProperty(n) && tpSettings.pages[n].element.id === t) {
            tpSettings.setSelectedIndex(tpSettings.pages[n].index);
            break;
          }
        }
      }
    }, !1), document.mutate.querySelectorAll('label[for]').forEach(function(e) {
      e.addEventListener('mousedown', function(e) {
        if (e.ctrlKey) {
          e.preventDefault();
          var t = document.createElement('input'), n = document.activeElement;
          t.value = '[*' + this.getAttribute('data-key') + '*]', document.body.appendChild(t), t.select(), document.execCommand('copy'), document.body.removeChild(t), n.focus();
        }
      }, !1);
    });
  }, !1);

  !function(a) {
    /** @namespace ELEMENT.msMatchesSelector */
    /** @namespace ELEMENT.oMatchesSelector */
    /** @namespace ELEMENT.mozMatchesSelector */
    a.matches = a.matches || a.mozMatchesSelector || a.msMatchesSelector || a.oMatchesSelector || a.webkitMatchesSelector, a.closest = a.closest || function(a) {
      return this ? this.matches(a) ? this : this.parentElement ? this.parentElement.closest(a) : null : null;
    };
  }(Element.prototype);
</script>
<?= $data['content'] ?>
<!------ /templatesEdit/ ------->
