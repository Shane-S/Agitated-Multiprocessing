<div class="control-group">
    <label class="control-label" for="{name}">{label}</label>
    <div class="controls">
        <div class="input-append bootstrap-timepicker">
            <input id="{name}" name="{name}" type="text" class="input-small" {disabled}>{value}</input>';
            <span class="add-on"><i class="icon-time"></i></span>
        </div>        
        <small>{explain}</small>
    </div>
</div>
<script>$('#{name}').timepicker({template:false,showMeridian:false});</script>
