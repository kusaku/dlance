<script src="/templates/js/validation/jquery.validationEngine.js"
	type="text/javascript"></script>
<link
	rel="stylesheet"
	href="/templates/js/validation/css/validationEngine.jquery.css"
	type="text/css" media="screen" title="no title" charset="utf-8" />

<script type="text/javascript" language="javascript">
function cssmenuhover()
{
        if(!document.getElementById("cssmenu"))
                return;
        var lis = document.getElementById("cssmenu").getElementsByTagName("LI");
        for (var i=0;i<lis.length;i++)
        {
                lis[i].onmouseover=function(){this.className+=" iehover";}
                lis[i].onmouseout=function() {this.className=this.className.replace(new RegExp(" iehover\\b"), "");}
        }
}
if (window.attachEvent)
        window.attachEvent("onload", cssmenuhover);
</script>
