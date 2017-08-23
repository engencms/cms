<?php $this->layout('admin::auth/layout') ?>


    <h1>Forgot password</h1>

    <div class="login-wrapper-inner">

        <form method="POST" action="<?= $this->route('engen.login.forgot.do') ?>" data-ajaxform="login-forgot" data-ajaxform-button="login-submit-btn">

            <input type="hidden" name="token" value="<?= $this->csrfToken('login-forgot') ?>" />

            <p>Enter the e-mail address registered for your account and an e-mail with reset instructions will be sent to you.</p>

            <div class="form-item">
                <label for="email">E-mail address</label>
                <input type="text" name="email" id="email" />
            </div>

            <div class="form-item">
                <button id="login-submit-btn">Get reset link</button>
            </div>

            <div class="links">
                <a href="<?= $this->route('engen.login') ?>">Back to login</a>
            </div>

        </form>



    </div>

    <script>document.getElementById('username').focus();</script>
