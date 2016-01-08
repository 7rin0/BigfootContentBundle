$(document).ready(function()
{
    deletableWidget();

    $( ".body_sidebar_elt" ).each(function()
    {
       $(this).sortable({
           update: function ()
           {
               var inputs = new Array();
               idWrapper = $(this).attr('id');
               inputs = $('#' + idWrapper + ' input.sortable-field');
               var nbElems = inputs.length;
               inputs.each(function(idx)
               {
                   $(this).val(idx);
               });
           }
       });
    });

    $('.widget_elt').sortable({
        connectWith: ".body_sidebar_elt",
        helper: "clone",
        update: function(event, ui)
        {
            var idParent = ui.item.parents('div.body_sidebar_elt').attr('id');
            tabTemp = idParent.split('_');
            widgetName  = $(this).attr('data-name');
            typeBlock   = $(this).attr('data-type');
            idBlock     = $(this).attr('data-id');
            id_sidebar = tabTemp[2];
            positionToDrag = ui.item.prev('div.form_widget_element').index() + 1;

            CreateDynamicForm(widgetName,typeBlock,idBlock,id_sidebar,positionToDrag);

            $(this).html(ui.item);
        }
    });

    $('a.delete-form-dashboard').on(ace.click_event, function() {
        redirectHref = $(this).attr('data-href');
        bootbox.confirm($(this).data('confirm-message'), function(result) {
            if (result) {
                document.location.href = redirectHref;
            }
        });
    });

    $('select#filterCategory').change(function(){
        if ($(this).val() == '') {
            $('div.sidebar_category:hidden').show();
        }
        else {
            $('div.sidebar_category:visible').hide();
            $('div#sidebar_category_' + $(this).val()).show();
        }
    });

});

function clickableHeaderWidget()
{
    $('.header_form_widget_element').unbind('click');

    $('.header_form_widget_element').click(function() {
        $('.body_form_widget_element:visible').slideToggle();
        $(this).parents('div.form_widget_element').children('.body_form_widget_element:hidden').slideToggle();
    });
}

function deletableWidget()
{
    $('.delete_widget_container').click(function()
    {
        $(this).parents('div.form_widget_element').remove();
    });
}

function CreateDynamicForm(widgetName,typeBlock,idBlock,id_sidebar,positionToDrag)
{

    if(typeof(idBlock)==='undefined') {
        idBlock = '';
    }

    path_url = $('#sidebar_container').attr('data-create-block');

    $.ajax({
        url: path_url,
        type: 'GET',
        data: { widget_name : widgetName, id_sidebar : id_sidebar, type_block : typeBlock, id_block : idBlock, position : positionToDrag},
        cache: false,
        success: function(data) {

            countElement = $('#body_sidebar_' + id_sidebar + ' .form_widget_element').length;

            if (positionToDrag == 0) {
                $('#body_sidebar_' + id_sidebar).prepend(data);
            }
            else if (positionToDrag == 1 && countElement == 1) {
                $('#body_sidebar_' + id_sidebar +' div.form_widget_element').after(data);
            }
            else {
                $('#body_sidebar_' + id_sidebar +' div.form_widget_element:eq('+ (positionToDrag - 1) +')').after(data);
            }

            newHref = $('#body_sidebar_' + id_sidebar + ' div.form_widget_element:eq(' + positionToDrag + ')').children('.header_form_widget_element').children(' a.colorbox').attr('href');
            updateAllPosition(id_sidebar);

            $.colorbox({
                href : newHref,
                width : 1024,
                height : 728,
                onComplete : function()
                {
                    setupColorboxScripts();
                    saveOrderBlock(id_sidebar);
                }
            })

            deletableWidget();
        }
    });
}

function updateAllPosition(id_sidebar)
{
    var i = 0;
    $('#body_sidebar_' + id_sidebar + ' input.sortable-field').each(function()
    {
        $(this).val(i);

        i++;
    });

}

function saveOrderBlock(id_sidebar)
{
    var tabIdBlock  = new Array();
    var tabPosition = new Array();
    var typeBlock   = new Array();

    path_url = $('#sidebar_container').attr('data-save-order');

    $('#body_sidebar_' + id_sidebar + ' input.sortable-field').each(function()
    {
        idWrapper = $(this).parents('div.body_form_widget_element').attr('id');

        if (idWrapper) {
            var tabTemp = idWrapper.split('-');
            idBlockWrapper = tabTemp[1];
            tabIdBlock.push(idBlockWrapper);
            tabPosition.push($(this).val());
            typeBlock.push(tabTemp[0]);
        }
    });

    $.ajax({
        url: path_url,
        type: 'GET',
        data: { tabIdBlock : tabIdBlock,  tabPosition : tabPosition, id_sidebar : id_sidebar, typeBlock : typeBlock},
        cache: false,
        success: function(data) {}
    });
}
