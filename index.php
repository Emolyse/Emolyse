<?php
    include('includes/header.php');
?>

<div class="logoEmolyse">
    <img src="images/logo.png" alt="logo application Emolyse" id="logoEmolyse"/>
</div>
<a href="experimentateur-accueil.php" class="btn-home btn-experimentateur"><?php if(BTN_EXPERIMENTATEUR_HOME != ''){echo BTN_EXPERIMENTATEUR_HOME;}else{ echo('BTN_EXPERIMENTATEUR_HOME');}; ?></a>
<a href="participant-accueil.php" class="btn-home btn-participant"><?php if(BTN_PARTICIPANT_HOME != ''){echo BTN_PARTICIPANT_HOME;}else{ echo('BTN_PARTICIPANT_HOME');}; ?></a>

</body>
</html>