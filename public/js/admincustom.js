var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $SIDEBAR_MENU = $('#accordionSidebar');

// check active menu
// $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('active');

$SIDEBAR_MENU.find('a').filter(function () {
    return this.href == CURRENT_URL;
}).addClass('active').parent('div').parent('div').collapse().parent('li').addClass('active');
$SIDEBAR_MENU.find('a').filter(function () {
    return this.href == CURRENT_URL;
}).parent('li').addClass('active');
