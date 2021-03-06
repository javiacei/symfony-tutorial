function addForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a element" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addFormDeleteLink($newFormLi);
}

function addFormDeleteLink($formLi) {
    var $removeFormA = $('<a href="#">delete</a>');
    $formLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();

        // remove the li for the tag form
        $formLi.remove();
    });
}
