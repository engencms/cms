<?php $this->layout('admin::layout') ?>

<?php
if ($user->id && !$this->isMe($user->id)):
    $this->start('sub-nav')
?>

    <a href="<?= $this->route('engen.users.delete') ?>" id="delete-sub-nav-btn" data-ref="<?= $user->id ?>" data-token="<?= $this->csrfToken('delete-user')?>">
       <span class="icon delete"></span>Delete this user
    </a>

<?php
    $this->stop();
endif;
?>


    <form method="post" action="<?= $this->route('engen.users.save') ?>" id="form-edit-user" data-ajaxform="user-edit" data-ajaxform-button="edit-user-submit">

        <input type="hidden" name="id" id="frm-id" value="<?= $user->id ?>" />
        <input type="hidden" name="token" value="<?= $this->csrfToken('edit-user') ?>" />

        <div class="content-inner size-medium">

            <div class="form-columns col-1-2">

                <div class="form-item">
                    <label for="frm-username">Username</label>
                    <input type="text" id="frm-username" name="username" value="<?= $this->e($user->username) ?>" />
                </div>

                <div class="form-item">
                    <label for="frm-email">E-mail</label>
                    <input type="text" id="frm-email" name="email" value="<?= $this->e($user->email) ?>" />
                </div>

            </div>

            <div class="form-columns col-1-2">

                <div class="form-item">
                    <label for="frm-first_name">First name</label>
                    <input type="text" id="frm-first_name" name="first_name" value="<?= $this->e($user->first_name) ?>" />
                </div>

                <div class="form-item">
                    <label for="frm-last_name">Last name</label>
                    <input type="text" id="frm-last_name" name="last_name" value="<?= $this->e($user->last_name) ?>" />
                </div>

            </div>

            <h2 class="form-heading">Change password</h2>

            <p class="form-description">If you don't want to change the password, leave the two fields below empty.</p>

            <div class="form-columns col-1-2">

                <div class="form-item">
                    <label for="frm-password">Password</label>
                    <input type="password" name="password" />
                </div>

                <div class="form-item">
                    <label for="frm-password_confirm">Confirm password</label>
                    <input type="password" name="password_confirm" />
                </div>

            </div>

        </div>


        <div id="form-actions">
            <button type="submit" class="confirm" id="edit-user-submit">
                <span>Save</span>
            </button>
        </div>

    </form>
