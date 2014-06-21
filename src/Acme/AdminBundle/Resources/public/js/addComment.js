var $collectionHolder;

// setup an "add a comment" link
var $addCommentLink = $('<a href="#" class="add_comment_link">Add a comment</a>');
var $newLinkLi = $('<li></li>').append($addCommentLink);

$(document).ready(function() {
    // Get the ul that holds the collection of comments
    $collectionHolder = $('ul.comments');

    // add the "add a comment" anchor and li to the comments ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addCommentLink.on('click', function(e) {
        e.preventDefault();

        // add a new comment form (see code in file addForm.js)
        addForm($collectionHolder, $newLinkLi);
    });
});
