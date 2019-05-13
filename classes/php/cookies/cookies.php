<script>
    function AcceptCookies()
    {
        <?php setcookie('cookies', 'donedidit', time() + 60 * 60 * 24 * 61, '/', null, true, true); ?>;
        document.getElementsByClassName('cookies')['0'].parentNode.removeChild(document.getElementsByClassName('cookies')['0']);
    }
</script>
<!DOCTYPE html>
<html>
    <body>
        <div class="cookies" style="position: fixed; width: 100vw; height: 30px; bottom: 0px; left: 0px; background-color: #2db950; text-align: center;">
            <text style="font-family: 'Sansation'; font-size: 20px; line-height: 30px; color: white;">We use cookies! Click <a href="https://inventshare.co/legal/privacy-policy">here</a> to learn more.</text>
            <input type="button" value="OK!" style="height: 20px; width: 40px; background-color: #238f3f; outline: none; border: none; font-family: 'Sansation'; color: white; padding: 0px;" onclick="AcceptCookies()">
        </div>
    </body>
</html>