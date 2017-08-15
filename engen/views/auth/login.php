<?php $this->layout('admin::auth/layout') ?>


        <form method="POST" action="<?= $this->route('engen.login.do') ?>" data-ajaxform="login" data-ajaxform-button="login-submit-btn">

            <input type="hidden" name="token" value="<?= $this->csrfToken('login') ?>" />

            <h1>Login</h1>

            <div class="form-item">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" />
            </div>

            <div class="form-item">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" />
            </div>

            <div class="form-item">
                <button id="login-submit-btn">Log in</button>
            </div>

        </form>

        <script>document.getElementById('username').focus();</script>