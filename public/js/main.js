/*
 *     RATING BAR
 */

function rate(e, that) {
    var btn = e.target;
    var imageId = btn.parentNode.dataset['imageid'],
        ratingId = btn.dataset['ratingid'],
        userRated = btn.parentNode.dataset['userrated'];

    var none  = 0,
        liked = 1,
        disliked = 2;

    var likeCount = that.siblings('.image-like-count'),
        dislikeCount = that.siblings('.image-dislike-count'),
        likes = parseInt(likeCount.text()),
        dislikes = parseInt(dislikeCount.text());

    var likeBtn = that.siblings('.like-btn'),
        dislikeBtn = that.siblings('.dislike-btn');

    var ratingBar = $('#rating-bar-' + imageId);

    // send info to @RatingController@rate
    $.post({
        url: url,
        data: {
            image_id: imageId,
            rating_id: ratingId,
            user_rated: userRated,
            _token: token
        }
    })
        .done(function () {
            if (that.hasClass('like-btn')) {
                if (that.hasClass('user-liked')) {
                    that.removeClass('user-liked');

                    btn.parentNode.dataset.userrated = none;

                    likes -= 1;
                    likeCount.text(likes);
                } else {
                    if (dislikeBtn.hasClass('user-disliked')) {
                        // remove disliked styling from dislike button
                        dislikeBtn.removeClass('user-disliked');

                        // count one off
                        dislikes -= 1;
                        dislikeCount.text(dislikes);
                    }

                    // add liked styling to like button
                    that.addClass('user-liked');

                    // set new user data
                    btn.parentNode.dataset.userrated = liked;

                    // update rating numbers
                    likes += 1;
                    likeCount.text(likes);
                }
            } else {
                if (that.hasClass('user-disliked')) {
                    that.removeClass('user-disliked');
                    btn.parentNode.dataset.userrated = none;

                    dislikes -= 1;
                    dislikeCount.text(dislikes);
                } else {
                    if (likeBtn.hasClass('user-liked')) {
                        likeBtn.removeClass('user-liked');

                        likes -= 1;
                        likeCount.text(likes);
                    }
                    that.addClass('user-disliked');
                    btn.parentNode.dataset.userrated = disliked;

                    dislikes += 1;
                    dislikeCount.text(dislikes);
                }
            }

            // set width of rating bar
            var width = ((likes + dislikes) > 0) ? (likes / (likes + dislikes)) * 100 : 0;
            ratingBar.css('width', width + '%');
        })
        .fail(function () {
            console.log('fail');
        });
}

$('.row.info-2').find('.image-info-buttons').find('.btn').click(function (event) {
    rate(event, $(this));
});

$('.image-info-section').find('.image-info-buttons').find('.btn').click(function (event) {
    rate(event, $(this));
});



/*
 *    SEARCH BAR
 */

$('#search-btn').click(function () {
    $('#searchbar').toggleClass('show');
    $('#searchbar-clear').toggleClass('show');
    $('#searchbar-input').focus();
});

$('#searchbar-clear').click(function () {
    $('#searchbar').removeClass('show');
    $('#searchbar-clear').removeClass('show');
});