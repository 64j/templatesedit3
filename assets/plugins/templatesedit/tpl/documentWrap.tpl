<!------ templatesEdit ------->
<style>
    .warning + [data-tooltip].fa-question-circle { margin: 0.3rem 0.5rem 0; }
    input[name*="date"] + .input-group-addon, input[name="createdon"] + .input-group-addon, input[name="editedon"] + .input-group-addon, input[name="menuindex"] + .input-group-addon { float: left; width: auto }
    form#mutate input[name="menuindex"] { width: 100%; width: calc(100% + 1px); max-width: calc(100% + 1px); margin-left: calc(-1px); padding: 0.46153846em .5em; text-align: inherit }
    .input-group-date.d-block { display: table !important; width: 100% !important;  }
    .input-group-date.d-block > input { float: none !important; width: inherit !important; }
    .image_for_tv[data-image] { display: block; content: ""; width: 120px; height: 120px; margin: .1rem .1rem 0 0; border: 1px #ccc solid; background: #fff 50% 50%; background-size: contain; cursor: pointer }
    .image_for_tv[data-image=""] { display: none }
    .choicesList { padding: .25rem 0 }
    .choicesList::after { content: ""; display: table; width: 100% }
    .choicesList i { float: left; padding: .15rem; margin-left: .25rem; min-width: 1rem; text-align: center; font-style: normal; line-height: 1; background-color: rgba(130, 130, 130, 0.2); border-radius: 2px; cursor: pointer }
    .choicesList i.selected { color: #fff; background-color: rgba(130, 130, 130, 0.8) }
    .choicesList i:first-child { margin-left: 0 }
    .mce-tinymce, .mce-top-part::before { -webkit-box-shadow: none !important; box-shadow: none !important; }
    textarea:not([class]) { display: block }
</style>
<script>
  function renderTvImageCheck(e)
  {
    var elThumb = document.getElementById('image_for_' + e.target.id);
    var img = new Image();
    if (e.target.value) {
      img.src = '[+MODX_SITE_URL+]' + e.target.value;
      img.onerror = function() {
        elThumb.style.backgroundImage = '';
        elThumb.setAttribute('data-image', '');
      };
      img.onload = function() {
        elThumb.style.backgroundImage = 'url(\'' + this.src + '\')';
        elThumb.setAttribute('data-image', this.src);
      };
    } else {
      elThumb.style.backgroundImage = '';
      elThumb.setAttribute('data-image', '');
    }
  }

  document.addEventListener('DOMContentLoaded', function() {

    // show choices list
    document.querySelectorAll('.choicesList').forEach(function(el) {
      el.addEventListener('click', function(e) {
        var target = e.target;
        if (target.tagName === 'I') {
          var field = document.getElementById(this.getAttribute('data-target')),
              valueSeparator = this.getAttribute('data-separator'),
              values = [];
          if (field.value === '') {
            values.push(target.innerHTML);
            target.classList.add('selected');
          } else {
            var re = function(s) {
              return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            };
            var r = new RegExp(re(valueSeparator));
            values = field.value.split(r);
            if (target.classList.contains('selected')) {
              values.splice(values.indexOf(target.innerHTML), 1);
              target.classList.remove('selected');
            } else {
              values.push(target.innerHTML);
              target.classList.add('selected');
            }
          }
          field.value = values.join(valueSeparator);
        }
      }, true);
    });

    // check required fields
    document.mutate.save.addEventListener('click', function() {
      var el = document.querySelector('[required]:invalid');
      if (el) {
        var tabId = el.closest('.tab-page').id;
        for (var k in tpSettings.pages) {
          if (tpSettings.pages.hasOwnProperty(k) && tpSettings.pages[k].element.id === tabId) {
            tpSettings.setSelectedIndex(tpSettings.pages[k].index);
            break;
          }
        }
      }
    }, false);

  }, false);

  // Elements prototype
  (function(ELEMENT) {
    /** @namespace ELEMENT.msMatchesSelector */
    /** @namespace ELEMENT.oMatchesSelector */
    /** @namespace ELEMENT.mozMatchesSelector */
    ELEMENT.matches = ELEMENT.matches || ELEMENT.mozMatchesSelector || ELEMENT.msMatchesSelector || ELEMENT.oMatchesSelector || ELEMENT.webkitMatchesSelector;
    ELEMENT.closest = ELEMENT.closest || function closest(selector) {
      if (!this) {
        return null;
      }
      if (this.matches(selector)) {
        return this;
      }
      if (!this.parentElement) {
        return null;
      } else {
        return this.parentElement.closest(selector);
      }
    };
  }(Element.prototype));
</script>
[+content+]
<!------ /templatesEdit/ ------->
