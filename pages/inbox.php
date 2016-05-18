	<body> 
<div id='result_table'>
<h1 align="center">Messaggi Inbox</h1> 
</div>

<script type='text/javascript' language='javascript'>
$( document ).ready(function(){

$.ajax({
        url: '/BasiDati/function/getTabletInbox.php',
        type:'POST',
        dataType: 'json',
        success: function(output_string){
                $('#result_table').append(output_string);
            }
        });   

});
</script>

	</body>
