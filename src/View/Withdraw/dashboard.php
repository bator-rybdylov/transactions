<h3>You have <?php echo number_format($funds, 2); ?></h3>

<?php
$msg_keys = ['withdraw_success', 'withdraw_error'];
foreach ($msg_keys as $msg_key) {
    if (isset($_SESSION[$msg_key])) {
        echo $_SESSION[$msg_key];
        unset($_SESSION[$msg_key]);
    }
} ?>

<form action="/withdraw" method="post">
    Send <input type="number" value="0.0" min="0.0" step="0.01" name="amount" placeholder="Amount (e.g. 100.50)">

    to <select required name="receiver">
        <?php
        foreach ($receivers as $receiver) { ?>
            <option value="<?php echo $receiver['id'] ?>"><?php echo $receiver['username'] ?></option>
        <?php } ?>
    </select>

    <br>
    <input type="submit" value="Send">
</form>

<a href="/logout">Log out</a>