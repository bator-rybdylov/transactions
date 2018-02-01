<h3>You have <?php echo $funds; ?></h3>

<?php if (isset($_SESSION['withdraw_error'])) {
    echo $_SESSION['withdraw_error'];
    unset($_SESSION['withdraw_error']);
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