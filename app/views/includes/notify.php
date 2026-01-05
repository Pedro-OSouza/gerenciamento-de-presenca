<?php 
    function notification($message){
        if (!empty($message) || $message != null): 
?>
            <div class="notification is-success toggle-closer auto-dismiss">
                <button class="delete toggle-closer-btn"></button>
                <?= htmlspecialchars($message); ?>
            </div>
<?php endif; } ?>