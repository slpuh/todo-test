<div class="main">
    <div class="container">
        <div class="content">
            <div class="login-wrapper">
                <div class="auth-logo">
                    <div class="logo">Edit <span>Task</span></div>
                    <div class="message">
                        <?php if (isset($errors) && is_array($errors)) : ?>
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <form action="" method="post">
                    <div class="inputs-wrapp">
                        <div class="col-1">
                            <div class="input-item">
                                <label class="label">Title</label>
                                <input type="text" name="title" class="input" value="<?= $task['title'] ?>">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="input-item">
                                <label class="label">Expiration Date</label>
                                <input type="text" name="finish" value="<?= date("Y-m-d H:i", strtotime($task['finish'])); ?>" class="input" id="datetimepicker">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="input-item">
                                <label class="label">Description Of Task</label>
                                <textarea name="text" cols="30" rows="10" class="textarea"><?= $task['text'] ?></textarea>
                            </div>
                        </div>

                        <div class="button-wrapp">
                            <a href="/cabinet" class="btn btn-transparent">Back</a>
                            <input type="submit" class="btn btn-yellow" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>