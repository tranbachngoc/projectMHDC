<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: LEFT-->
<td width="602" valign="top">
<script language="javascript" type="text/javascript">
    function getElement(aID)
    {
        return (document.getElementById) ?
            document.getElementById(aID) : document.all[aID];
    }

    function getIFrameDocument(aID)
    {
        var rv = null;
        var frame=getElement(aID);
        // if contentDocument exists, W3C compliant (e.g. Mozilla)

        if (frame.contentDocument)
            rv = frame.contentDocument;
        else // bad IE  ;)

            rv = document.frames[aID].document;
        return rv;
    }

    function adjustMyFrameHeight()
    {
        var frame = getElement("heightAuto");
        var frameDoc = getIFrameDocument("heightAuto");
        frame.height = frameDoc.body.offsetHeight +0;

    }

</script>
    <iframe onLoad="adjustMyFrameHeight()" name="heightAuto" id="heightAuto" width="100%" style="border:0px;overflow:auto;" >
        	
    </iframe>
</td>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>