$(function(){
    function add() {
        var collectionHolder = $('#form_redirectUris');
        var prototype = collectionHolder.attr('data-prototype');
        form = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);
        collectionHolder.append(form);
    }

    $('a.jslink').live('click', function(event){
        event.preventDefault();
        add();
    });
});