<?php $this->layout('admin::auth/layout') ?>

    <div id="login-box" class="login-view">

        <h1><span class="fa fa-lock icon"></span>Log in</h1>

        <div class="login-wrapper-inner">

            <form method="POST" action="<?= $this->route('engen.login.do') ?>" data-ajaxform="login" data-ajaxform-button="login-submit-btn">

                <input type="hidden" name="token" value="<?= $this->csrfToken('login') ?>" />


                <div class="form-item">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="focus" />
                </div>

                <div class="form-item">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" />
                </div>

                <div class="form-item">
                    <button id="login-submit-btn">Log in</button>
                </div>

                <div class="links">
                    <a href="#" class="login-view-btn" data-show="login-forgot-box">Forgot your password?</a>
                </div>

            </form>

        </div>

    </div>


    <div id="login-forgot-box" class="login-view">

        <h1>Forgot password</h1>

        <div class="login-wrapper-inner">

            <form method="POST" action="<?= $this->route('engen.login.forgot.do') ?>" data-ajaxform="login-forgot" data-ajaxform-button="login-forgot-submit-btn">

                <input type="hidden" name="token" value="<?= $this->csrfToken('login-forgot') ?>" />

                <div id="login-forgot-message">
                    <p>Enter the e-mail address registered on your account and we'll send you an e-mail with reset instructions.</p>

                    <div class="form-item">
                        <label for="email">E-mail address</label>
                        <input type="text" name="email" id="email" class="focus" />
                    </div>

                    <div class="form-item">
                        <button id="login-forgot-submit-btn">Get reset link</button>
                    </div>
                </div>

                <div class="links">
                    <a href="#" class="login-view-btn" data-show="login-box">Back to login</a>
                </div>

            </form>

        </div>

    </div>

    <script>
        document.getElementById('username').focus();
    </script>
