<div class="login-wrapper">
    <div class="main">
        <div class="content">
            <div class="auth-logo">
                <div class="logo">Sign <span>In</span></div>
                <div class="message">
                    <?php if (isset($errors) && is_array($errors)) : ?>
                        <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="auth-section">
                <form action="" method="post">
                    <div class="inputs-wrapp">
                        <div class="input-item">
                            <input type="text" class="input" placeholder="Email" name="email">
                        </div>
                        <div class="input-item">
                            <input type="password" class="input" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="button-wrapp">
                        <input type="submit" class="btn btn-yellow" value="Sing In">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>