<div class="input-group-date [+dateGroupClass+]">
    <input id="[+id+]" class="[+class+] DatePicker unstyled" name="[+name+]" value="[+value+]" onblur="documentDirty=true;" placeholder="[+placeholder+]" [+disabled+] />
    <span class="input-group-btn">
		<a class="btn text-danger" href="javascript:;" onclick="document.mutate.[+name+].value=''; documentDirty=true; return true;">
			<i class="[+icon+]" title="[+icon.title+]"></i>
		</a>
	</span>
</div>