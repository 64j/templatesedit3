<!------ templatesEdit ------->
<style>
    .row { display: flex; flex-wrap: wrap }
    .row::after { display: none }
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
    .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
    .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
    .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
    .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
    .col-xl-auto { position: relative; width: 100%; min-height: 0; padding-left: 1rem; padding-right: 1rem }
    .col { flex-basis: 0; flex-grow: 1; max-width: 100% }
    .col-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none }
    .col-0 { max-width: 5px }
    .col-1 { -ms-flex: 0 0 8.333333%; flex: 0 0 8.333333%; max-width: 8.333333% }
    .col-2 { -ms-flex: 0 0 16.666667%; flex: 0 0 16.666667%; max-width: 16.666667% }
    .col-3 { -ms-flex: 0 0 25%; flex: 0 0 25%; max-width: 25% }
    .col-4 { -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 33.333333% }
    .col-5 { -ms-flex: 0 0 41.666667%; flex: 0 0 41.666667%; max-width: 41.666667% }
    .col-6 { -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 50% }
    .col-7 { -ms-flex: 0 0 58.333333%; flex: 0 0 58.333333%; max-width: 58.333333% }
    .col-8 { -ms-flex: 0 0 66.666667%; flex: 0 0 66.666667%; max-width: 66.666667% }
    .col-9 { -ms-flex: 0 0 75%; flex: 0 0 75%; max-width: 75% }
    .col-10 { -ms-flex: 0 0 83.333333%; flex: 0 0 83.333333%; max-width: 83.333333% }
    .col-11 { -ms-flex: 0 0 91.666667%; flex: 0 0 91.666667%; max-width: 91.666667% }
    .col-12 { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100% }
    @media (min-width: 576px) {
        .col-sm { -ms-flex-preferred-size: 0; flex-basis: 0; -ms-flex-positive: 1; flex-grow: 1; max-width: 100%; }
        .col-sm-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none; }
        .col-sm-1 { -ms-flex: 0 0 8.333333%; flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-sm-2 { -ms-flex: 0 0 16.666667%; flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-sm-3 { -ms-flex: 0 0 25%; flex: 0 0 25%; max-width: 25%; }
        .col-sm-4 { -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-sm-5 { -ms-flex: 0 0 41.666667%; flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-sm-6 { -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 50%; }
        .col-sm-7 { -ms-flex: 0 0 58.333333%; flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-sm-8 { -ms-flex: 0 0 66.666667%; flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-sm-9 { -ms-flex: 0 0 75%; flex: 0 0 75%; max-width: 75%; }
        .col-sm-10 { -ms-flex: 0 0 83.333333%; flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-sm-11 { -ms-flex: 0 0 91.666667%; flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-sm-12 { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100%; }
    }
    @media (min-width: 768px) {
        .col-md { -ms-flex-preferred-size: 0; flex-basis: 0; -ms-flex-positive: 1; flex-grow: 1; max-width: 100%; }
        .col-md-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none; }
        .col-md-1 { -ms-flex: 0 0 8.333333%; flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-md-2 { -ms-flex: 0 0 16.666667%; flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-md-3 { -ms-flex: 0 0 25%; flex: 0 0 25%; max-width: 25%; }
        .col-md-4 { -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-md-5 { -ms-flex: 0 0 41.666667%; flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-md-6 { -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 50%; }
        .col-md-7 { -ms-flex: 0 0 58.333333%; flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-md-8 { -ms-flex: 0 0 66.666667%; flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-md-9 { -ms-flex: 0 0 75%; flex: 0 0 75%; max-width: 75%; }
        .col-md-10 { -ms-flex: 0 0 83.333333%; flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-md-11 { -ms-flex: 0 0 91.666667%; flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-md-12 { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100%; }
    }
    @media (min-width: 992px) {
        .col-lg { -ms-flex-preferred-size: 0; flex-basis: 0; -ms-flex-positive: 1; flex-grow: 1; max-width: 100%; }
        .col-lg-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none; }
        .col-lg-1 { -ms-flex: 0 0 8.333333%; flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-lg-2 { -ms-flex: 0 0 16.666667%; flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-lg-3 { -ms-flex: 0 0 25%; flex: 0 0 25%; max-width: 25%; }
        .col-lg-4 { -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-lg-5 { -ms-flex: 0 0 41.666667%; flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-lg-6 { -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 50%; }
        .col-lg-7 { -ms-flex: 0 0 58.333333%; flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-lg-8 { -ms-flex: 0 0 66.666667%; flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-lg-9 { -ms-flex: 0 0 75%; flex: 0 0 75%; max-width: 75%; }
        .col-lg-10 { -ms-flex: 0 0 83.333333%; flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-lg-11 { -ms-flex: 0 0 91.666667%; flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-lg-12 { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100%; }
    }
    @media (min-width: 1200px) {
        .col-xl { -ms-flex-preferred-size: 0; flex-basis: 0; -ms-flex-positive: 1; flex-grow: 1; max-width: 100%; }
        .col-xl-auto { -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none; }
        .col-xl-1 { -ms-flex: 0 0 8.333333%; flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-xl-2 { -ms-flex: 0 0 16.666667%; flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-xl-3 { -ms-flex: 0 0 25%; flex: 0 0 25%; max-width: 25%; }
        .col-xl-4 { -ms-flex: 0 0 33.333333%; flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-xl-5 { -ms-flex: 0 0 41.666667%; flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-xl-6 { -ms-flex: 0 0 50%; flex: 0 0 50%; max-width: 50%; }
        .col-xl-7 { -ms-flex: 0 0 58.333333%; flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-xl-8 { -ms-flex: 0 0 66.666667%; flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-xl-9 { -ms-flex: 0 0 75%; flex: 0 0 75%; max-width: 75%; }
        .col-xl-10 { -ms-flex: 0 0 83.333333%; flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-xl-11 { -ms-flex: 0 0 91.666667%; flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-xl-12 { -ms-flex: 0 0 100%; flex: 0 0 100%; max-width: 100%; }
    }
    .input-group { position: relative; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; }
    .input-group .input-group-btn { display: flex; -ms-flex: 0 0 auto; flex: 0 0 auto; width: auto; max-width: none }
    .form-row .col-auto { padding-left: 0 }
    .form-row .col-title { width: 15rem }
    .form-row .row-col { display: flex; flex-wrap: wrap; flex-direction: row; align-content: start; padding: 0 }
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
    form#mutate input[name="menuindex"] { flex-basis: 0; flex-grow: 1;  padding: 0.46153846em .5em; max-width: 100%; text-align: inherit }
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
    .mce-tinymce, .mce-top-part::before { -webkit-box-shadow: none !important; box-shadow: none !important; }
    textarea:not([class]) { display: block }
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
    document.querySelectorAll('.choicesList').forEach(function(a) {
      a.addEventListener('click', function(a) {
        var b = a.target;
        if ('I' === b.tagName) {
          var c = document.getElementById(this.getAttribute('data-target')),
              d = this.getAttribute('data-separator'),
              e = {},
              h = '' + b.innerHTML;
          if ('' === c.value) {
            e[h] = !0, b.classList.add('selected');
          } else {
            var f = function(a) {
                  return a.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                },
                g = new RegExp(f(d));
            e = c.value.split(g), e = Object.keys(e).filter(e.hasOwnProperty.bind(e)).reduce(function(a, b) {
              return a[e[b].trim()] = b, a;
            }, {}), b.classList.contains('selected') ? (delete e[h], b.classList.remove('selected')) : (e[h] = !0, b.classList.add('selected'));
          }
          c.value = Object.keys(e).join(d);
        }
      }, !0);
    }), document.mutate.save.addEventListener('click', function() {
      var a = document.querySelector('[required]:invalid');
      if (a) {
        var b = a.closest('.tab-page').id;
        for (var c in tpSettings.pages) {
          if (tpSettings.pages.hasOwnProperty(c) && tpSettings.pages[c].element.id === b) {
            tpSettings.setSelectedIndex(tpSettings.pages[c].index);
            break;
          }
        }
      }
    }, !1);
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
