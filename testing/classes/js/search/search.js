var query;

function StartSearch()
{
    query = document.getElementById('searchfield').value;
    window.location = 'https://www.inventshare.co/testing/search/search.php';
}

function DoThing()
{
    alert(query);
}