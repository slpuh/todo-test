<div class="main">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-4">
                    <div class="login-wrapper">
                        <div class="auth-logo">
                            <div class="logo">Hello <span><?= $user['name'] ?></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-2"> </div>
                <div class="col-4">
                    <div class="button-task">
                        <a href="/cabinet/addtask" class="btn btn-yellow">+ Add New Task</a>
                    </div>
                </div>
            </div>
            <div class="block-view">
                <div class="row row-flex">
                    <?php if (!empty($tasks)) : ?>
                        <?php foreach ($tasks as $task) : ?>
                            <?php if ($task['parent_id'] == 0) : ?>
                                <div class="col-4">
                                    <div class="block-item card-task">

                                        <div class="info-item status status-<?= $task['status'] == 0 ?  "warning"  :  "process" ?> h3-main date-task">
                                            <?= date("d.m.y H:i", strtotime($task['finish'])); ?></div>

                                        <div class="info-item name h3-main"><?= $task['title'] ?></div>

                                        <div class="info-item date"><?= $task['text'] ?></div>
                                        <div class="task-action">                                                                                    
                                            <a href="/cabinet/addsubtask/<?= $task['id'] ?>"><i class="gj-icon">plus</i></a>
                                            <a href="/cabinet/edittask/<?= $task['id'] ?>"><i class="gj-icon">pencil</i></a>
                                            <a href="/cabinet/closetask/<?= $task['id'] ?>"><i class="gj-icon">clear</i></a>
                                            <a href="/cabinet/deletetask/<?= $task['id'] ?>"><i class="gj-icon">delete</i></a>
                                        </div>
                                        <?php if (!empty($subTasks)) : ?>

                                            <?php foreach ($subTasks as $subTask) : ?>
                                                <?php if ($subTask['parent_id'] == $task['id']) : ?>
                                                    <div class="block-item card-subtask ">
                                                        <div class="info-item status status-<?= $subTask['status'] == 0 ?  "warning"  :  "process" ?> h3-main date-task">
                                                        <?= date("d.m.y H:i", strtotime($subTask['finish'])); ?>
                                                    </div>
                                                        <div class="info-item name h3-main"><?= $subTask['title'] ?></div>
                                                        <div class="info-item date"><?= $subTask['text'] ?></div>
                                                        <div class="task-action">
                                                            <a href="/cabinet/edittask/<?= $subTask['id'] ?>"><i class="gj-icon">pencil</i></a>
                                                            <a href="/cabinet/closetask/<?= $subTask['id'] ?>"><i class="gj-icon">clear</i></a>
                                                            <a href="/cabinet/deletetask/<?= $subTask['id'] ?>"><i class="gj-icon">delete</i></a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>