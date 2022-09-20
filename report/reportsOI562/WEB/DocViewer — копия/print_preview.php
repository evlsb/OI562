<script type="text/javascript">
var OLECMDID = 7;
/* OLECMDID values:
* 6 - print
* 7 - print preview
* 1 - open window
* 4 - Save As
*/
var PROMPT = 2; // 2 DONTPROMPTUSER
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);

  

function printPage(){
 if(WebBrowser1)
 {
        try{
            WebBrowser1.ExecWB(OLECMDID, PROMPT); 
        }
        catch(e){
                window.print();
        }
 }
 else{
        alert("no activex");
        window.print();
 }
} 
</script>