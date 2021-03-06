{!! HTML::script('Balin/plugins/inputmask.js') !!}


<script>
	$(".money").inputmask({ rightAlign: false, alias: "numeric", prefix: 'IDR ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
	$(".money-right").inputmask({ rightAlign: true, alias: "numeric", prefix: 'IDR ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
	$(".date-time-format").inputmask({
        mask: "d-m-y h:s",
        placeholder: "dd-mm-yyyy hh:mm",
        alias: "datetime",
    }); 
    $(".date-format").inputmask({
        mask: "d-m-y",
        placeholder: "dd-mm-yyyy",
        alias: "date",
    }); 
</script>
