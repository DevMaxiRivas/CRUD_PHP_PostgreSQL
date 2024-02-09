document.addEventListener('DOMContentLoaded',
    function () {
        $('#tbody-table').find('tr').each(
            function(){
                let bd = $(this).attr('id').split('-')[0];
                let name = $(this).attr('id').split('-')[1];
                $(this).children(":last-child").children(":last-child").attr('href', 'show_rows.php?db='+ bd +'&name=' + name);
            }
        );
    }
);