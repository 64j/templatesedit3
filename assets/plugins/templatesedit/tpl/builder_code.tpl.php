<div class="container container-body px-0">
    <p class="px-3">Edit config: <strong><?= $data['filename'] ?? '' ?></strong></p>

    <div class="section-editor clearfix">
        <textarea name="templatesedit_builder_code" id="templatesedit_builder_code" rows="40"
                  onchange="documentDirty=true;"><?= $data['config'] ?? '' ?></textarea>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (window['myCodeMirrors'] && window['myCodeMirrors']['post']) {
      var config = window['myCodeMirrors']['post']['options']

      window['myCodeMirrors']['templatesedit_builder_code'] = CodeMirror.fromTextArea(
        document.getElementById('templatesedit_builder_code'),
        {
          mode: 'php',
          theme: config['theme'],
          defaulttheme: config['defaulttheme'],
          darktheme: config['darktheme'],
          indentUnit: config['indentUnit'],
          tabSize: config['tabSize'],
          lineNumbers: config['lineNumbers']
        }
      )
    }
  })
</script>
