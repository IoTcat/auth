<?php
setcookie("_token", "", time()-3600);
echo '<script>window.location.href="https://login.yimian.xyz/"</script>';
