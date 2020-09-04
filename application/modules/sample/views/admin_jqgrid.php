<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.8.13/themes/base/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="http://www.trirand.com/blog/jqgrid/themes/ui.jqgrid.css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.13/jquery-ui.js"></script>
<script type="text/javascript" src="http://www.trirand.com/blog/jqgrid/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="http://www.trirand.com/blog/jqgrid/js/i18n/grid.locale-en.js"></script>

<table id="tblJQGrid"></table>
<div id="divPager"></div>
<script language="javascript" type="text/javascript">
    $(document).ready(function() {
        createUserGrid();
    });

    function createUserGrid() {
        $("#tblJQGrid").jqGrid({
            url: '<?php echo base_url().get_current_section($this); ?>/sample/jqgrid_show/',
            datatype: "json",
            height: 231,
            width: 937,
            colNames: ['Number', 'Title', 'Description'],
            colModel: [
                {name: 'id', index: 'id', width: 60, sorttype: "int"},
                {name: 'title', index: 'title', width: 100},
                {name: 'amount', index: 'amount', width: 80, align: "right", sorttype: "float"}
            ],
            //multiselect: true,
            rowNum: 2,
            rowList: [2, 4, 6,8,10],
            loadonce: false,
            pager: '#divPager',
            caption: "Sample Data"
        });
    }
</script>